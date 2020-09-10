<template>
<div>
  <h3>
    Опубликован    
  </h3>
  <div class="d-flex">
    <span class="pr-2" :style="!published ? 'font-weight: 600;' : ''">Нет</span>   
    <b-form-checkbox v-model="published" @change="publish" switch></b-form-checkbox> 
    <span :style="published ? 'font-weight: 600;' : ''">Да</span>
  </div>
</div>
</template>

<script>
import {mapGetters} from 'vuex';
export default {
data(){return{
  published:false,
}},
computed:{
  ...mapGetters({product:'product/getOne'}),
},
watch: {
  product: {
    handler: function (val, oldVal) {    
      if(this.product.publish == undefined){
        this.published = false;
      }else{
        this.published = true;
      } 
    },
    deep: true
  },  
},
methods:{
  async publish(publish){
    let r = await ax.fetch('/product/publish',{publish,'productId':this.product.id},'post');
    location.reload();
  }
},
}
</script>

<style>

</style>