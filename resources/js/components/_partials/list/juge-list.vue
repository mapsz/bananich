<template>
<div>


  <!-- Total / Search / Paginator / Settings -->
  <div class="pre-table-wrapper my-2" style=""> 
    <!-- Search -->
    <div class="pre-table-box box-search" style="">
      <div class="d-flex">
        <juge-search-filter class="mx-2" :model="cDataModelSingle" />
        <juge-id-filter class="mr-2" :model="cDataModelSingle" />
      </div>
    </div>  
    <!-- Paginator -->
    <div class="pre-table-box box-paginator" style="">
      <paginator :pages="cPaginator" @change="fetch"/>
    </div>
    <!-- Total -->
    <div class="pre-table-box box-total" v-if="total > 3 && cData.length > 3">
      <span class="mr-2">Всего: {{total}}</span>
      <span v-if="cPages && cPages.per_page != undefined" style="color:gray">На странице: {{cPages.per_page}}</span>
    </div>   
    <!-- List settings -->
    <div class="pre-table-box box-settings" style="">
      <list-settings v-if="cKeysModelSingle" :model="cKeysModelSingle" :p-keys="cKeys"></list-settings>
    </div>
  </div>

  <!-- List -->
  <!-- :stacked="'md'" -->
  <b-table      
    :head-variant="'dark'" 
    :items="cData"
    :fields="cActiveKeys"   
    striped hover small bordered responsive
    
  >
   <!-- @sort-changed="sort" -->
    <!-- no-local-sorting -->
    <template v-slot:cell()="data">
      <!-- Link -->
      <span v-if="data.field.type == 'link'">
        <a :href="getLink(data.item,data.field)">
          {{ data.value }}
        </a>        
      </span>
      <!-- intToStr -->
      <span v-else-if="data.field.type == 'intToStr'">
        {{data.field.intToStr[data.value]}}
      </span>
      <!-- Count -->
      <span v-else-if="data.field.type == 'count'">
        {{data.value.length}}
      </span>
      <!-- List -->
      <span v-else-if="data.field.type == 'list'">
        <!-- single -->
        <div v-if="data.value.length == 1">
          {{data.value[0][data.field.show]}}
        </div>
        <div v-else-if="data.value.length == 0"></div>
        <!-- list -->
        <div v-else>
          {{data.value.length}}
          <b-button size="sm" @click="doListModal(data.field.label, data.value, data.field.show, $event.target)" class="mr-1">
            Список
          </b-button>
        </div>
      </span>     
      <!-- Image -->
      <span v-else-if="data.field.type == 'image'">
        <img :src="data.value" alt="">
      </span>
      <!-- Custom -->
      <span v-else-if="data.field.type == 'custom'">
        <component :is="data.field.component" :data="data.item" @success="success()"></component>
      </span>           
      <!-- Some type -->
      <span v-else-if="data.field.type != undefined" class="text-danger">
        {{ data.field.type }} <br>
        {{ data.field}}<br>
        {{ data.value }}
      </span>      
      <!-- Default -->
      <span v-else>
        {{ data.value }}
      </span>
    </template> 
  </b-table>

  <!-- Modal -->
  <b-modal :id="listModal.id" :title="listModal.title" ok-only>
    <ul>
      <li v-for='(row,i) in listModal.content' :key='i'>
        {{row[listModal.show]}}
      </li>
    </ul>
  </b-modal>

  <!-- Total / Paginator-->
  <div class="d-flex mb-2" style="align-items: center;">
    <!-- Total -->
    <div v-if="total > 3 && cData.length > 3">
      <span>Всего: {{total}}</span>
    </div>  
    <!-- Paginator -->
    <div class="mr-2" style="margin-left: auto;flex: 555;display: flex;justify-content: flex-end;">
      <paginator :pages="cPaginator" @change="fetch"/>
    </div>
  </div>

