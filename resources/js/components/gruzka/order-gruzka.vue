<template>
<div class="container-fluid">
  <gruzka-navbar></gruzka-navbar>

  <!-- Order -->
  <div class="row my-2 justify-content-center text-primary">
    <span 
      class="px-2"
      @click="currentItem = -1"
      :style="currentItem >= 0 ? 'border:1px solid;border-radius:5px;' : '' "
    >
      <font-awesome-icon v-if="currentItem >= 0" icon="list" /> 
      <b>Заказ: {{orderId}}</b>      
    </span>
  </div>

  <!-- Comment -->
  <div v-if="order.comment_our && currentItem == -1" class="my-3">
    <b>Комментарий к заказу:</b> {{order.comment_our}}
  </div>

  <div v-if="currentItem == -1" class="mb-3">
    <!-- list -->
    <div class="items-list col-12 p-0">
      <div 
        class="item d-flex justify-content-between"
        v-for="(item,k) in items" 
        :key="item.id"         
      >
        <div style="flex:5">
          <div class="d-flex justify-content-between">            
            <b>{{item.name}}</b>
            <span>Полка: {{item.product.gruzka_priority}}</span>  
          </div>
          <div class="d-flex justify-content-between">
            <span style="color:gray">x{{item.quantity}}</span>
            <span 
              v-if="item.statuses[0] != undefined"
              :style="
                item.statuses[0].id == 100 ? 'color:red' : '' +
                item.statuses[0].id == 200 ? 'color:#d56d00' : '' +
                item.statuses[0].id == 300 ? 'color:green' : ''                
              "
            >
              {{item.statuses[0].name}}
            </span>
          </div>
        </div>
        <div class="m-2 align-self-center text-primary" @click="currentItem = k">
          <font-awesome-icon icon="box-open" /> 
        </div>        
      </div>
    </div>
    
    <!-- Action buttons -->
    <div v-if="done && orderId" class="row mt-3 justify-content-center">
      <button v-if="done == 2" class="btn btn-success" @click="finish(300)">Готово</button>
      <button v-if="done == 3" class="btn btn-warning" @click="finish(400)">Требует досборки</button>
    </div>
  
  </div>

  <gruzka-item 
    v-if="currentItem >= 0" 
    :item="order.items[currentItem]"
    :container-list="containers"
    @prev="prevItem()"
    @next="nextItem()"
    @confirm="confirm"
    @no-item="noItem"
  ></gruzka-item>

</div>
</template>

<script>
export default {  
  data(){
    return {
      slot:{default: this.$createElement('loader-icon'),},
      orderId:0,
      order:{items:[]},
      currentItem:-1,
      done:false,
      containers:[],
    }
  },  
  computed:{
    items: function(){return this.order.items;}
  },
  async mounted(){
    //Get order from route
    this.orderId = this.$route.params.id;

    //Get auto order
    if(!this.orderId){
      await this.getAutoOrder();
    }

    //Start gruzka
    await this.startOrder();

    //Get Containers
    this.getContainers();

    //Get order
    await this.getOrder();    
    this.checkDone();


  },  
  methods:{
    async getContainers(){
      let r = await this.jugeAx('/json/containers');
      this.containers = r;
    },
    async getOrder(){
      let r = await this.jugeAx('/json/orders', {id:this.orderId,gruzka_priority:true});

      if(!r) return false;
        
      this.order = r;
      return true;
    },
    async getAutoOrder(){
      let l = this.$loading.show({},this.slot);
      let r = await axios.get('/gruzka/auto/order')
        .then((r)=>{
          this.orderId = r.data;
        }) 
        
      l.hide();
    },
    async startOrder(){
      let l = this.$loading.show({},this.slot);
      let r = await axios.put('/order/status',{orderId:this.orderId,statusId:500})
        .then((r) => {
          return;
        })

      l.hide();
    },    
    prevItem(){
      let l = this.$loading.show({},this.slot);
      this.currentItem--;
      l.hide();
    },
    nextItem(){
      let l = this.$loading.show({},this.slot);
      if(this.currentItem+1 >= this.order.items.length){
        this.currentItem = -1;        
        l.hide();
        return;
      }
      this.currentItem++;
      l.hide();
    },

    async confirm(item){
      let i = await this.order.items.findIndex(x => x.id == item.id)
      this.order.items[i] = item;
      this.checkDone();
    },

    async noItem(item){
      let i = await this.order.items.findIndex(x => x.id == item.id)
      this.order.items[i] = item;
      this.checkDone();
    },

    async checkDone(){
      //Check no items
      if(this.order.items.length < 1){
        this.done = false;
        return;
      } 

      //Check not touched items
      let noTouchItems = false;
      await $.each(this.order.items, ( key, v ) => {
        if(v.statuses[0] == undefined || v.statuses[0].id == 100){
          noTouchItems = true;
          return true;
        }
      });
      if(noTouchItems){
        this.done = false;
        return false;
      }

      //Get order items
      let orders = await this.getOrder();
      if(! orders){
        this.done = false;
        return;        
      }

      //Check item statuses
      let done = 2;
      await $.each(this.order.items, (k, v) => {
        //No status
        if(v.statuses[0] == undefined){
          done = false;
          return;
        }
        //Not "Нет на складе" and "Погруже"
        if(v.statuses[0].id != 300 && v.statuses[0].id != 200){
          done = false;
          return;          
        }
        if(v.statuses[0].id == 200){
          done = 3;
        }

      });
      this.done = done;
      

      // false = не готов
      // 2 = готово
      // 3 = требует догрузки
      return;
    },
    async finish(status){
      let r = await this.jugeAx('/gruzka/done', {data:{orderId:this.orderId,statusId:status}},'put');

      if(!r){
        window.location.reload()
        return;
      } 

      if(r == 1){
        this.orderId = 0;
        window.location.href = '/gruzka'
      }
    }
  }
}
</script>

<style scoped>
  .items-list{
    border-top: 2px dashed black;
    border-bottom: 2px dashed black;
  }
  .items-list .item{
    border-bottom:1px solid gray;
  }
  .items-list .item:last-child{
    border-bottom:0px solid gray;
  }
</style>