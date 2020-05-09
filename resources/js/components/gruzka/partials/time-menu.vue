<template>
<div class="input-group input-group-sm" style="width: auto;">
  <div class="input-group-prepend">
    <label class="input-group-text" for="time-input">Time</label>
  </div>
  <select v-model="time" class="custom-select" id="time-input">
    <option value="0" selected>Any</option>    
    <option value="11-23">11-23</option>
    <option value="11-15">11-15</option>
    <option value="15-19">15-19</option>
    <option value="19-23">19-23</option>
  </select>
</div>
</template>

<script>
export default {
  data() {
    return {
      time:0,
    }
  },
  watch: {
    time: function () {
      let data = {
        from:false,
        to:false,
      }
      if(this.time != 0){
        data.from = this.time.substring(0,2)+':00:00';
        data.to = this.time.substring(3)+':00:00';
      }
      this.$emit('timeChanged',data);
    },
  },  
}
</script>

<style>

</style>