</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
props: ['data','keys','disable-auto-fetch','pages'],
data(){return{
  listModal: {id:'list-modal',title:'',content:'',show:''},
}},
computed:{
  cListModal(){return this.listModal},
  cKeys:function(){
    let model = false;
    if(this.keys != undefined){
      //Direct keys
      if(typeof(this.keys) == 'object'){
        return this.keys;
      }
      //From model keys
      model = this.cKeysModel;
      if(model.s != undefined){
        model = model.s;
        //Getter keys
        if(this.$store.getters[model+'/getKeys'] != undefined) {
          return this.$store.getters[model+'/getKeys'];
        }  
      }  
    }

    //From data model keys
    model = this.cDataModel;      
    if(model.s != undefined){
      model = model.s;
      //Getter keys
      if(this.$store.getters[model+'/getKeys'] != undefined) {
        return this.$store.getters[model+'/getKeys'];
      }  
    }    

    return null;
  },
  cActiveKeys:function(){
    let keys = [];
    $.each( this.cKeys, ( k, v ) => {
      if(typeof(v) != 'object' || v == null) return;
      if(v.active === false) return;
      v.active = true;
      keys.push(v);
    });
    return keys;
  },
  cData:function(){
    let model = this.cDataModel;
    //Data from model
    if(model.s != undefined){
      model = model.s;
      //Getter data  
      if(this.$store.getters[model+'/get'] != undefined) {
        //return
        return this.$store.getters[model+'/get'];
      }  
    }
    //Data from prop
    if(typeof(this.data) == 'object'){
      return JSON.parse(JSON.stringify(this.data));
    }
    //No data
    return [];
  },
  cPages:function(){
    if(
      this.cDataModel.s != undefined && 
      this.cDataModel.s && 
      this.$store.getters[this.cDataModel.s+'/getPages'] != undefined
    ) {
      return this.$store.getters[this.cDataModel.s+'/getPages'];
    }

    return false;
  },
  cPaginator:function(){
    if(this.cPages) return this.cPages;

    if(this.pages) return this.pages;

    return false;
  },
  total(){
    if(this.cPages.total != undefined) 
      return this.cPages.total;
    else 
      return this.cData.length;
  },
  cDataModel(){
    let model = false;
    if(typeof(this.data) == 'string'){
      model = {'s':false,'m':false};
      model.s = this.data;
      model.m = this.setMulti(this.data);
    }
    return model;
  },
  cDataModelSingle(){
    if(this.cDataModel.s != undefined) return this.cDataModel.s;
    return false;
  },
  cKeysModel(){
    let model = false;
    if(this.keys != undefined){
      if(typeof(this.keys) == 'string'){
        model = {'s':false,'m':false};
        model.s = this.keys;
        model.m = this.setMulti(this.keys);
      }
    }
    if(!this.keys){
      if(typeof(this.data) == 'string'){
        model = {'s':false,'m':false};
        model.s = this.data;
        model.m = this.setMulti(this.data);
      }      
    }
    return model;
  },
  cKeysModelSingle(){
    if(this.cKeysModel.s != undefined) return this.cKeysModel.s;
    return false;    
  }
},
async mounted(){
  //Fetch  
  if(
    this.cDataModelSingle
    // !this.$store.getters[this.cDataModelSingle+'/isFirstListFetch']    
  ){
    //Set key model    
    this.$store.dispatch(this.cDataModelSingle+'/setKeysModel',this.cKeysModelSingle);
    //Fetch
    if(!this.disableAutoFetch){
      this.fetch();
    }    
  }  

},
methods:{
  //Model
  setMulti(model){
    return model[0] + model.substr(1) + 's';
  },
  fetch(){ 
    this.$store.dispatch(this.cDataModelSingle+'/listFetch');
  },
  //Data
  sort(aa){
    console.log(aa);    
  },
  //Tabs
  getLink(data, k){
    let linkKey = k.link.substring(k.link.indexOf('{')+1, k.link.indexOf('}'));
    let link = k.link.replace(
      k.link.substring(k.link.indexOf('{'), k.link.indexOf('}')+1),
      data[linkKey]
    );
    return link;
  },  
  customSuccessEmit(aa){
    console.log('---------------------');
    console.log('customSuccessEmit');
    console.log(aa);
    console.log('---------------------');      
  },
  doListModal(title, list, show, button) {
    this.listModal.title = `Список ${title}`
    this.listModal.content = list;
    this.listModal.show = show;
    this.$root.$emit('bv::show::modal', this.listModal.id, button)
  },  
  success(){
    this.fetch();
  }
},
}
</script>

<style scoped>

.pre-table-wrapper{
  display: grid;
}
.pre-table-box{
  display: flex;
  align-items: center;
}
.box-search{
  justify-content: center;
  grid-column-start: 1;
  grid-column-end: 3;
  grid-row-start: 1;
}
.box-paginator{
  margin: 10px 0;
  justify-content: center;
  grid-column-start: 1;
  grid-column-end: 3;
  grid-row-start: 2;
}
.box-total{
  grid-column-start: 1;
  grid-column-end: 2;
  grid-row-start: 3;
}
.box-settings{
  justify-content: flex-end;
  grid-column-start: 2;
  grid-column-end: 3;
  grid-row-start: 3;
}

@media (min-width: 992px){
  .box-total{
    grid-column-start: 1;
    grid-column-end: 4;
    grid-row-start: 1;
  }
  .box-paginator{
    margin: 0;
    justify-content: center;
    grid-column-start: 4;
    grid-column-end: 7;
    grid-row-start: 1;
  }
  .box-search{
    justify-content: center;
    grid-column-start: 7;
    grid-column-end: 11;
    grid-row-start: 1;
  }
  .box-settings{
    justify-content: flex-end;
    grid-column-start: 11;
    grid-column-end: 12;
    grid-row-start: 1;
  }
}

</style>