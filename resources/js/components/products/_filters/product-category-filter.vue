<template>
<div class="input-group input-group-sm" style="width: auto;">
  <div class="input-group-prepend">
    <label class="input-group-text" for="time-input">Категории</label>
  </div>
  <v-select 
    class="product-category-select"
    v-model="selected" 
    :label="'name'" 
    :reduce="categories => categories.id" 
    :options="categories"
    multiple 
  />
</div>
</template>

<script>
export default {
  props: ['model'],
  data() {
    return {
      selected:[-1],
      categories:[],
    }
  },
  watch: {
    selected: {
      handler: function (val, oldVal) {   
        //Remove any
        if(oldVal.findIndex(x => x == -1) > -1 && val.findIndex(x => x == -1) > -1 && val.length > 1){
          this.selected.splice(this.selected.findIndex(x => x == -1), 1);
          return
        }
        //Set only any
        if(oldVal.findIndex(x => x == -1) == -1 && val.findIndex(x => x == -1) > -1 && val.length > 1){
          this.selected = [-1];
          return
        }

        let send = this.selected;
        if(send.length == 1 && send[0] == -1){
          send = [];
        }

        //Set vuex
        if(this.model != undefined){
          this.$store.dispatch(this.model+'/addFilter',{'categories':send});
        }
        // //Emit
        // this.$emit('statusChanged',send);

        this.$store.dispatch(this.model+'product/fetchData');

      },
      deep: true
    }
  },
  async mounted(){
    await this.getOrderStatuses();
    this.categories = [{id:-1,name:'Любой'}].concat(this.categories);
  },  
  methods:{
    async getOrderStatuses(){
      let r = await ax.fetch('/json/categories');
      if(r) this.categories = r;
    },    
  }

}
</script>

<style scoped>

  .product-category-select{
    min-width:230px;
  }

</style>