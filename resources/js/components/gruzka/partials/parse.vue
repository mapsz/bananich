<template>
<div class="container-fluid">
  <div class="parse" ref="parse">
    <button class="btn btn-warning my-2" @click="parse()">
      Parse
    </button>
    <span class="parse-info">
      <span v-if="result.orderCount" class="text-primary">
        {{result.orderCount}}
      </span>
      <span v-if="result.putOrderCount" class="text-success">
        {{result.putOrderCount}}/{{result.itemsCount}}
      </span>
    </span>
  </div>
</div>
</template>

<script>
export default {
  data() {
    return {
      slot:{default: this.$createElement('loader-icon'),},
      result:[],
    }
  },
  mounted(){
    //
  },
  methods:{
    async parse() {
      let l = this.$loading.show({},this.slot);

      let r = await axios.get('/parse/orders',{})
        .then((r)=>{
          this.result = r.data;
          this.$emit('ordersUpdated');
        }) 

      l.hide();               
    },
  }
}
</script>

<style>

</style>