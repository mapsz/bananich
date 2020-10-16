<template>
  <div>

    <h3>Ограничение доставки</h3>

    <div class="row">
      <!-- Delivery Days -->
      <div class="col-6">
        <h5>Дни доставки</h5>

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

        <button @click="saveDays()" class="btn btn-success">Сохранить</button>

      </div>

      <!-- Delivery time -->
      <div class="col-6">
        <h5>Часы перед заказом</h5>
        <input v-model="time" class="my-3" type="number" min='0'>
        <button @click="saveTime()" class="btn btn-success">Сохранить</button>
      </div>
    </div>

  </div>
</template>

<script>
import {mapGetters} from 'vuex';
export default {
data(){return{
  days:[],
  time:0,
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
      //Days
      if(this.product.deliveryDays == undefined){
        this.days = [];
      }else{
        this.days = JSON.parse(this.product.deliveryDays);
      } 

      //Time
      if(this.product.deliveryTime == undefined){
        this.time = 0;
      }else{
        this.time = JSON.parse(this.product.deliveryTime);
      } 
    },
    deep: true
  },  
},
methods:{
  async saveDays(){
    let r = await ax.fetch('/product/delivery/limits',{'days':this.days,'productId':this.product.id},'post');
    location.reload();
  },
  async saveTime(){
    let r = await ax.fetch('/product/delivery/limits',{'time':this.time,'productId':this.product.id},'post');
    location.reload();
  }
},

}
</script>

<style>

</style>