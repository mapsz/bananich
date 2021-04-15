<template>
  <div> 

    <!-- Geo Decoder -->
    <div v-if="!manual" class="mb-3">
      <!-- Input -->
      <template>
        <label for="">Поиск:</label>
        <address-decoder-input v-model="geoSearch" :search="doGeoSearch" @geo-decoder-failed="geoDecoderFailed = true" @user-failed="geoUserFailed = true"/>
      </template>
      <!-- Fails -->      
      <div v-if="geoDecoderFailed">
        load failed
      </div>
      <div v-if="geoUserFailed" class="mt-2 d-flex justify-content-center">
        <button @click="manual=true" class="x-btn x-btn-sm">Не могу ввести адрес!</button>
      </div>
    </div>

    <!-- Manual annonce -->
    <div v-if="manual">
      <div>
        <span style="color:tomato">*</span> При данном методе вводе адреса доступные интервалы не будут определены автоматически, и с вами свяжется оператор для согласования удобного времени доставки.
      </div>
      <div class="mt-2 d-flex justify-content-center">
        <button @click="data.street='';data.number='';manual=false" class="x-btn x-btn-sm">Попробовать ещё раз</button>
      </div>      
    </div>
    
    <template>
      <!-- Home \ Appart -->
      <div class="form-group mb-2 d-flex form-group-multi">
        
        <!-- Geo decoder -->
        <template v-if="!manual">
          <div style="width:60%;align-self:center;font-weight:600;">{{data.street}}</div>
          <div style="width:40%;align-self:center;font-weight:600;">{{data.number}}</div>
        </template>

        <!-- Manual -->
        <template v-else>
          <input v-model="data.street" style="width:60%" name="street" class="form-input" placeholder="Улица" type="text">
          <input v-model="data.number" style="width:40%" name="number" class="form-input" placeholder="Номер дома" type="text">
        </template>

      </div>

      <!-- Appart \ Porch \ Stage \ Intercom -->
      <div class="form-group mb-2 d-flex form-group-multi">
        <input v-model="data.appart" name="appart" class="form-input" placeholder="Квартира" type="text">
        <input v-model="data.porch" name="porch" class="form-input" placeholder="Подъезд" type="text">
        <input v-model="data.stage" name="stage" class="form-input" placeholder="Этаж" type="text">
        <input v-model="data.intercom" name="intercom" class="form-input" placeholder="Домофон" type="text">
      </div>
      
      <!-- Default -->
      <div class="mb-3">
        <label for="user-addresses-default">
          <input v-model="data.default" name="$default" id="user-addresses-default" type="checkbox" class="checkbox"> 
          <div class="checkbox-box"></div>
          <span style="padding-left:25px; font-size:10pt">Сделать адресом по умолчанию</span>
        </label>
      </div>
    </template>

    <!-- Errors -->
    <juge-errors :errors="errors"/>
    
    <!-- Actions -->
    <div class="d-flex justify-content-between">
      <button @click="doCancel()" class="x-btn x-btn-sm x-btn-trans">Отмена</button>
      <button @click="save()" class="x-btn x-btn-sm">Сохранить</button>
    </div>
    
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
props: ['id'],
data(){return{
  //Search
  geoSearch:null,
  doGeoSearch:null,

  //Address Data
  data:{
    street:null,
    number:null,
    appart:null,
    porch:null,
    stage:null,
    intercom:null,
    x:null,
    y:null,
    default:0,
  },

  //Geo decoder
  manual:false,
  geoDecoderFailed:false,
  geoUserFailed:false,

  //Other
  errors:[],
}},
computed:{
  ...mapGetters({
    user:'user/get',    
    addresses:'addresses/get',
  }),
  activeAddress(){
    if(!this.addresses || this.addresses.length < 1) return false;
    if(!this.id || this.id < 0) return false;
    return this.addresses.find(x => x.id == this.id);
  },
  fGeoSearch(){
    if(!this.geoSearch) return false;
    if(this.geoSearch.featureMember == undefined || this.geoSearch.featureMember[0] == undefined || this.geoSearch.featureMember[0].GeoObject == undefined) return false;
    let geoObject =  this.geoSearch.featureMember[0].GeoObject;

    let components = geoObject.metaDataProperty.GeocoderMetaData.Address.Components;
    
    let fAddress = {};

    components.forEach(component => {
      fAddress[component.kind] = component.name;
    });

    
    let coords = geoObject.Point.pos;
    coords = {
      'x' : coords.split(' ')[1],
      'y' : coords.split(' ')[0]
    };

    fAddress.x = coords.x;
    fAddress.y = coords.y;

    return fAddress;

  }
},
watch:{
  activeAddress: function (val, oldVal) {
    this.addEditPreData();
  },
  fGeoSearch: function(val, oldVal){
    this.data.street = val.street != undefined ? val.street : null;
    if(this.data.street == null) this.data.street = val.district != undefined ? val.district : null;
    this.data.number = val.house != undefined ? val.house : null;
    this.data.x = val.x != undefined ? val.x : null;
    this.data.y = val.y != undefined ? val.y : null;
  }
},
async mounted() {
  this.addEditPreData();
},
methods:{
  addEditPreData(){
    if(this.activeAddress.street != undefined) this.data.street = this.activeAddress.street;
    if(this.activeAddress.number != undefined) this.data.number = this.activeAddress.number;
    if(this.activeAddress.appart != undefined) this.data.appart = this.activeAddress.appart;
    if(this.activeAddress.porch != undefined) this.data.porch = this.activeAddress.porch;
    if(this.activeAddress.stage != undefined) this.data.stage = this.activeAddress.stage;
    if(this.activeAddress.intercom != undefined) this.data.intercom = this.activeAddress.intercom;
    if(this.activeAddress.default != undefined) this.data.default = this.activeAddress.default;
  },
  save(){    
    this.data.manual = this.manual;
    if(this.id){this.edit();}else{this.add();}
  },
  async add(){
    this.errors = [];
    //Put
    let r = await ax.fetch('/user/address', this.data, 'put');
    //Catch errors
    if(!r && ax.lastResponse.status == 422){
      ax.fetch('/juge/log',{code:1000, body:{"body":'addressValidate'}}, 'put');
      this.errors = ax.lastResponse.data.errors;return;      
    }
    if(!r){ax.fetch('/juge/log',{code:1000, body:{"body":'addressError','send':this.data,'response': ax.lastResponse}}, 'put');}
    if(r){
      ax.fetch('/juge/log', {code:1001, body:{'body':'addressSuccess','send':this.data,'response': ax.lastResponse}}, 'put');
      this.$emit('success');
    }
  },
  async edit(){
    this.errors = [];
    //Put
    let data = this.data;
    data.id = this.id;
    let r = await ax.fetch('/user/address', this.data, 'post');
    //Catch errors
    if(!r){if(ax.lastResponse.status == 422){this.errors = ax.lastResponse.data.errors;return;}}
    if(r){
      this.$emit('success');
    }
  },
  doCancel(){
    this.$emit('cancel');
  },
  doChange(){
    console.log(this.data.street + ' ' + this.data.number);

    this.doGeoSearch = this.data.number + ' ' + this.data.street;
  }
},
}
</script>

<style scoped>

  /* input */
  .user-addresses input{
    background-color: #ffffff00;
  }
  /* Placeholder */
  .user-addresses-placeholder{
    position: absolute;
    left: 0;
    margin: 0;
    padding: 10px 0;
    color:#828282;
  }
  input.user-addresses-address:invalid + label {
      display: inline-block;
  }  
  input.user-addresses-address:valid + label{
      display: none;
  }
  /* Default */
  .user-addresses .checkbox:checked + .checkbox-box:before, .checkbox:not(:checked) + .checkbox-box:before {
    margin-top: 3px;
  }
  .user-addresses .checkbox:checked + .checkbox-box:after, .checkbox:not(:checked) + .checkbox-box:after {
    margin-top: 3px;
  }
</style>