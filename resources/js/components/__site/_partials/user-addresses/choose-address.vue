<template>
  <div class="">
    <show-address v-if="choosedAddress" :address="choosedAddress" />
    <button v-if="showAddresses==false" @click.prevent="showAddresses=true" class="form-url mt-2" style="margin-top:0px">
      {{choosedAddress ? 'Изменить адрес' : 'Выбрать адрес'}}      
    </button>
    <user-addresses :choose="1" :active="showAddresses" @close="showAddresses=false" @choose="doChoose" />
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
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
  //
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