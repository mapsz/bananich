<template>
<div>
  <div class="input-group input-group-sm" style="width: auto;">
    <div class="input-group-prepend" style="height: 35px;">
      <label class="input-group-text" for="time-input">Статус заказа</label>
    </div>
    <v-select 
      class="order-status-select"
      v-model="selected" 
      :label="'name'" 
      :reduce="statuses => statuses.id" 
      :options="statuses"
      multiple 
    />
    <button @click="bobaBuild()" class="btn btn-outline-secondary btn-sm">
      BOBA 🚗
    </button>
  </div>
</div>
</template>

<script>
export default {
  props: ['model','preset'],
  data() {
    return {
      selected:[-1],
      statuses:[],
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
          this.$store.dispatch(this.model+'/addFilter',{status:send});
        }
        //Emit
        this.$emit('statusChanged',send);

      },
      deep: true
    }
  },
  async mounted(){
    await this.getOrderStatuses();
    this.statuses = [{id:-1,name:'Любой'}].concat(this.statuses);
  },  
  methods:{
    async getOrderStatuses(){
      let r = await ax.fetch('/json/order/statuses');
      if(r) this.statuses = r;
    }, 
    async bobaBuild(){
      this.selected = [300,400,500,600,700];
    }

  }

}
</script>

<style scoped>

  .order-status-select{
    min-width:230px;
  }

</style>