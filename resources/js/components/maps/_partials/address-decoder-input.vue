<template>  
  <div style="display:block!important">
    <input id="address-decoder-suggest-input" type="text" style="width:100%">
  </div>
</template>

<script>
export default {
model: {prop:'hidden', event:'blur'},
props: ['search'],
data(){return{
  input:null,
  geo:null,
  address: null,
}},
watch:{
  geo: function (val, oldVal) {
    this.$emit('blur', val);
  },
  search: function (val) {
    if(!val) return false;
    this.geoDecoder(val);
  },
},
async mounted() {
  // Include yandex maps
  if(!('ymaps' in window && ymaps)){
    let externalScript = document.createElement('script');
    await externalScript.setAttribute('src', "https://api-maps.yandex.ru/2.1?apikey="+yandexMapApiKey+"&lang=ru_RU");
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
  async init(){
    //Input
    this.input = await new ymaps.SuggestView('address-decoder-suggest-input');
    await this.input.events.add("select", async (e) => {
      this.address = e.get('item').value;
      //Get address
      await this.geoDecoder(this.address);
    });

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