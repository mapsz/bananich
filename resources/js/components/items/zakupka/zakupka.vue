<template>
  <div>

    <!-- Filters -->
    <div class="row m-3 mb-2 order-menu justify-content-between">
      <order-status-filter  :model="model" />
      <item-status-filter  :model="model" />
      <suppliers-filter :model="model" />
    </div>


    <!-- List -->
    <juge-list :data="model" 
      :keys="[
        {'key':'name','label':'товар'},
        {'key':'summ','label':'сумма'},
        {'key':'suppliers','label':'поставщик'},
      ]"
    />

  </div>
</template>

<script>

import {mapGetters, mapActions} from 'vuex';
export default {
data(){return{
  model:'item'
}},
async mounted() {
  this.addFilter({beautySuppliers:true});
},
methods:{
  ...mapActions({      
    addFilter:'item/addFilter',
  }),   
},
 
}
</script>

<style>

</style>