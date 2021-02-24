<template>
<div>  
  <gruzka-navbar></gruzka-navbar>
  <map-navbar></map-navbar>
  <div class="container">
    <!-- No coords -->
    <div>
      <h3>Адрес без координат</h3>
      <div v-for="(sOrder, i) in noCoordOrders" :key="i" >
        {{sOrder.id}} {{sOrder.short_address}}
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

computed:{  
  ...mapGetters({
    sOrders:    'sharedOrder/get',
  }),
  noCoordOrders(){
    if(!this.sOrders || this.sOrders[0] == undefined || this.sOrders[0].id == undefined) return [];

    let sOrders = this.sOrders.filter(x => (x.x == null || x.y == null));

    return sOrders;
      
    
  },
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
},
}
</script>

<style>

</style>