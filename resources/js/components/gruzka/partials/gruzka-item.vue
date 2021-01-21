<template>
<div>
  <div class="container">

    <!-- Image -->
    <div class="product-image justify-content-center row mt-3">      
      <img 
        :src="item.image" 
        alt=""
      >
    </div>
    <!-- Name -->
    <div class="row mt-2 justify-content-center">
      {{item.name}}
    </div>
    <!-- Count -->
    <div class="row mt-3 justify-content-between">
      <span>Кл-во: {{item.quantity}}</span>  
      <span>За единицу: {{item.gram}}</span>  
    </div>
    <!-- Polka -->
    <div class="row mt-3 justify-content-between" v-if="item.gruzka_priority != undefined">
      Полка: {{item.gruzka_priority}}
    </div>
    <!-- Comment -->
    <div v-if="item.comment" class="row mt-2">
      <span><b>Комментарий к продукту: </b><i>{{item.comment}}</i></span>
    </div>

    <!-- Fixed Footer -->
    <div class="under-fixed-bottom"></div>
    <div class="fixed-bottom" style="">
      <!-- Summary -->
      <div v-if="orderStatus != 1" class="row m-0 justify-content-center">
        <span style="align-self: flex-end;">Всего:</span>        
        <span class="quantity-expect"><b>{{expect_quantity}} </b></span>
        <span  
          v-if="item.discount != undefined && item.quantity == item.discount.quantity" 
          style="
            color: red;
            font-size: 10pt;
            padding-left: 5px;
            align-self: flex-end;        
          "
        >
        🦜(Не больше!) 
        </span>
      </div>
      <!-- Is success -->
      <div v-if="orderStatus == 1" class="text-center text-success mt-3" style="font-size:16pt">
        Заказ успешно доставлен
      </div>
      <!-- Input Gram-->
      <div v-if="orderStatus != 1" class="form-group m-2">
        <input 
          v-model="quantity"
          pattern="\d*"
          type="tel" 
          class="form-control" 
          placeholder="Количество"
          id="quantity-input"
        >
      </div>
      <!-- Input Container-->
      <div v-if="0" class="mx-2">
        <div 
          class="row mx-0"
          :class="i > 0 ? 'mt-1' : ''"
          v-for="i in containersQuantity" 
          :key="i-1"           
        >
          <!-- Container input list -->
          <div class="p-0" :class="i == containersQuantity ? 'col-8' : 'col-10'">
            <select v-model="containers[i-1].id" class="custom-select"  :id="'container-input-'+(i-1)">
              <option selected value="-1">Выберите тару...</option>
              <option value="0">Нету</option>
              <option v-for="c in containerList" :key="c.id" :value="c.id">
                {{c.name}}
              </option>
            </select>
          </div>   
          <!-- Container input quantity -->
          <div class="col-2 p-0">
            <input v-model="containers[i-1].quantity" type="number" class="form-control" :id="'container-quantity-input-'+(i-1)">
          </div>
          <!-- Container add -->
          <div v-if="i == (containersQuantity)" class="add-container col-2 p-0">            
            <button @click="addContainer()" class="btn btn-outline-success">+</button>
          </div>
        </div>
      </div>    
      <!-- Actions -->
      <div class="actions mx-0 my-2">
        <!-- Buttons -->
        <div class="action-buttons mx-0 d-flex justify-content-between">
          <!-- No item -->
          <button
            v-if="orderStatus != 1"
            class="btn-main btn-no-item btn" 
            :class="
              itemStatus == 200 ? 'btn-danger' : 'btn-outline-danger'
            "
            @click="noItem()"
          >
            <font-awesome-icon icon="times" />
          </button>
          <!-- Prev -->
          <button class="btn-change btn btn-info" @click="$emit('prev')">
            <font-awesome-icon icon="arrow-left" />
          </button>
          <!-- Next -->
          <button class="btn-change btn btn-info" @click="$emit('next')">
            <font-awesome-icon icon="arrow-right" />
          </button>
          <!-- Confirm -->
          <button
            v-if="orderStatus != 1"
            class="btn-main btn-confirm btn" 
            :class="
              itemStatus == 300 ? 'btn-success' : 'btn-outline-success'
            "
            @click="confirm()"
          >
            <font-awesome-icon icon="check" />
          </button>
        </div>
        <!-- Warning info -->
        <div class="warning-info" style="display:none">
          <b>
            {{warningText}}
          </b>          
        </div>        
      </div>
    </div>

  </div>

