<template>
<div>
  <h3>
    Продукт за бонусы    
  </h3>
  <div class="d-flex">
    <span class="pr-2" :style="!bonused ? 'font-weight: 600;' : ''">Нет</span>   
    <b-form-checkbox v-model="bonused" @change="publish" switch></b-form-checkbox> 
    <span :style="bonused ? 'font-weight: 600;' : ''">Да</span>
  </div>
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
data(){return{
  bonused:false,
}},
computed:{
  ...mapGetters({product:'product/getOne'}),
},
watch: {
  product: {
    handler: function (val, oldVal) {    
      if(this.product.bonus == undefined || this.product.bonus == '0'){
        this.bonused = false;
      }else{
        this.bonused = true;
      } 
    },
    deep: true
  },  
},
methods:{
  ...mapActions({
    'post':'product/post'
  }),
  async publish(bonus){
    this.post({'bonus':bonus,'id':this.product.id});
    location.reload();
  }
},
}
</script>

<style>

</style>