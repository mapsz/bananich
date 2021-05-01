<template>
  <div>
    <span v-if="fullAddress">
      {{fullAddress}}
    </span>
    
    <div v-if="badAddress">
      <button @click="showFix=true" class="btn btn-info btn-sm">fix</button>
      <x-popup :title="'fix address'" :active="showFix" @close="showFix=false" :id="'fix-order-address-popup-'+order.id">

        <div class="mb-3">{{order.address}}</div>
        
        <address-decoder-input />

      </x-popup>  
    </div>


    

    
  </div>
</template>

<script>
import {mapGetters,mapActions} from 'vuex';
export default {
props: ['data'],
data(){return{
  showFix:false,
  order:this.data,
}},
computed:{
  // ...mapGetters({order:'order/getOne'}),
  address(){
    if(!this.order || this.order.jugeAddress == undefined || this.order.jugeAddress.addressable_id == undefined) return false;
    return this.order.jugeAddress;
  },
  fullAddress(){
    let address = this.address;
    if(!address) return false;
    
    let full = "";
    full += address.area != undefined && address.area ? address.area : '';
    full += address.subArea != undefined && address.subArea ? ((full != '' ? ', ' : '') + address.subArea) : '';
    full += address.street != undefined && address.street ? ((full != '' ? ', ' : '') + address.street) : '';
    full += address.number != undefined && address.number ? ' '+address.number : '';

    return full;

  },
  badAddress(){
    if(!this.order) return false;
    if(!this.address) return true;

    if(this.address.manual != undefined && this.address.manual == 1) return true;
    if(this.address.area == undefined || !this.address.area) return true;
    if(this.address.street == undefined || !this.address.street) return true;
    if(this.address.number == undefined || !this.address.number) return true;
    if(this.address.x == undefined || !this.address.x) return true;
    if(this.address.y == undefined || !this.address.y) return true;


    return false;
  }
},
watch:{
  data: function (val, oldVal) {
    this.order = this.data;
  },
},
}
</script>

<style>

</style>