</div>
</template>

<script>
  export default {
    props: ['item','container-list','order'],
    data(){
      return {
        max_difference:2,
        big_difference:false,
        slot:{default: this.$createElement('loader-icon'),},
        id:this.item.id,   
        expect_quantity:Math.round((this.item.gram_sys * this.item.quantity) * 1000) / 1000,     
        quantity:this.item.quantity_result,        
        containers:[{id:-1,quantity:null}],
        containersQuantity:1,
        warningText: false,        
      }
    },
    computed:{
      orderStatus (){
        if(this.order == undefined) return false;
        if(this.order.statuses == undefined) return false;
        if(this.order.statuses[0] == undefined) return false;

        return this.order.statuses[0].id;
      },
      itemStatus(){
        if(this.item == undefined || this.item.statuses == undefined) return false;
        if(this.item.statuses[0] == undefined) return 100;
        if(this.item.statuses[0].id == undefined) return false;
        return this.item.statuses[0];
      }
    },
    watch:{
      item: {
        handler: function () {
          this.itemWatcher();
        },
        deep: true,
      },
      containers:{
        handler: function () {
          $.each( this.containers, ( k, v ) => {
            if(v.id == 0){
              this.containers[k].quantity = 0;
            }
          });
          this.removeWarning();     
        },
        deep: true,
      },
      containersQuantity:function(){
        setInterval(() => {
          $('.under-fixed-bottom').height($('.fixed-bottom').height() + 10);
        }, 200);        
      },
      id:function(){this.quantity = this.item.quantity_result;},
      quantity:function(){this.removeWarning()},
    },
    async mounted() {
      //Trigger watcher
      this.itemWatcher();

    },
    methods: {
      async confirm(){
        //Refresh inputs
        this.refreshInputClasses();

        //Get quantity
        let quantity = "" + this.quantity;
        //coma to dot
        quantity = quantity.replace(',','.');
        
        //Validate
        //bad number format
        if(quantity.match(/^\d*\.?\d+$/g) == null){
          this.badInput('gram');
          return;
        }
        //number difference
        // if(this.big_difference == false){
        if(this.big_difference == false){
          let max_difference = this.max_difference;        
          if(quantity > (this.expect_quantity * max_difference)){
            this.setWarning('gram','Большая разница! Подтвердить?');
            this.big_difference = true;
            return;
          }
          if(quantity < (this.expect_quantity / max_difference)){
            this.setWarning('gram','Большая разница! Подтвердить?');
            this.big_difference = true;
            return;
          } 
        }else{
          this.big_difference == false;
        }

        // Get Container
        // let containers = this.containers; // @@@ containers
        let containers = [{id:0,quantity:0}];
        //Validate
        let containerError = false;
        $.each(containers , ( k, v ) => {
          console.log(v);

          //Set zero if no container
          if(v.id == 0){
            containers[k].quantity = 0;
          }      
          //Not choosed
          if(v.id == -1){
            this.badInput('container',k);
            containerError = true;
          }
          //No quantity
          if(v.id > 0 && v.quantity < 1){
            this.badInput('container-quantity',k);
            containerError = true;
          }
        });
        if(containerError) return;
        
        //Put Gruzka
        let r = await this.jugeAx('/gruzka/confirm',{
          orderId:this.item.order_id,
          itemId:this.item.id,
          itemQuantity:quantity,
          containers:containers,
        },'put');   

        //Success
        if(r){
          let item = this.item;
          item.quantity_result = this.quantity;
          item.containers = this.containers;
          item.statuses = [{id:300,name:"Погружен"}];     
          this.$emit('confrim',item);
          this.$emit('next');
        } 
        
      },
      async noItem(){
        this.quantity = 0;
        this.containersQuantity = 1;
        this.containers = [{id:-1,quantity:null}];

        //Put Gruzka
        let r = await this.jugeAx('/gruzka/noitem',{
          itemId:this.item.id,
        },'put');  

        if(r){
          let item = this.item;
          item.quantity_result = this.quantity;
          item.containers = this.containers;
          item.statuses = [{id:200,name:"Нет на складе"}];
          this.$emit('no-item',item);
          this.$emit('next'); 
        } 
      },
      itemWatcher(){
        this.quantity = this.item.quantity_result;
        this.expect_quantity = Math.round((this.item.gram_sys * this.item.quantity) * 1000) / 1000;
        if(this.item.containers.length > 0){
          this.containers = this.item.containers;
          this.containersQuantity = this.item.containers.length;
        }else{
          this.containers = [{id:-1,quantity:null}];
          this.containersQuantity = 1;
        }
      },
      addContainer(){
        let i = this.containersQuantity-1;
        let prev = this.containers[i];
        //Remove error inputs
        this.removeBadInput('container',i);
        this.removeBadInput('container-quantity',i);
        //Validate
        let val = false;
        if(!(prev.id > 0)){
          this.setWarning('container',null,i);
          val = true;
        }        
        if(prev.quantity == undefined || prev.quantity < 1){
          this.setWarning('container-quantity',null,i);
          val = true;
        }
        if(val) return;
        //Add Container        
        this.containers.push({id:-1});
        this.containersQuantity++;
      },
      badInput(type,i = 0){
        if(type == 'gram'){
          $('#quantity-input').addClass('error');
          return;
        }
        if(type == 'container'){
          $('#container-input-'+i).addClass('error');
          return;
        }
        if(type == 'container-quantity'){
          $('#container-quantity-input-'+i).addClass('error');
          return;
        }
      },
      removeBadInput(type,i = 0){
        if(type == 'container'){
          $('#container-input-'+i).removeClass('error');
          return;
        }
        if(type == 'container-quantity'){
          $('#container-quantity-input-'+i).removeClass('error');
          return;
        }        
      },
      setWarning(type,text = null,i=0){
        //Set input
        if(type == 'gram'){
          $('#quantity-input').addClass('warning');
        }
        if(type == 'container'){
          $('#container-input-'+i).addClass('warning');
          return;
        }
        if(type == 'container-quantity'){
          $('#container-quantity-input-'+i).addClass('warning');
          return;
        }

        if(text){
          //Set warning text
          this.warningText = text;
          $('.fixed-bottom').addClass('warning');
          // .fixed-bottom
        }
      },
      refreshInput(){
        this.quantity=null;
        this.container=-1;
        this.containerQuantity=null;
        this.refreshInputClasses();
      },
      refreshInputClasses(){
        $('.error').removeClass('error');
        this.removeWarning();
      },
      removeWarning(){
        $('.warning').removeClass('warning');
        this.warningText = false;
      }
    },

  }
