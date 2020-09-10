<template>
  <div>
    <h3>Категории</h3>

    <!-- List -->
    <categories-attach-list :categories="product.categories" @detach="detach" @attach="attach" />

  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  computed:{
    ...mapGetters({product:'product/getOne',categories:'category/get'}),
  },
  methods:{
    async detach(id){
      await ax.fetch('/category/product/detach',{productId:this.product.id,categoryId:id},'post');
      location.reload()
    },
    async attach(id){
      await ax.fetch('/category/product/attach',{productId:this.product.id,categoryId:id},'post');
      location.reload()
    }
  },
}
</script>

<style>

</style>