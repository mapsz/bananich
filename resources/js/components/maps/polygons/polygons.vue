<template>
  <div>
    <!-- Map -->
    <div id="map" class="mt-3" style="width: 550px; height: 400px"></div>
  </div>
</template>

<script>
export default {
props: ['setMarker'],
data(){return{
  map:null,
  polygonsDB: null,
  polygonsMap: [],
  marker:null,
  selectedPolygones:[],
  //Other
  errors:[],
}},
computed:{
  selectedPolygonesIds (){
    if(!this.selectedPolygones) return false;
    let ids = [];
    this.selectedPolygones.forEach(v => {
      ids.push(v.id);
    });
    return ids;
  },
},
watch:{
  setMarker: function (val, oldVal) {
    if(val.x == undefined || val.y == undefined) return false;
    this.doSetMarker(val.x, val.y);
  },
  selectedPolygonesIds: function (val, oldVal) {
    this.$emit('polygonsFind',val);
  },
},
async mounted() {
  // Include yandex maps
  if(!('ymaps' in window && ymaps)){
    let externalScript = document.createElement('script');
    await externalScript.setAttribute('src', "https://api-maps.yandex.ru/2.1?apikey="+yandexMapApiKey+"&lang=ru_RU");
    await document.head.appendChild(externalScript);
  }
  
  await this.polygonsGet();
  await this.waitInit();
},
methods:{
  async polygonsGet(){
    let r = await ax.fetch('/polygons');
    if(r){this.polygonsDB = r;}
  },
  async doSetMarker(x,y){
    if(!this.map || this.map.geoObjects == undefined || this.map.geoObjects == null){
      await this.sleep(100);
      this.doSetMarker(x,y);
      return;
    }
    if(!this.polygonsDB){
      await this.sleep(100);
      this.doSetMarker(x,y);
      return;
    }


    //Remove old marker    
    this.map.geoObjects.remove(this.marker);

    //Move
    this.map.setCenter([x, y], 16);
    //Set marker
    this.marker = new ymaps.Placemark([x, y]);
    this.map.geoObjects.add(this.marker);

    //Check polygons
    this.findMarkerPolygon();
  },
  findMarkerPolygon(){
    this.selectedPolygones = [];
    let i = 0;
    this.polygonsMap.forEach(polygon => {
      if(polygon.geometry.contains([this.setMarker.x, this.setMarker.y])){
        let push = polygon;
        push.db = this.polygonsDB[i];
        push.id = this.polygonsDB[i].id;
        this.selectedPolygones.push(push);
      }     
      i++;
    });
  },  
  async waitInit(){
    //Wait load    
    if('ymaps' in window && ymaps){
      //Init
      await ymaps.ready(this.init);
      this.ymaps = ymaps;
      return true;
    }

    await this.sleep(100);
    await this.waitInit();

    return true;
  }, 
  async init(){
    //Map
    this.map = new ymaps.Map("map",{center: [59.9339,30.3061],zoom: 9});

    //Add polygons
    this.polygonsDB.forEach(v => {
      //Make coords
      let coords = [];
      v.coords.forEach(coord => {
        coords.push([coord.x,coord.y])
      });

      //Add polygons
      var myPolygon = new ymaps.GeoObject(
        {
          geometry: {
            type: "Polygon",
            coordinates: [
              coords
            ]
          },
          properties:{
            'hintContent' : v.name,
          }
        },
        {
          'fill': true,
          'fillColor' : v.color,
          'fillOpacity' : '0.5',
          'strokeColor' : v.color,
          'trokeOpacity' : 1,
        }
      );

      this.map.geoObjects.add(myPolygon); 

      this.polygonsMap.push(myPolygon);
      
    });

    return true;
  },
  async sleep(ms) {
    return new Promise(resolve => {
      setTimeout(resolve, ms);
    });
  },
},
}
</script>

<style>

</style>