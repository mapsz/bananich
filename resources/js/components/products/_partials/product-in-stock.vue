<template>
  <div>
    <h3>В наличии</h3>
    
    <div>
      <h5>Доступно</h5>
      <span>{{parseFloat(product.summary - reserve.summ)}}</span>
      <span v-if="parseFloat(product.summary - reserve.summ) != parseFloat(product.available)" style="color:red">{{parseFloat(product.available)}}</span>
    </div>

    <div>
      <h5>Всего</h5>
      <span>{{parseFloat(product.summary)}}</span>
    </div>

    <div v-if="reserve">
      <h5>В резерве</h5>
      <span>{{parseFloat(reserve.summ)}}</span>
      <span style="font-size: 10pt;color: gray;font-style: italic;">{{reserve.orders}}</span>
    </div>


  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    reserve:false,
  }},

computed:{
  ...mapGetters({product:'product/getOne'}),
},
watch: {
  product: {
    handler: function (val, oldVal) {
      if (this.product.id != undefined) {
        this.getItemInOrders();
      }
    },
    deep: true
  }
},
methods:{
  async getItemInOrders(){
    let r = await ax.fetch('/juge?model=item',{'ItemsInReserve':1,'productId':this.product.id});
    this.reserve = r;
  }
},
}
</script>

<style>

</style>