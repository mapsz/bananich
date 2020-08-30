<template>
  <div>
    <h3>Категории</h3>

    <!-- List -->
    <h5>Текущие</h5>
    <ul>
      <li v-for='(category,i) in product.categories' :key='i'>
        <span @click="detach(category.id)" style="cursor:pointer">❌</span>   {{category.id}} {{category.name}}
      </li>
    </ul>
    <h5>Добавить</h5>
    <ul>
      <li v-for='(category,i) in categories' :key='i'>
        <span @click="atach(category.id)" style="cursor:pointer">➕</span>   {{category.id}} {{category.name}}
      </li>
    </ul>


  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  computed:{
    ...mapGetters({product:'product/getOne',categories:'category/get'}),
  },
  mounted(){
    this.get();
  },
  methods:{    
    ...mapActions({
      'get':'category/fetchData',
    }),
    async detach(id){
      await ax.fetch('/category/detach',{productId:this.product.id,categoryId:id},'post');
      location.reload()
    },
    async atach(id){
      await ax.fetch('/category/atach',{productId:this.product.id,categoryId:id},'post');
      location.reload()
    }
  },
}
</script>

<style>

</style>