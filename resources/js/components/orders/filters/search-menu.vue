<template>
<div>
  <form @submit.prevent="doSearch()">
    <div class="input-group input-group-sm"  style="width: auto;">
      <input v-model="search" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
      <div class="input-group-append">        
        <button class="btn btn-primary" type="submit">
          <font-awesome-icon icon="search" />
        </button>      
      </div>    
    </div>
  </form>
</div>
</template>

<script>
import { faSearch } from '@fortawesome/free-solid-svg-icons';
library.add(faSearch);
import {mapActions} from 'vuex';
export default {
  data() {
    return {
      search:"",
    }
  },
  methods:{
    ...mapActions(['setFilter']),
    doSearch(){
      this.setFilter({search:this.search});
      this.$emit('doSearch',this.search);
    }
  }
}
</script>

<style>

</style>