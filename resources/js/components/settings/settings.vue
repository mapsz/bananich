<template>
<div>    
  <!-- Menu -->
  <gruzka-navbar></gruzka-navbar>
  
  <div class="container">
    
    <h1>Настройки</h1>

    <div>
      <!-- <h4>Доставка</h4> -->
      <juge-form :inputs="inputs" :errors="errors" @submit="post"></juge-form>

    </div>
    


  </div>

</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    inputs:[],
    delivery:[],
    errors:[],
  }},
  computed:{
    ...mapGetters({
      settings:'settings/get'
    }),    
  },  
  async mounted(){    
    //Get settings
    await this.get();

    this.inputs = this.settings;

    // //Setup inputs form
    // do{
    //   let i = -1;
    //   i = this.settings.findIndex(x => x.name == 'free_shipping');
    //   console.log(i);
    //   if(i > -1){      
    //     this.delivery.push({
    //       name      : this.settings[i].name,
    //       caption   : this.settings[i].name,
    //       value     : this.settings[i].value
    //     });
    //   }
    //   i = this.settings.findIndex(x => x.name == 'shipping_price');
    //   if(i > -1){ 
    //     this.delivery.push({
    //       name      : this.settings[i].name,
    //       caption   : this.settings[i].name,
    //       value     : this.settings[i].value
    //     });
    //   }
    // }while(0);

    //

  },
  methods:{
    ...mapActions({
      'get':'settings/fetch',
    }),
    async post(data){
      let r = await ax.fetch('/settings', data, 'post');
      location.reload();
    }
  }
}
</script>

<style>

</style>