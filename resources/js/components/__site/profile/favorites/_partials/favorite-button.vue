<template>  
  <span @click="doFavorite();">
    <svg display="none">
      <symbol id="like" viewBox="0 0 23 20">
        <path d="M21.1754 1.95726C19.9848 0.695126 18.3511 0 16.5749 0C15.2473 0 14.0314 0.410249 12.961 1.21926C12.4209 1.62762 11.9315 2.12723 11.5 2.71036C11.0687 2.1274 10.5791 1.62762 10.0388 1.21926C8.96858 0.410249 7.75271 0 6.42506 0C4.64889 0 3.01503 0.695126 1.82442 1.95726C0.648033 3.20464 0 4.90876 0 6.75591C0 8.65708 0.724892 10.3974 2.28119 12.2329C3.67342 13.8747 5.67437 15.5415 7.99153 17.4714C8.78275 18.1306 9.67961 18.8776 10.6109 19.6734C10.8569 19.8841 11.1726 20 11.5 20C11.8273 20 12.1431 19.8841 12.3888 19.6738C13.32 18.8778 14.2174 18.1304 15.009 17.4709C17.3258 15.5413 19.3268 13.8747 20.719 12.2327C22.2753 10.3974 23 8.65708 23 6.75574C23 4.90876 22.352 3.20464 21.1754 1.95726Z" />
      </symbol>
    </svg>
    <svg class="like-icon" :style="exists ? 'fill:red' : ''">
      <use xlink:href="#like"></use>
    </svg>
  </span>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  props: ['product-id'],
  data(){return{
    exists:false,
  }},
  watch: {
    favorites: {
      handler: function (val, oldVal) {
        this.checkExists();
      },
      deep: true
    }
  },
  computed:{
    ...mapGetters({favorites:'favorite/get',}),
  },
  mounted(){
    this.checkExists();
  },
  methods:{
    ...mapActions({
      'put':'favorite/put',
      'remove':'favorite/remove',
    }),
    checkExists(){
      if(this.favorites.findIndex(x => x.product_id == this.productId) > -1){
        this.exists = true;
      }else{
        this.exists = false;
      }
    },
    doFavorite(){
      if(this.exists){
        this.remove(this.productId);
      }else{
        this.put(this.productId);
      }      
    }
  },

}
</script>

<style>

</style>