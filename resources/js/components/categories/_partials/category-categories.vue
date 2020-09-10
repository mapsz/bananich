<template>
<div>
  <h3>Категории</h3>

    <!-- List -->
    <categories-attach-list :categories="category.categories" @detach="detach" @attach="attach" />


</div>
</template>

<script>
import {mapGetters} from 'vuex';
export default {
  computed:{
    ...mapGetters({category: 'category/getOne',}),
  },
  methods:{
     async detach(id){
      await ax.fetch('/category/category/detach',{'parent':this.category.id, 'child':id},'post');
      location.reload()
    },
    async attach(id){
      await ax.fetch('/category/category/attach',{'parent':this.category.id, 'child':id},'post');
      location.reload()
    }   
  },
}
</script>

<style>

</style>