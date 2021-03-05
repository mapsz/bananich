<template>
<div>  
  <gruzka-navbar></gruzka-navbar>
  <map-navbar></map-navbar>
  <div class="container">
    <!-- No coords -->
    <div>
      <h3>Адрес без координат</h3>
      <!-- List -->
      <template v-if="!showChooseAddress">
        <div v-for="(sOrder, i) in noCoordOrders" :key="i" class="mt-2">
          <button @click="showChooseAddress=sOrder.address" class="btn btn-primary btn-sm">Coords</button>
          {{sOrder.id}} {{sOrder.short_address}}
        </div>
      </template>
      
      <!-- Choose -->
      <div v-if="showChooseAddress">
        <button @click="showChooseAddress=false;geo=false" class="btn btn-danger">cancel</button>
        <!-- Current -->
        <div>
          {{showChooseAddress.street}}
          {{showChooseAddress.number}}
        </div>
        <!-- Choosed -->
        <div v-if="addressChoosed" class="my-3">
          <div>{{addressChoosed.coords}}</div>
          <div>{{addressChoosed.name}}</div>
          <button @click="updateAddress()" class="btn btn-success">Подтвердить</button>
        </div>
        <!-- Choose address -->
        <div>          
          <choose-address @choosed="coordsChoosed" :preset="showChooseAddress.street + ' ' + showChooseAddress.number"/>
        </div>

      </div>

    </div>

    <!-- No Polygon -->

    <!-- With Polygons -->
  </div>  
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
data(){return{
  showChooseAddress:false,
  geo:false,
}},
computed:{
  ...mapGetters({
    sOrders:    'sharedOrder/get',
  }),
  noCoordOrders(){
    if(!this.sOrders || this.sOrders[0] == undefined || this.sOrders[0].id == undefined) return [];

    let sOrders = this.sOrders.filter(x => (x.address.x == null || x.address.y == null));

    return sOrders;    
  },
  addressChoosed(){

    //Coords
    if(
      !this.geo || 
      this.geo.featureMember == undefined || 
      this.geo.featureMember[0] == undefined || 
      this.geo.featureMember[0].GeoObject == undefined || 
      this.geo.featureMember[0].GeoObject.Point == undefined ||
      this.geo.featureMember[0].GeoObject.Point.pos == undefined
    ) return false;
    let coords = this.geo.featureMember[0].GeoObject.Point.pos;
    coords = {
      'x' : coords.split(' ')[1],
      'y' : coords.split(' ')[0]
    };

    //Full Address
    let name = this.geo.featureMember[0].GeoObject.description;
    name    += ', ' + this.geo.featureMember[0].GeoObject.name;

    return {coords,name}
  }
},
async mounted() {  
  await this.filter({'open':true});
  await this.get();
},
methods:{  
  ...mapActions({
    'filter':'sharedOrder/addFilter',
    'get':'sharedOrder/fetchData',
  }),
  coordsChoosed(geo){
    this.geo = geo;
  },
  async updateAddress(){
    let data = {};
    data.id = this.showChooseAddress.id
    data.x = this.addressChoosed.coords.x;
    data.y = this.addressChoosed.coords.y;
    data.admin = true;

    let r = await ax.fetch('/user/address',data,'post');

    if(r) location.reload();
  }
},
}
</script>

<style>

</style>