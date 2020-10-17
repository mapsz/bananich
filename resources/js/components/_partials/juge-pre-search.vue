<template>
  <div>
    <!-- Search -->
    <form class="" @submit.prevent="doSearch()">
      <div class="input-group input-group-sm"  style="width: auto;">
        <input v-model="search" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="">
        <div class="input-group-append">        
          <button type="submit" class="btn btn-primary">
            <font-awesome-icon icon="search" />
          </button>      
        </div>    
      </div>
    </form>

    <!-- List -->
    <div v-if="showList" class="juge-pre-search-list">
      Рузультат поиска:
      <button @click="showList=false" class="btn btn-sm btn-outline-danger float-right">x</button>
      <hr>
      <div @click="choose(row)" v-for='(row,i) in cData' :key='i' class="juge-pre-search-row">
        {{row.id}}        
        {{row.phone}}
        {{row.name}}
        {{row.email}}
      </div>
      <div v-if="cData.length==0">
        Ничего не найдено 🙈
      </div>
    </div>

  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
props: ['model'],
data(){return{
  search:"",
  showList:false,
}},
computed:{
  cData:function(){
    return this.$store.getters[this.model+'/get'];
  }
},
async mounted(){
  //
},
methods:{
  async doSearch(){    
    this.$router.push({});
    this.$store.dispatch(this.model+'/addFilter',{'search':this.search});    
    this.$store.dispatch(this.model+'/fetchData');    
    this.showList = true;
  },
  choose(row){
    this.$emit('choose',row);
    this.search = "";
    this.showList = false;
  }
},
}
</script>


<style scoped>
  .juge-pre-search-list{
    background-color: white;
    position: absolute;
    border: 1px solid gray;
    border-radius: 0 0 5px 5px;
    padding: 10px;
  }
  .juge-pre-search-row{
    margin-bottom: 5px;
    cursor: pointer;
  }
  .juge-pre-search-row:hover{
    color: green;
    text-decoration: underline;  
  }
</style>