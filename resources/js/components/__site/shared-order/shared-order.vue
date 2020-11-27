<template>
  <div>
    <site-header/>
      <!-- Loading -->
      <div v-if="!link" class="d-flex m-5" style="justify-content: center;">
        <span style="font-size: 48pt;">🍌🍌</span>
      </div>
    <site-footer/>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
computed:{
  ...mapGetters({
    sOrder:'sharedOrder/get',
  }),
  link (){
    if(this.$route == undefined || this.$route.params == undefined || this.$route.params.order_link == undefined) return false;    
    return this.$route.params.order_link;
  },
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