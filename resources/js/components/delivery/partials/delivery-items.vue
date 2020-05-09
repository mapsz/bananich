<template>
<div>

  <!-- Items -->
  <div 
    :class="item.statuses[0].id == 400 ? 'returned' : ''+(item.statuses[0].id == 401 ? 'partial-returned' : '')"
    class=" py-1 delivery-item "
    v-for='(item,i) in items' :key='i'
  >
    <!-- View -->
    <div v-if="returnId!=item.id" class="d-flex justify-content-between align-items-center">
      <!-- Image -->
      <div style="flex:1;display: flex;justify-content: center;">
        <img 
          :src="item.image" 
          :alt="item.name"
          style="height: 35px;"
        >
      </div>

      <!-- Name/About -->
      <div class="px-1" :style="'flex:' + (item.discount_final_result < 0 ? '4' : '5')">
        <!-- Name -->
        <div>{{item.name}}</div>
        <!-- Price per One -->
        <div style="font-size: 0.8em;">₽{{item.price_one}} за (шт\кг)</div>
      </div>

      <!-- Discount -->
      <div 
        v-if="item.discount_final_result < 0"
        style="
          flex: 1;
          display: flex;
          flex-direction: column;
          align-items: center;      
        "    
      >
        <!-- Emoji -->
        <div>🈹</div>
        <!-- Price Final -->
        <div>{{item.discount_final_result}}</div>
      </div>

      <!-- Quantity/Price -->
      <div 
        class="px-1"
        style="
          flex: 1;
          display: flex;
          flex-direction: column;
          align-items: center;      
        "    
      >
        <!-- Quantity -->
        <div>{{item.quantity_result}}</div>
        <!-- Price Final -->
        <div><b>₽{{item.price_final_result}}</b></div>
      </div>   

      <!-- Actions -->
      <div v-if="edit" @click="returnId = item.id" style="flex:1;text-align: center;cursor:pointer;">
        <span 
          class="delivery-return"
          style="font-size: 20px;"
        >
          ↩️
        </span>
      </div>
    </div>


    <!-- Return -->
    <div v-if="returnId==item.id" class="d-flex justify-content-between align-items-center">
      <!-- Image -->
      <div style="flex:1;display: flex;justify-content: center;">
        <img 
          :src="item.image" 
          :alt="item.name"
          style="height: 35px;"
        >
      </div>

      <!-- Return actions -->
      <div v-if="partialReturnId===false" class="d-flex justify-content-around" style="flex:6;">
        <button @click="itemReturn(item,item.quantity_result)" class="btn btn-danger">Полный возврат</button>
        <button @click="partialReturnId=item.id" class="btn btn-warning">Частичный возврат</button>
      </div>

      <div v-if="partialReturnId==item.id" class="d-flex justify-content-around" style="flex:6;align-items: center;">
        <span>Всего: {{item.quantity_result}}</span>
        <span>Возврат: <input v-model="returnQuantity" type="text" style="width:70px"></span>
        <span @click="itemReturn(item,returnQuantity)" style="font-size: 20px;cursor:pointer;">✔️</span>   
        
      </div>
      <!-- Actions -->
      <div @click="returnId=false;partialReturnId=false;returnQuantity=null" style="flex:1;text-align: center;cursor:pointer;">
        <span 
          class="delivery-return-cancel"
          style="font-size: 20px;"
        >
          ❌
        </span>        
      </div>

    </div>
  </div>

</div>
</template>

<script>
export default {
  props: ['items','edit'],
  data(){return{
    returnId:false,
    partialReturnId:false,
    returnQuantity:null,
  }},
  methods:{
    async itemReturn(item,quantity){

      console.log(quantity);
      
      quantity = quantity.toString().replace(',','.');        
      //Validate
      //bad number format
      if(quantity.match(/^\d*\.?\d+$/g) == null){
        alert('Неверный формат!')
        return;
      }      
      if(quantity){
        if(quantity > item.quantity_result){
          alert('Количество возврата должно быть меньше!');
        }
      }

      let $quantity_result = item.quantity_result - quantity;

      //Set quantity
      let r = await this.jugeAx('/item',{itemId:item.id,quantity_result:$quantity_result},'post');
      if(!r) return;

      //Set status
      let status = 400;
      if(item.quantity_result != quantity) status = 401;

      r = await this.jugeAx('/item/status',{itemId:item.id,statusId:status},'put');
      if(!r) return;

      this.returnId = false;
      this.partialReturnId = false;
      this.returnQuantity = null;

      this.$emit('returnSuccess');

    }
  },
}
</script>

<style scoped>
  .delivery-item{
    border-bottom: 1px solid #cccccc;  
  }
  .delivery-item:first-child{
    border-top: 1px solid #cccccc;  
  }
  .returned{
    border-right: 6px solid red;
  }
  .partial-returned{
    border-right: 6px solid orange;
  }
</style>