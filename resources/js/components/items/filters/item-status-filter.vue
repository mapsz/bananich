<template>
<div class="input-group input-group-sm" style="width: auto;">
  <div class="input-group-prepend">
    <label class="input-group-text" for="time-input">Item Status</label>
  </div>
  <select v-model="status" class="custom-select" id="time-input">
    <option value="-1" selected>Any</option>    
    <option 
      v-for="status in statuses" 
      :key="status.id" 
      :value="status.id"
    >
      {{status.name}}
    </option>   
  </select>
</div>
</template>

<script>
export default {
  props: ['model'],
  data() {
    return {
      status:-1,
      statuses:[],
    }
  },
  watch: {
    status: function () {
      //Set vuex
      if(this.model != undefined){
        this.$store.dispatch(this.model+'/addFilter',{'itemStatus':this.status});
      }
      //Emit
      this.$emit('itemStatusChanged',this.status);
    },
  },
  mounted(){
    this. getOrderStatuses();
  },  
  methods:{
    async getOrderStatuses(){
     let l = this.$loading.show({},this.slot);
     let r = await axios.get('/json/item/statuses')
                .then((r) => {
                  this.statuses = r.data;

                })

      l.hide();
    },    
  }

}
</script>

<style>

</style>