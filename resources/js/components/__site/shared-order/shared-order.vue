<template>
  <div>
    <site-header/>
    
      <div class="container">

        <h1 class="m-3">Формирование коллективной закупки</h1>

        <!-- Loading -->
        <div v-if="!sOrder" class="d-flex m-5" style="justify-content: center;">
          <span style="font-size: 48pt;">🍌🍌</span>
        </div>

        <div v-if="sOrder" class="row">
          <div class="col-6">
            Детали заказа
          </div>
          <div class="col-6">
            Участники
          </div>

        </div>

      </div>

    <site-footer/>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
computed:{
  ...mapGetters({
    sOrders:'sharedOrder/get',
  }),
  link (){
    if(this.$route == undefined || this.$route.params == undefined || this.$route.params.order_link == undefined) return false;    
    return this.$route.params.order_link;
  },
  sOrder (){
    if(this.sOrders == undefined || this.sOrders.lenth < 1) return false;

    return this.sOrders[0];
  }
},
async mounted() {
  //Open shared order
  if(!this.link){
    this.open();
  }
  //Get shared order
  else{
    console.log('get');
    await this.filter({'link':this.link});
    await this.get();    
  }
},
methods:{
  ...mapActions({
    'filter':'sharedOrder/addFilter',
    'get':'sharedOrder/fetchData',
  }),   
  async open(){
    let r = await ax.fetch('/shared/order/open',{},'put');

    if(r){
      console.log(r);
      window.location.href = '/shared/order/'+r.link;
    }
  }
},
}
</script>

<style>

</style>