<template>
  <div>
    <!-- List -->
    <div v-if="categories != undefined && categories.length > 0">
      <h5>Текущие</h5>
      <ul>
        <li v-for='(category,i) in categories' :key='i'>
          <span @click="$emit('detach',category.id)" style="cursor:pointer">❌</span>   {{category.id}} {{category.name}}
        </li>
      </ul>
    </div>
    <h5>Добавить</h5>
    
    <b-button v-b-toggle.collapse-category-attach variant="outline-primary" size="sm">список</b-button>
      <b-collapse id="collapse-category-attach" class="mt-2">
      <ul>
        <li v-for='(category,i) in allCategories' :key='i'>
          <span @click="$emit('attach',category.id)" style="cursor:pointer">➕</span>   {{category.id}} {{category.name}}
        </li>
      </ul>
    </b-collapse>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  props: ['categories'],
  computed:{
    ...mapGetters({allCategories:'category/get'}),
  },
  mounted(){
    this.get();
  },
  methods:{
    ...mapActions({
      'get':'category/fetchData',
    }),    
  },
}
</script>

<style>

</style>