<template>
  <div>
    <h3>Дни доставки</h3>

    <div style="display: flex; flex-direction: column;">
      <span><input v-model="all" type="checkbox" id="day0" value="0" > <label for="day0">Все</label></span>
      <span><input v-model="days" type="checkbox" id="day1" value="1" > <label for="day1">Понедельник</label></span>
      <span><input v-model="days" type="checkbox" id="day2" value="2" > <label for="day2">Вторник</label></span>
      <span><input v-model="days" type="checkbox" id="day3" value="3" > <label for="day3">Среда</label></span>
      <span><input v-model="days" type="checkbox" id="day4" value="4" > <label for="day4">Четверг</label></span>
      <span><input v-model="days" type="checkbox" id="day5" value="5" > <label for="day5">Пятница</label></span>
      <span><input v-model="days" type="checkbox" id="day6" value="6" > <label for="day6">Суббота</label></span>
      <span><input v-model="days" type="checkbox" id="day7" value="7" > <label for="day7">Воскресенье</label></span>
    

    </div>

    
    <button @click="save()" class="btn btn-success">Сохранить</button>

  </div>
</template>

<script>
import {mapGetters} from 'vuex';
export default {
data(){return{
  days:[],
  all:true,
}},
computed:{
  ...mapGetters({product:'product/getOne'}),
},
watch: {
  all: function(){
    if(this.all) this.days = [];
  },
  days: {
    handler: function (val, oldVal) {
      if(this.days.length > 0){
        this.all = false;
      }
      if(this.days.length == 0){
        this.all = true;
      }

    },
    deep: true
  },  
  product: {
    handler: function (val, oldVal) {    
      if(this.product.deliveryDays == undefined){
        this.days = [];
      }else{
        this.days = JSON.parse(this.product.deliveryDays);
      } 
    },
    deep: true
  },  
},
methods:{
  async save(){
    let r = await ax.fetch('/product/delivery/days',{'days':this.days,'productId':this.product.id},'post');

    location.reload();
  }
},

}
</script>

<style>

</style>