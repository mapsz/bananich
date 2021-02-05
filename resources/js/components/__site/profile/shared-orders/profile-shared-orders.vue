<template>
<main>
  <div class="container">
    <!-- Breadcrumbs -->
    <breadcrumbs />
    <div class="row content-page">
      <!-- Navbar -->
      <div class="col-lg-4">            
        <profile-navbar></profile-navbar>
      </div>

      <!-- Shared orders -->
      <div class="col-lg-8">          
        <h1>История совместных закупок</h1>
        <!-- List -->
        <template v-if="sOrders">
          <div v-for="(sOrder, i) in sOrders" :key="i">
            <profile-shared-order-item :s-order="sOrder" />

          </div>  
        </template>

      </div>

    </div> 

  </div>
</main>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
data(){return{
  
}},
watch:{
  user: async function (val, oldVal) {
    if(!val) return false;
    if(this.sOrders.length > 0) return false;

    await this.addFilter({customerId:this.user.id})
    await this.addFilter({with_logistic:true})
    await this.fetch();
  },
},
async mounted() {
  location.href= '/profile/orders'
},

computed:{
  ...mapGetters({
    sOrders:    'sharedOrder/get',
    orders:     'order/get',
    user:       'user/get',
  }),
},
methods:{
  ...mapActions({
    // 'filter':'sharedOrder/addFilter',
    // 'get':'sharedOrder/fetchData',
    'addFilter':'order/addFilter',
    'fetch':'order/fetchData'
  }),
}
}
</script>

<style>

</style>