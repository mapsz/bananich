<template>
<div class="row">
  <div class="col-md-8">
  <div class="checkout-title">Комментарий к заказу</div>
  <div class="form-group">
    <textarea v-model="comment" class="form-textarea" placeholder="Ваш комментарий" type="text"></textarea>
  </div>
  </div>
</div> 
</template>

<script>
export default {
  model: {event: 'blur'},
  data(){return{
    comment:"",
  }},
  watch: {
    comment: {handler:function(){this.$emit('blur',this.comment);},deep:true}
  },
}
</script>

<style>

</style>