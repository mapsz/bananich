<template>
<div class="row checkout-form">
  <div class="col-12">
    
    <div class="form-checkbox" style="margin-bottom: 0px;">
      <checkout-input v-model="show" :name="'toOther'" :type="'checkbox'" />
      <label for="gift" class="gift">Заказ для другого человека</label>
    </div>

    <div v-show="show" style="margin-top: 20px;">
      <div class="form-group">      
        <checkout-input :name="'toOtherName'" :placeholder="'Имя'" />
      </div>
      <div class="form-group">
        <checkout-input :name="'toOtherPhone'" :placeholder="'Телефон'" />
      </div>
      <div class="form-group">
          <checkout-input :name="'toOtherComment'" :placeholder="'Текст получателю'" :type="'textarea'" />
      </div>
      <div class="d-flex align-items-center">
        <div class="checkout-info-ico"><img src="image/order/i.svg" alt="info"></div>
        <div class="checkout-info-text">Ссылка на оплату вам будет отправлена после получения подарка адресатом.</div>
      </div>
    </div>

  </div>  
</div>  
</template>

<script>
export default {
data(){return{
  show:false,
}},
}
</script>

<style scoped>
</style>