</script>

<style scoped>
.under-fixed-bottom{
  width: 100%;
  height: 195px;
}
.fixed-bottom{
  z-index:100; 
  background-color: #ebffeb;
  border-top: 1px solid green;
}

.action-buttons button{
  width:15%;
}

.action-buttons button.btn-main{
  width:20%;
  padding: 15px 0;
}

.product-image img{
  max-height: 125px;
  max-width: 100%;
}

.error{
  border:2px solid;
  border-color: red !important;
}
/* Quantity Result */
.quantity-expect{
  font-size: 14pt;
  padding-left: 5px;
}
/* Containers */
.add-container{
  display: flex;
  justify-content: flex-end;  
}
/* Warning */
.warning{
  border:2px solid;
  border-color: #FF9800 !important;
}
.fixed-bottom.warning .action-buttons{
  width:50%;
}
.fixed-bottom.warning .actions{
  display:flex;
}
.fixed-bottom.warning .btn-change, .fixed-bottom.warning .btn-no-item{
  display:none;
}
.fixed-bottom.warning .btn-confirm{
  width:40% !important;
}
.fixed-bottom.warning .btn-confirm{
  margin-left:50% !important;
}
.fixed-bottom.warning .warning-info{
  display:block !important;
  color: #852c00;
}


</style>