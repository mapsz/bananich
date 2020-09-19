<template>
<div>
  <h3>
    Опубликован    
  </h3>
  <div class="d-flex justify-content-between">
    <div class="d-flex">
      <span class="pr-2" :style="!published ? 'font-weight: 600;' : ''">Нет</span>   
      <b-form-checkbox v-model="published" @change="publish" switch disabled></b-form-checkbox> 
      <span :style="published ? 'font-weight: 600;' : ''">Да</span>
    </div>
    <div class="d-flex">
        <b-form-checkbox v-model="alwaysPublished" @change="alwaysPublish">При отсутсвие на складе</b-form-checkbox>
    </div>
  </div>
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
data(){return{
  published:false,
  alwaysPublished:false,
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
      if(this.product.always_publish == undefined){
        this.alwaysPublished = false;
      }else{
        this.alwaysPublished = true;
      } 
    },
    deep: true
  },  
},
methods:{
  ...mapActions({
    'post':'product/post'
  }),
  async publish(publish){
    let r = await ax.fetch('/product/publish',{publish,'productId':this.product.id},'post');
    location.reload();
  },
  async alwaysPublish(alwaysPublished){
    this.post({'always_publish':alwaysPublished,'id':this.product.id});
    // location.reload();
  }
},
}
</script>

<style>

</style>