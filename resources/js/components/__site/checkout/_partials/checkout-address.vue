<template>
<div class="row checkout-address checkout-address-gift">
  <div class="col-12">

    <div class="checkout-title">Адрес</div>

    <div class="form-group">
      <checkout-input v-model="addressStreet" :name="'addressStreet'" :placeholder="'Улица'" />
    </div>

    <div class="form-group d-flex form-group-multi">
      <checkout-input v-model="addressNumber" :name="'addressNumber'" :placeholder="'Дом'" />
      <checkout-input v-model="addressApart" :name="'addressApart'" :placeholder="'Квартира'" />
      <checkout-input v-model="addressPorch" :name="'addressPorch'" :placeholder="'Подъезд'" />
    </div>


  </div>
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    addressStreet:false,
    addressNumber:false,
    addressApart:false,
    addressPorch:false,

    loadUser:false,
  }},
  computed:{
    ...mapGetters({user:'user/get'}),
  },
  watch: {
    addressStreet: function(){
      this.loadUserAddress();      
    },
    user: function(){
      this.loadUserAddress();      
    },
  },
  methods:{
    ...mapActions({'set':'checkout/setValue'}), 
    loadUserAddress(){
      if(this.loadUser) return;
      if(!this.user) return;
      if(this.user.addresses == undefined || this.user.addresses[0] == undefined) return;

      if(this.addressStreet === null){
        this.loadUser = true;
        this.set({name:'addressStreet', value:this.user.addresses[0].street});
        this.set({name:'addressNumber', value:this.user.addresses[0].number});
        this.set({name:'addressApart', value:this.user.addresses[0].appart});
        this.set({name:'addressPorch', value:this.user.addresses[0].porch});
        this.addressStreet = this.user.addresses[0].street;
        this.addressNumber = this.user.addresses[0].number;
        this.addressApart = this.user.addresses[0].appart;
        this.addressPorch = this.user.addresses[0].porch;
      }
    }
  },
}
</script>

<style>

</style>