<template>
  <div class="row">
    <!-- Delivery Time -->
    <div class="col-lg-6">
      <div class="checkout-title">Дата доставки</div>
      <checkout-input :name="'deliveryDate'" :type="'radio'" 
        :list="[
          {value:'2020-09-14',caption:'09-14'},
          {value:'2020-09-15',caption:'09-15'},
          {value:'2020-09-16',caption:'09-16'}
        ]" 
      />
    </div>
    <!-- Delivery Time -->
    <div class="col-lg-6">
      <div class="checkout-title">Время доставки</div>      
      <checkout-input :name="'deliveryTime'" :type="'radio'" 
        :list="[
          {value:{from:'01:00:00',to:'12:00:00'},caption:'с 9 до 21'},
          {value:{from:'01:00:00',to:'12:00:00'},caption:'с 9 до 12'},
          {value:{from:'02:00:00',to:'12:00:00'},caption:'с 12 до 15'},
          {value:{from:'03:00:00',to:'12:00:00'},caption:'с 15 до 18'},
          {value:{from:'04:00:00',to:'12:00:00'},caption:'с 18 до 21'},
        ]" 
      />
    </div>
  </div>  
</template>

<script>
export default {  
}
</script>

<style scoped>
.form-group{
  margin-bottom: 0px !important;
}
</style>