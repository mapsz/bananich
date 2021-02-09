<template>
  <div class="">
    <show-address v-if="choosedAddress && !hideShow" :address="choosedAddress" />
    <button v-if="showAddresses==false" @click.prevent="showAddresses=true" class="form-url mt-2" style="margin-top:0px">
      {{buttonBody ? buttonBody : (choosedAddress ? 'Изменить адрес' : 'Выбрать адрес')}}      
    </button>
    <user-addresses :no-pre='noPre' :choose="1" :active="showAddresses" @close="showAddresses=false" @choose="doChoose" />
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
props: ['no-pre', 'hide-show', 'pre-show', 'button-body'],
model: {event: 'blur'},
data(){return{
  choosedAddress:false,

  showAddresses:false,
}},
computed:{
  ...mapGetters({user:'user/get'}),
  addresses(){
    if(!this.user == undefined || !this.user.addresses == undefined) return false;
    return this.user.addresses;
  },
},
watch:{
  preShow: function(){
    this.choosedAddress = this.preShow;
  },
  choosedAddress: function(){
    if(this.preShow != undefined && this.preShow.id != undefined && this.choosedAddress.id == this.preShow.id) return false;
    this.$emit('blur', this.choosedAddress.id);  
  },
},
async mounted() {
  // this.watchUserLoad();
},
methods:{
  doChoose(id){
    this.choosedAddress = this.addresses.find(x => x.id == id);
  }
},
}
</script>

<style>

</style>