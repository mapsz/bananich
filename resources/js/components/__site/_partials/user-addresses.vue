<template>
<div class="user-addresses">

  <div class="user-addresses-edit">
    <!-- Address -->
    <div class="form-group mb-2" style="position:relative">
      <input id="user-addresses-address" class="form-input user-addresses-address" type="text" name="address" required="required">
      <label for="user-addresses-address" class="user-addresses-placeholder"><span style="color:tomato;">*</span>Адрес</label>
    </div>

    <!-- Home \ Appart -->
    <div class="form-group mb-2 d-flex form-group-multi">
      <input class="form-input" placeholder="Номер дома" type="text" name="address">
      <input class="form-input" placeholder="Квартира" type="text" name="address">
    </div>

    <!-- Porch \ Stage \ Intercom -->
    <div class="form-group mb-2 d-flex form-group-multi">
      <input class="form-input" placeholder="Подъезд" type="text" name="address">
      <input class="form-input" placeholder="Этаж" type="text" name="address">
      <input class="form-input" placeholder="Домофон" type="text" name="address">
    </div>
    
    <!-- Default -->
    <div class="mb-3">
      <label for="user-addresses-default">
        <input name="sort" id="user-addresses-default" type="checkbox" class="checkbox"> 
        <div class="checkbox-box"></div>
        <span style="padding-left:25px">Сделать адресом по умолчанию</span>
      </label>
    </div>

    <!-- Errors -->
    <juge-errors :errors="errors"/>
    
    <!-- Actions -->
    <div class="d-flex justify-content-between">
      <button class="x-btn x-btn-sm x-btn-trans">Отмена</button>
      <button @click="add()" class="x-btn x-btn-sm">Сохранить</button>
    </div>
  </div>

</div>
</template>

<script>
export default {
data(){return{
  errors:[],
}},

methods:{
  async add(){
    let r = await ax.fetch('/user/address', {}, 'put');

    //Catch errors
    if(!r){if(ax.lastResponse.status == 422){this.errors = ax.lastResponse.data.errors;return;}}
  }
},
}
</script>

<style scoped>
  /* input */
  .user-addresses input{
    background-color: #ffffff00;
  }
  /* Placeholder */
  .user-addresses-placeholder{
    position: absolute;
    left: 0;
    margin: 0;
    padding: 10px 0;
    color:#828282;
  }
  input.user-addresses-address:invalid + label {
      display: inline-block;
  }  
  input.user-addresses-address:valid + label{
      display: none;
  }
  /* Default */
  .user-addresses .checkbox:checked + .checkbox-box:before, .checkbox:not(:checked) + .checkbox-box:before {
    margin-top: 3px;
  }
  .user-addresses .checkbox:checked + .checkbox-box:after, .checkbox:not(:checked) + .checkbox-box:after {
    margin-top: 3px;
  }


</style>