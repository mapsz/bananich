<template>
<div class="input-group input-group-sm" style="width: auto;">
  <div class="input-group-prepend">
    <label class="input-group-text" for="order-delivery-time-input">Время доставки</label>
  </div>
  <select v-model="time" class="custom-select" id="order-delivery-time-input">
    <option value="0" selected>Любое</option>    
    <option value="11-23">11-23</option>
    <option value="11-15">11-15</option>
    <option value="15-19">15-19</option>
    <option value="19-23">19-23</option>
  </select>
</div>
</template>

<script>
export default {
  props: ['model'],
  data() {
    return {
      time:0,
    }
  },
  watch: {
    time: function () {
      let deliveryTime = {
        from:false,
        to:false,
      }
      if(this.time != 0){
        deliveryTime.from = this.time.substring(0,2)+':00:00';
        deliveryTime.to = this.time.substring(3)+':00:00';
      }
      //Set vuex
      if(this.model != undefined){
        this.$store.dispatch(this.model+'/addFilter',{deliveryTime});
      }
      //Emit
      this.$emit('timeChanged',{deliveryTime});
    },
  }, 
}
</script>

<style>

</style>