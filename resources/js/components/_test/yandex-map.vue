<template>  
<juge-main>


  <div class="container my-5">
    <!-- asdsad -->




    <!-- <button @click="geoDecoder()" class="btn btn-primary">test</button> -->

    <div>{{address}}</div>

    <input class="my-4" type="text" id="suggest" style="width:1000px">

    <div id="map" style="width: 600px; height: 400px"></div>


    



    

  </div>


  
</juge-main>
</template>

<script>


// let ymaps = false;

export default {
data(){return{
  apikey:  '9b3f880f-4fa6-4d11-a75a-91e52eb23314',
  ymaps:    false,
  input:    false,
  map: false,
  marker:false,
  address:  null,
  geo:  null,
  polygonsInput: null,
  polygons: null,
}},
async mounted() {

  // Include yandex maps
  let externalScript = document.createElement('script');
  await externalScript.setAttribute('src', "https://api-maps.yandex.ru/2.1?apikey=9b3f880f-4fa6-4d11-a75a-91e52eb23314&lang=ru_RU");
  await document.head.appendChild(externalScript);

  
  this.waitInit();
},
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

    this.setMapCenter(val.x, val.y);
  },
},
methods:{
  async getGeo(){

    //Validate

    //Get address
    let address = this.address

    let geo = await this.geoDecoder(address);

    this.geo = geo.response.GeoObjectCollection;
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

    return r ? r : false;
  },
  waitInit(){
    //Wait load
    setTimeout(()=>{
      if('ymaps' in window && ymaps){
        //Init
        ymaps.ready(this.init);
        this.ymaps = ymaps;
        return;
      }
      this.waitInit();
    }, 100);
  },
  init(){
    //Input
    this.input = new ymaps.SuggestView('suggest');
    this.input.events.add("select", (e) => {
      this.address = e.get('item').value;
      this.getGeo();
    })

    //Map
    this.map = new ymaps.Map("map",{center: [60.04485022293158, 30.374407170657662],zoom: 12});

    this.addMapPolygon();

  },
  setMapCenter(x,y){
    console.log([x, y]);
    this.map.setCenter([x, y], 16);

    this.marker = new ymaps.Placemark([x, y]);

    this.map.geoObjects.add(this.marker); 
  },
  addMapPolygon(coords, color){

    var myPolygon = new ymaps.GeoObject(
      {
        geometry: {
          type: "Polygon",
          coordinates: [[
            [60.04485022293158, 30.374407170657662],
            [60.051503569872075, 30.380586980227967],
            [60.05579533786415, 30.359730122928156],
            [60.04901408788613, 30.353979466800244],
            [60.04485022293158, 30.374407170657662]
          ]]
        }
      },
      {
        'fill': true,
        'fillColor' : '#ed4543',
        'fillOpacity' : '0.5',
        'strokeColor' : '#ed4543',
        'trokeOpacity' : 1,
      }
    );

    var myCircle = new ymaps.GeoObject({
        geometry: {
            type: "Circle",
            coordinates: [55.76, 37.64],
            radius: 10000
        }
    });


    this.map.geoObjects.add(myCircle); 
    this.map.geoObjects.add(myPolygon); 

    
  },

},

}
</script>

<style>

</style>