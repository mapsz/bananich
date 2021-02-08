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
  defautSet:false,

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
  user: function (val, oldVal) {
    this.watchUserLoad();
  },
},
async mounted() {
  this.watchUserLoad();
},
methods:{
  watchUserLoad(){
    if(this.defautSet) return;
    if(this.user == undefined || this.user.id == undefined) return;
    let d = this.addresses.find(x => x.default == 1);
    if(d) this.choosedAddress = d;
    this.defautSet = true;
  },
  doChoose(id){
    this.choosedAddress = this.addresses.find(x => x.id == id);
  }
},
}
</script>

<style>

</style>