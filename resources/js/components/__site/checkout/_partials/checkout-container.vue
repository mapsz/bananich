<template>
<div class="col-md-12">
  <div class="checkout-title">Выбор упаковки</div>  
  <div class="form-group">
    <div v-for='(input,i) in list' :key='i' class="form-radio">

      <div class="d-flex" style="align-items: center;">
        <!-- input -->
        <input 
          v-model="inputValue" 
          class="custom-radio" 
          type="radio" 
          :id="'container-'+i" 
          :value="input.value" 
          :name="'container'"
        >
        <label :for="'container-'+i">{{input.caption}}</label>
        <!-- info -->
        <div>        
          <span v-if="input.value == 0" @click="showNoContainer=true" data-v-2252815c="" class="ml-2 info-icon info-icon-sm info-icon-success" style="color: black;cursor:pointer;"></span>
        </div>
      </div>
    </div>
  </div>

  <!-- About no Container -->
  <x-popup :title="'Без упаковки'" :active="showNoContainer" @close="showNoContainer=false" id="about-no-container-modal">
    Мы заботимся об окружающей среде и по умолчанию используем оборотную тару. Будьте готовы к тому, чтобы переложить товар из нашей тары в свою.
  </x-popup>  


</div>  
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    containers:[],
    inputValue:0,
    showNoContainer:false,
  }},
  computed:{
    ...mapGetters({cart:'cart/getCart'}),
    list:function(){
      //Default container
      let r = [{value:0, caption:'Без упаковки'}];

      //Optional containers
      if(this.containers.length > 0){
        this.containers.forEach((container) => {
          r.push({
            'value':    container.id,
            'caption':  container.name + ' (+'+parseInt(container.price)+'р за шт.)',
          });          
        });
      }     

      return r;
    }
  },
  watch: {
    cart: {
      handler: function (val, oldVal) {
        if(this.cart == undefined || this.cart.container == undefined || this.cart.container == false) return;
        this.inputValue = this.cart.container.id;
      },
      deep: true
    },
    inputValue: function(newVal,oldVal){
      if(newVal > 0){
        this.edit(newVal);
      }else{
        this.remove();
      }
    },
  },
  mounted(){
    this.get();
  },
  methods:{
   ...mapActions({
      'edit':'cart/editContainer',
      'remove':'cart/removeContainer',
    }),  
    async get(){
      let r = await ax.fetch('/juge?category=1000&model=product');
      this.containers = r;
      
    }
  },
}
</script>

<style>

</style>