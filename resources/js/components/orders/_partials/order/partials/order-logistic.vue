<template>
  <div>
    <div v-for='(logistic,i) in logistics' :key='i'>
      <div>id: {{logistic.id}}</div>
      <div>адрес: {{logistic.address}}</div>
      <div>дата: {{logistic.date}}</div>
      <div>план. время приб.: {{logistic.plan_arrival_time}}</div>
      <br>
      <div class="row">
        <div class="col-6">
          <div>Водила: <a :href="'/admin/user/'+logistic.driver_id"></a>{{logistic.driver_id}} </div>
          <div>имя:{{logistic.driver.name != undefined? logistic.driver.name : ''}}</div>
          <div>фамилия:{{logistic.driver.surname != undefined? logistic.driver.surname : ''}}</div>
          <div>телефон:{{logistic.driver.phone != undefined? logistic.driver.phone : ''}}</div>
        </div>
        <div class="col-6">
          <img :src="logistic.driver.mainPhoto" style="width:100px">
        </div>
      </div>
      <hr>
    </div>
  </div>
</template>

<script>
import {mapGetters,mapActions} from 'vuex';
export default {
  computed:{
    ...mapGetters({order:'order/getOne'}),
    logistics:function(){
      if(this.order == undefined || this.order.logistics == undefined || this.order.logistics[0] == undefined) return [];

      return this.order.logistics;
    }
  },
}
</script>

<style>

</style>