<template>
  <div>
    <span :style="'color:'+(status.id == 1 ? 'limegreen' : 'orange')">
      {{status.name}}
    </span>
    
  </div>
</template>

<script>
export default {
props: ['data'],
computed:{
  status: function(){
    if(this.data == undefined) return false;
    if(this.data.order == undefined) return false;
    if(this.data.order.statuses == undefined) return false;
    if(this.data.order.statuses[0] == undefined) return false;

    return this.data.order.statuses[0];
  }
},
}
</script>

<style>

</style>