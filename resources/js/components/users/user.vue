<template>
<div>
  <gruzka-navbar></gruzka-navbar>

  <div class="container-fluid mb-3">

    
    <div class="row">
      <div class="col-12 col-lg-8">   
        <juge-form :inputs="inputs" :errors="errors" @submit="submit"></juge-form>
      </div>
      <div class="col-12 col-lg-4" v-if="id">        
        <!-- Main Photo -->
        <user-main-photo class="mb-3 border p-2" />
        <!-- Comments -->
        <user-comments :user-id="user.id" class="mb-3 border p-2" />
        <!-- Login as -->
        <user-login-as class="mb-3 border p-2" />
        <!-- Driver -->
        <user-driver class="mb-3 border p-2" />
        <!-- Сollector -->
        <user-collector class="mb-3 border p-2" />
      </div>
    </div>
  </div>

</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
data(){return{
  id:false,
}},
computed:{
  ...mapGetters({user:'user/getOne',inputs:'user/getInputs',errors:'user/getErrors'}),    
},
async mounted(){      
  //Get
  if(this.$route.params.id > 0){
    this.id = this.$route.params.id;
  }    
  //Fetch product
  if(this.id){
    await this.fetch(this.id);
  }
  //Fetch inputs
  this.fetchInputs();
    
},
methods:{
  ...mapActions({
    'fetch':'user/fetchOne',
    'fetchInputs':'user/fetchInputs',
  }),
  async submit(data){ 
    console.log(data);
    let params = {};
    params.data = {};
    params.data.id        = this.id;
    params.data.name      = !data.name ? this.user.name : data.name;
    params.data.surname   = !data.surname ? this.user.surname : data.surname;
    params.data.phone     = !data.phone ? this.user.phone : data.phone;
    if(data.images != undefined && data.images[0] != undefined) params.data.images = data.images;
    let r = await ax.fetch('/user', params, 'post');

    if(r) location.reload();
  }
}
}
</script>

<style>

</style>