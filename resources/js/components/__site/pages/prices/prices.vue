<template>
<juge-main>
  <div class="container mt-5">
    <h2>Проверьте стоимость сервисного сбора</h2>
    <div class="row mt-5">
      <div class="col-12 col-lg-6">
        <choose-address v-model="address"/>
        <polygons v-show="0" @polygonsFind="setPolygons" :setMarker="choosedCoords" />
      </div>
      <div class="col-12 col-lg-6">
        <div v-for="(day, i) in availableDays" :key="i" class="mb-3">
          <div>
            {{moment(day.date).locale("ru").format('D.M')}},
            {{moment(day.date).locale("ru").format('dddd')}}
          </div>
          <div class="ml-3">
            <template v-for="(time, j) in day.times" >
              <div v-if="time.slots > 0" :key="j" >
                с {{time.time.from}} по {{time.time.to}} - 
                <span :style="defaultPrice > time.price ? 'color:limegreen' : ''">{{currencySymbol+time.price}}</span>
              </div>
            </template>
          </div>
        </div>
      </div>
    </div>
  </div>
</juge-main>
</template>

<script>
import {mapGetters,mapActions} from 'vuex';
export default {
data(){return{
  moment:moment,
  currencySymbol:currencySymbol,
  address:null,
  polygons:null,
}},
computed:{
  ...mapGetters({    
    user:     'user/get',
    addresses:'addresses/get',
    availableDays:  'orderLimits/getAvailableDays',
    settings:       'settings/beautyGet',
  }),
  choosedAddress(){
    if(this.address == null) return false;
    if(this.addresses == undefined || this.addresses[0] == undefined) return false;

    let address = this.addresses.find(x => x.id == this.address);
    return address;
  },
  choosedCoords(){
    if(this.choosedAddress.x == undefined || this.choosedAddress.y == undefined) return false;
    return {x:this.choosedAddress.x, y:this.choosedAddress.y};
  },
  defaultPrice:function(){
    if(this.settings == undefined && this.settings.x_order_price == undefined) return false;
    return this.settings.x_order_price;
  }
},
watch:{
  polygons: function (val, oldVal) {
    if(this.polygons !== null){
      this.fetch(this.polygons.length == 0 ? [0] : this.polygons);
    }
  },
},
methods:{  
  ...mapActions({
    'fetch':'orderLimits/fetchAvailableDays',
  }),
  setPolygons(ids){
    this.polygons = ids;
  },
},
}
</script>

<style>

</style>