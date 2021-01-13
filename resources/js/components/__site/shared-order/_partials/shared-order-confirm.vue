<template>
<div class="">
    
  <div class="">
    <button @click="active=0;active=1;" class="x-btn">✅ <b>Завершить оформление заказа</b></button>
  </div>
          
  <x-popup :title="'order confirm'" :active="active" id="share-order-confirm">
      <div class="m-3">
        какой-то текст
      </div>
      <div style="justify-content: space-evenly; display:flex">
        <button @click="active=false" class="x-btn x-btn-trans">Отмена</button>
        <button @click="doConfirm()" class="x-btn">Завершить</button>
      </div>
  </x-popup>
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
data(){return{
  active:false,
}},

methods:{
  ...mapActions({
    'get':'sharedOrder/fetchData',
  }),
  async doConfirm(){    
    let r = await ax.fetch('/shared/order/confirm',{},'post');    
    if(r){
      this.get();
      this.active = false;
    }
  }
},
}
</script>

<style>

</style>