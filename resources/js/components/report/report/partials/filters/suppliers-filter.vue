<template>
<div class="input-group input-group-sm" style="width: auto;">
  <div class="input-group-prepend">
    <label class="input-group-text" for="time-input">Поставщики</label>
  </div>
  <v-select 
    class="suppliers-select"
    v-model="selected" 
    :label="'name'" 
    :reduce="suppliers => suppliers.id" 
    :options="suppliers"
    multiple 
  />
</div>
</template>

<script>
export default {
data(){return{
  selected:[-1],
  suppliers:[],  
}},
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

        this.$emit('changed',send);

      },
      deep: true
    }
  },
async mounted(){  
  await this.get();
  this.suppliers = [{id:-1,name:'Любой'}].concat(this.suppliers);
},
methods:{
  async get(){
    let r = await this.jugeAx('/json/suppliers/distinct');
      if(!r) return;
      this.suppliers = r;       
  }
},
}
</script>

<style>

</style>