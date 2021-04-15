<template>  
  <div style="display:block!important">
    <input v-model="inputString" id="address-decoder-suggest-input" type="text" style="width:100%">
  </div>
</template>

<script>
export default {
model: {prop:'hidden', event:'blur'},
props: ['search'],
data(){return{
  //Input string
  inputString:null,
  typeAttempts:0,
  startAttempTime:null,
  userFailed:null,

  input:null,
  geo:null,
  address: null,
  loading:false,
  geoDecoderFailed:false,
  startYmapsLoadingTime:null,
  
}},
computed:{
  preList(){
    let input = this.input;
    if(!input || input.state == undefined || input.state._data == undefined || input.state._data.items == undefined || input.state._data.items[0] == undefined) return [];
    return input.state._data.items;
  },
  geoObject(){
    let geo = this.geo;
    if(
      !geo || 
      geo.featureMember == undefined ||
      geo.featureMember[0] == undefined ||
      geo.featureMember[0] == undefined ||
      geo.featureMember[0].GeoObject == undefined    
    ) return false;

    return geo.featureMember[0].GeoObject;
  },
  streetHouse(){
    let geoObject = this.geoObject;
    if(!geoObject) return -1;
    if(
      !geoObject.metaDataProperty == undefined || 
      geoObject.metaDataProperty.GeocoderMetaData == undefined || 
      geoObject.metaDataProperty.GeocoderMetaData.Address == undefined || 
      geoObject.metaDataProperty.GeocoderMetaData.Address.Components == undefined ||
      geoObject.metaDataProperty.GeocoderMetaData.Address.Components[0] == undefined
    ) return -2;

    let comments = geoObject.metaDataProperty.GeocoderMetaData.Address.Components;

    //Take street house
    let street = false;
    let house = false;
    comments.forEach(component => {
      if (component.kind == 'house')      house = component.name;
      if (component.kind == 'district')   street = component.name;
      if (component.kind == 'street')     street = component.name;
    });

    return {street,house};
  }
},
watch:{
  geo: function (val, oldVal) {
    this.$emit('blur', val);
  },
  search: function (val) {
    if(!val) return false;
    this.geoDecoder(val);
  },
  geoDecoderFailed: function(val){
    if(val){
      this.$emit('geo-decoder-failed');
      load.stop(this.loading);
    }
  },
  userFailed: function(val){
    if(val){
      this.$emit('user-failed');
      load.stop(this.loading);
    }
  },
  inputString:function(val, oldVal){
    //Set attemps
    if(1){
      //By time
      if(this.startAttempTime == null){
        this.startAttempTime = Date.now();
        this.attempTimeout();
      } 

      //By types
      this.typeAttempts++
      if(this.typeAttempts > 100){
        this.userFailed = true;
      }
    }
  }
},
async mounted() {
  // Include yandex maps
  if(!('ymaps' in window && ymaps)){
    let externalScript = document.createElement('script');
    await externalScript.setAttribute('src', "https://api-maps.yandex.ru/2.1?apikey="+yandexMapApiKey+"&lang=ru_RU");
    await document.head.appendChild(externalScript);
  }

  //Init
  this.loading = load.start();
  await this.waitInit();

  //Preset
  if(this.preset){
    this.geoDecoder(this.preset);
  }
},
methods:{
  async waitInit(){
    //Check loading
    if(this.startYmapsLoadingTime == null) this.startYmapsLoadingTime = Date.now();
    let loadingTime = parseInt((Date.now() - this.startYmapsLoadingTime) / 1000);
    if(loadingTime > 30){
      this.geoDecoderFailed = true;
      return false;  
    }

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
    //Input
    this.input = await new ymaps.SuggestView('address-decoder-suggest-input');
    await this.input.events.add("select", async (e) => {
      this.address = e.get('item').value;
      //Get address
      await this.geoDecoder(this.address);
    });

    load.stop(this.loading);
    return true;
  },
  async geoDecoder(address){
    let data = {
      geocode:    address,
      apikey:     yandexMapApiKey,
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
  async sleep(ms){
    return new Promise(resolve => {
      setTimeout(resolve, ms);
    });
  },
  attempTimeout(){
    setTimeout(()=>{
      this.userFailed = true;
    }, 3000);
  }

},
}
</script>

<style>

</style>