<template>
  <div>
    {{address}}
  </div>
</template>

<script>
import {mapGetters,mapActions} from 'vuex';
export default {
computed:{
  ...mapGetters({order:'order/getOne'}),
  address(){
    if(!this.order || this.order.jugeAddress == undefined || this.order.jugeAddress.addressable_id == undefined) return false;
    return this.order.jugeAddress;
  }
},
}
</script>

<style>

</style>