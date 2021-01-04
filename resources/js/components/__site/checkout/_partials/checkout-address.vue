<template>
<div>
  <div class="row checkout-address checkout-address-gift">
    <div class="col-12">

      <div v-if="design != 'x'" class="checkout-title">Адрес</div>

      <div class="form-group">
        <checkout-input v-model="data.addressStreet" :name="'addressStreet'" :placeholder="'Улица'" />
      </div>

      <div class="form-group d-flex form-group-multi">
        <checkout-input v-model="data.addressNumber" :name="'addressNumber'" :placeholder="'Дом'" />
        <checkout-input v-model="data.addressApart" :name="'addressApart'" :placeholder="'Квартира'" />
        <checkout-input v-model="data.addressPorch" :name="'addressPorch'" :placeholder="'Подъезд'" />
      </div>


    </div>
  </div>
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  model: {prop: 'hidden',event: 'blur'},
  props: ['hidden','design'],
  data(){return{
    data:{
      addressStreet:false,
      addressNumber:false,
      addressApart:false,
      addressPorch:false,
    },

    loadUser:false,
  }},
  computed:{
    ...mapGetters({user:'user/get'}),
  },
  watch: {
    data: {
      deep: true,
      handler(){
        this.$emit('blur', this.data);
        this.loadUserAddress();
      }
    },
    user: function(){
      this.loadUserAddress();      
    },
    hidden: function(){
      if(this.hidden == undefined) return;

      if(this.hidden.street != undefined) this.data.addressStreet = this.hidden.street;
      if(this.hidden.number != undefined) this.data.addressNumber = this.hidden.number;
      if(this.hidden.appart != undefined) this.data.addressApart = this.hidden.appart;
      if(this.hidden.porch != undefined) this.data.addressPorch = this.hidden.porch; 
    }
  },
  methods:{
    ...mapActions({'set':'checkout/setValue'}), 
    loadUserAddress(){
      if(this.loadUser) return;
      if(!this.user) return;
      if(this.user.addresses == undefined ) return;
      if(this.user.addresses[0] == undefined) return;

      if(this.addressStreet === null){
        this.loadUser = true;
        this.set({name:'addressStreet', value:this.user.addresses[0].street});
        this.set({name:'addressNumber', value:this.user.addresses[0].number});
        this.set({name:'addressApart', value:this.user.addresses[0].appart});
        this.set({name:'addressPorch', value:this.user.addresses[0].porch});
        this.data.addressStreet = this.user.addresses[0].street;
        this.data.addressNumber = this.user.addresses[0].number;
        this.data.addressApart = this.user.addresses[0].appart;
        this.data.addressPorch = this.user.addresses[0].porch;
      }
    }
  },
}
</script>

<style>

</style>