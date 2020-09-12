<template>
  <div class="row">
    <div class="col-lg-6">
      <div class="checkout-title">Дата доставки</div>
      <div class="form-group">
        <div class="form-radio">
          <input v-model="data.date" class="custom-radio" type="radio" id="date" name="date" value="2020-09-14">
          <label for="date">14.09.20</label>
        </div>
        <div class="form-radio">
          <input v-model="data.date" class="custom-radio" type="radio" id="date-2" name="date" value="2020-09-15">
          <label for="date-2">15.09.20</label>
        </div>
        <div class="form-radio">
          <input v-model="data.date" class="custom-radio" type="radio" id="date-3" name="date" value="2020-09-15">
          <label for="date-3">16.09.20</label>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="checkout-title">Время доставки</div>
      <div class="form-group">
        <div class="form-radio">
          <input v-model="data.time" class="custom-radio" type="radio" id="time" name="time" :value="{from:'09:00:00',to:'12:00:00'}">
          <label for="time">с 9:00 до 12:00</label>
        </div>
        <div class="form-radio">
          <input v-model="data.time" class="custom-radio" type="radio" id="time-2" name="time" :value="{from:'12:00:00',to:'15:00:00'}">
          <label for="time-2">с 12:00 до 15:00</label>
        </div>
        <div class="form-radio">
          <input v-model="data.time" class="custom-radio" type="radio" id="time-3" name="time" :value="{from:'15:00:00',to:'18:00:00'}">
          <label for="time-3">с 15:00 до 18:00</label>
        </div>
        <div class="form-radio">
          <input v-model="data.time" class="custom-radio" type="radio" id="time-4" name="time" :value="{from:'18:00:00',to:'21:00:00'}">
          <label for="time-4">с 18:00 до 21:00</label>
        </div>
      </div>
    </div>
  </div>  
</template>

<script>
export default {  
  model: {event: 'blur'},
  data(){return{
    data:{}
  }},
  watch: {
    data: {handler:function(){this.$emit('blur',this.data);},deep:true}
  },
}
</script>

<style>

</style>