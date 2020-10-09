<template>
<div>
  <h3>
    Термобокс
  </h3>
  <div class="d-flex">
    <span class="pr-2" :style="!value ? 'font-weight: 600;' : ''">Нет</span>   
    <b-form-checkbox v-model="value" @change="publish" switch></b-form-checkbox> 
    <span :style="value ? 'font-weight: 600;' : ''">Да</span>
  </div>
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
data(){return{
  value:false,
}},
computed:{
  ...mapGetters({product:'product/getOne'}),
},
watch: {
  product: {
    handler: function (val, oldVal) {    
      if(this.product.termobox == undefined || this.product.termobox == '0'){
        this.value = false;
      }else{
        this.value = true;
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
    this.post({'termobox':bonus,'id':this.product.id});
    location.reload();
  }
},
}
</script>

<style>

</style>