<template>
<div>
          <!-- Test -->
          <div>
            <!-- <div>Test address:</div> -->
            <!-- <div>{{address}}</div> -->
            <div><input id="suggest" type="text" style="width:100%"></div>
            <!-- <div v-if="selectedPolygone !== null" class="mt-1">
              Полигон:
              {{selectedPolygone ? selectedPolygone.properties.getAll().hintContent : 'nope'}}
            </div> -->
          </div>

          <!-- Map -->
          <div id="map" class="mt-3" style="width: 550px; height: 400px"></div>
</div>
</template>

<script>
export default {
props: ['preset'],
data(){return{
  map:null,
  apikey:  '9b3f880f-4fa6-4d11-a75a-91e52eb23314',
  address: null,
  marker:null,
  geo:null,
  selectedPolygone:null,  
}},
computed:{
  coords(){
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
    return coords;
  },
},
watch:{
  coords: function (val) {
    if(val.x == undefined) return false;
    this.setMarker(val.x, val.y);

    this.$emit('choosed', JSON.parse(JSON.stringify(this.geo)));
  },
},
async mounted() {
  // Include yandex maps
  if(!('ymaps' in window && ymaps)){
    let externalScript = document.createElement('script');
    await externalScript.setAttribute('src', "https://api-maps.yandex.ru/2.1?apikey="+this.apikey+"&lang=ru_RU");
    await document.head.appendChild(externalScript);
  }

  //Init
  await this.waitInit();

  //Preset
  if(this.preset){
    this.geoDecoder(this.preset);
  }
},
methods:{   
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
  async sleep(ms) {
    return new Promise(resolve => {
      setTimeout(resolve, ms);
    });
  },
  async init(){
    //Map
    this.map = await new ymaps.Map("map",{center: [59.9339,30.3061],zoom: 9});

    //Input
    this.input = await new ymaps.SuggestView('suggest');
    await this.input.events.add("select", async (e) => {
      this.address = e.get('item').value;
      //Get address
      await this.geoDecoder(this.address);      
    })


    //Add polygons
    if(0){
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
      
    }

    return true;

  },
  setMarker(x,y){
    //Remove old marker    
    // console.log(this.map);
    this.map.geoObjects.remove(this.marker);

    //Move
    this.map.setCenter([x, y], 16);
    //Set marker
    this.marker = new ymaps.Placemark([x, y]);
    this.map.geoObjects.add(this.marker);

    //Check polygons
    // this.findMarkerPolygon();
  },
  async geoDecoder(address){
    let data = {
      geocode:    address,
      apikey:     this.apikey,
      sco:        null,
      kind:       null,
      rspn:       null,
      ll:         null,
      spn:        null,
      bbox:       null,
      format:     'json',
      results:    null,
      skip:       null,
      lang:       null,
      callback:   null,
    };

    let r = await ax.fetch('https://geocode-maps.yandex.ru/1.x', data);

    if(r){
      this.geo = r.response.GeoObjectCollection;
      return true;
    }

    return false;
  },
},
}
</script>

<style>

</style>