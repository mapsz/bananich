<template>
  <div class="catalog-item-icon">
    <img v-if="product.no_lactose != undefined && product.no_lactose == 1" src="/image/no-milk.svg" alt="Без лактозы" data-toggle="tooltip" title="Без лактозы">
    <img v-if="product.no_gluten != undefined && product.no_gluten == 1" src="/image/no-gluten.svg" alt="Без глютена" data-toggle="tooltip" title="Без глютена">
    <img v-if="product.no_sugar != undefined && product.no_sugar == 1" src="/image/no-sugar.svg" alt="Без сахара" data-toggle="tooltip" title="Без сахара">
    <img v-if="product.no_egg != undefined && product.no_egg == 1" src="/image/no-eggs.svg" alt="Без яиц" data-toggle="tooltip" title="Без яиц">
    <img v-if="product.no_heat != undefined && product.no_heat == 1" src="/image/no-heat.svg" alt="Без термической обработки" data-toggle="tooltip" title="Без термической обработки">
    <img v-if="product.low_glycemic != undefined && product.low_glycemic == 1" src="/image/low-glycemic.svg" alt="Низкий гликемический индекс" data-toggle="tooltip" title="Низкий гликемический индекс">
    <img v-if="product.eco != undefined && product.eco == 1" src="/image/eco.svg" alt="Эко сертификат" data-toggle="tooltip" title="Эко сертификат">
  </div>
</template>

<script>
export default {
  props: ['product'],
  mounted(){
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
  },
}
</script>

<style scoped>
  .catalog-item-icon img{
    width:30px;
    display: inline-block;
  }
</style>