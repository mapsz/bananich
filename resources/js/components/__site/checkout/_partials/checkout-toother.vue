<template>
<div style="margin-bottom: 30px;">
  <div class="form-checkbox">
    <input v-model="show" class="custom-checkbox" type="checkbox" id="gift" name="color-1" value="indigo">
    <label for="gift" class="gift">Заказ для другого человека</label>
  </div>

  <div v-show="show">
    <div class="form-group">
      <input v-model="data.name" class="form-input" placeholder="Имя" type="text">
    </div>
    <div class="form-group">
      <input v-model="data.phone" class="form-input" placeholder="Телефон" type="text">
    </div>
    <div class="form-group">
      <textarea v-model="data.comment" class="form-textarea mt-3" placeholder="Текст получателю" type="text"></textarea>
    </div>
    <div class="d-flex align-items-center">
      <div class="checkout-info-ico"><img src="image/order/i.svg" alt="info"></div>
      <div class="checkout-info-text">Ссылка на оплату вам будет отправлена после получения подарка адресатом.              </div>
    </div>
  </div>

</div>  
</template>

<script>
export default {
model: {event: 'blur'},
data(){return{
  show:false,
  data:{},
}},
watch: {
  show:function(){this.data.toOther = this.show},
  data: {handler: function () {this.$emit('blur',this.data);},deep: true}
},
}
</script>

<style>

</style>