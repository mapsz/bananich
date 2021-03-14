<template>
<div>  
  <gruzka-navbar></gruzka-navbar>  
  <map-navbar></map-navbar>  

    <div class="container">

      <div class="row">

        <div class="col-6">

          <!-- Polygons -->
          <div v-if="polygonsDB">
            <h2>Полигоны</h2>
            <div><b>Всего: {{polygonsDB.length}}</b> </div>
            <!-- buttons -->
            <div>
              <button v-if="polygonsShow==false" @click="polygonsShow=true" class="btn btn-primary">show</button>
              <button v-if="polygonsShow" @click="polygonsShow=false" class="btn btn-danger">close</button>
            </div>
            <!-- list -->
            <div v-if="polygonsShow">
              <div v-for="(polygon, i) in polygonsDB" :key="i" class="my-2">
                {{polygon.id}} :
                {{polygon.name}}
              </div>
            </div>
          </div>

          <!-- Map -->
          <div class="mt-3">
            <h2>Map</h2>

            <!-- Test -->
            <div>
              <div><a href="https://developer.tech.yandex.ru/services/3/stat" target="_blank">график запросов</a></div>
              <div>Test address:</div>
              <div>{{address}}</div>
              <div><input id="suggest" type="text" style="width:100%"></div>
              <div v-if="selectedPolygone !== null" class="mt-1">
                Полигон:
                {{selectedPolygone ? selectedPolygone.properties.getAll().hintContent : 'nope'}}
              </div>
            </div>

            <!-- Map -->
            <div id="map" class="mt-3" style="width: 550px; height: 400px"></div>
          </div>
        </div>

        <!-- Polygons input -->
        <div class="col-6">
          <div>
            <h2>Update Polygons</h2>
          </div>
          <!-- readme -->
          <div style="font-size:10pt">
            <a target="_blank" href="https://yandex.ru/maps/?um=constructor%3A602d531212d717146c6fa5f74f2b012fec125c10bc0bb2fd4fc6b23d7d61f997&source=constructorLink">Link</a>
            ➞ Редактировать ➞ Сохранить и продолжить ➞ Экспорт ➞ GEO JSON          
          </div>
          <div class="mt-2">
            <div class="d-flex">
              <textarea v-model="polygonsInput" id="" cols="40" rows="3"></textarea>
              <button @click="polygonsDecode()" class="btn btn-primary" style="margin:10px; height: 40px;">Decode</button>
            </div>
          </div>

          <div v-if="polygonsDecoded">
            
            <!-- Errors -->
            <juge-errors class="mt-3" :errors="errors"/>

            <!-- Upload -->
            <div class="mt-2">
              <button @click="polygonsUpdate()" class="btn btn-success">Update</button>
            </div>

            <!-- Name -->
            <div style="font-size: 22pt;"><b>{{polygonsDecoded.name}}</b> </div>
            <div style="font-size: 18pt;">{{polygonsDecoded.description}}</div>

            <!-- Polygons -->
            <div class="mt-4">
              <!-- Count -->
              <div  style="font-size: 16pt;">              
                Polygons count: {{polygonsDecoded.polygons.length}}
              </div>

              <!-- Polygons -->
              <div class="mt-3">
                <div v-for="(polygon, i) in polygonsDecoded.polygons" :key="i" class="mt-2">
                  <div style="border:1px solid black; background-color: white; padding: 5px;" :style="'border-color:'+polygon.border">
                    <div :style="'color:'+polygon.color">
                      {{polygon.name}}
                    </div>
                    <span>
                      dots: {{polygon.coords.length}}
                    </span>
                  </div>                
                </div>
              </div>



            </div>


          </div>
        </div>

      </div>


    </div>

  
</div>
</template>

<script>
export default {
data(){return{
  map:null,
  apikey:  '9b3f880f-4fa6-4d11-a75a-91e52eb23314',
  address: null,
  polygonsDB: null,
  polygonsMap: [],
  polygonsInput: null,
  polygonsDecoded: null,
  marker:null,
  geo:null,
  selectedPolygone:null,
  //Show
  polygonsShow:false,
  //Other
  errors:[],
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
  },
},
async mounted() {
  // Include yandex maps
  let externalScript = document.createElement('script');
  await externalScript.setAttribute('src', "https://api-maps.yandex.ru/2.1?apikey="+this.apikey+"&lang=ru_RU");
  await document.head.appendChild(externalScript);

  
  await this.polygonsGet();

  await this.waitInit();

},
methods:{  
  async waitInit(){
    //Wait load
    await setTimeout(()=>{
      if('ymaps' in window && ymaps){
        //Init
        ymaps.ready(this.init);
        this.ymaps = ymaps;
        return;
      }
      this.waitInit();
    }, 100);

    return;
  },
  async init(){

    //Input
    this.input = new ymaps.SuggestView('suggest');
    await this.input.events.add("select", async (e) => {
      this.address = e.get('item').value;

      //Get address
      let geo = await this.geoDecoder(this.address);
      this.geo = geo.response.GeoObjectCollection;
    })

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
  polygonsDecode(){
    let polygons =  JSON.parse(this.polygonsInput);

    // Name
    this.polygonsDecoded = {};
    this.polygonsDecoded.name = polygons.metadata.name;
    this.polygonsDecoded.description = polygons.metadata.description;

    // Polygons
    this.polygonsDecoded.polygons = [];
    polygons.features.forEach(v => {  
      //Coords
      let coords = [];
      v.geometry.coordinates[0].forEach(coord => {
        coords.push({'x':coord[1] , 'y':coord[0]});
      });
      //Meta
      this.polygonsDecoded.polygons.push({
        'name': v.properties.description,
        'color': v.properties.fill,
        'border': v.properties.stroke,
        'coords': coords,
      })    
    });

  },
  async polygonsUpdate(){
    this.errors = [];

    let polygons = this.polygonsDecoded.polygons;

    let r = await ax.fetch('/admin/polygons', {polygons}, 'put');

    if(!r){if(ax.lastResponse.status == 422){this.errors = ax.lastResponse.data.errors;return;}}

    if(r) location.reload();

    console.log(polygons);

  },
  async polygonsGet(){

    let r = await ax.fetch('/admin/polygons');

    if(r){
      this.polygonsDB = r;
    };

  },
  setMarker(x,y){
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
    this.selectedPolygone = false;
    this.polygonsMap.forEach(polygon => {
      if(polygon.geometry.contains([this.coords.x, this.coords.y])){
        this.selectedPolygone = polygon;
      }      
    });
  }

},
}
</script>

<style>

</style>