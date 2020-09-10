<template>
<div>  
  <h3>Продукты</h3>
  
  <!-- Search -->
  <search-product class="my-3" @choose="choosed"/>

  <!-- List -->
  <h5>Текущии</h5>
  <ul>
    <li v-for='(product,i) in category.products' :key='i'>
      <span @click="detach(product.id)" style="cursor:pointer">❌</span>  <a :href="'/admin/product/'+product.id">{{product.id}}</a>  {{product.name}}
    </li>
    <span v-if="category.products != undefined && category.products.length == 0"><i>К категории не привязан не 1 продукт</i></span>
  </ul>

</div>
</template>

<script>
import {mapGetters} from 'vuex';
export default {
  computed:{
    ...mapGetters({category: 'category/getOne',}),    
  },
  methods:{
    async choosed(product){
      await ax.fetch('/category/product/attach',{'productId':product.id,'categoryId':this.category.id},'post');
      location.reload()
    },
    async detach(id){
      await ax.fetch('/category/product/detach',{'productId':id,'categoryId':this.category.id},'post');
      location.reload()
    }
  },

}
</script>

<style>

</style>