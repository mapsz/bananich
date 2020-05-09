<template>
  <div class="container">
    <div class="fixed-bottom">
      <div class="d-flex justify-content-between mx-1">
        <div class="item">
          <font-awesome-icon icon="box-open" size="2x"/>
          Меню
        </div>
        <div class="item">
          <font-awesome-icon icon="edit" size="2x"/>
          Корзина
        </div>
        <div class="item">
          <font-awesome-icon icon="code" size="2x"/>
          Профиль
        </div>
        <div class="item">
          <font-awesome-icon icon="list" size="2x"/>
          Поиск
        </div>
        <div class="item">
          <font-awesome-icon icon="times" size="2x"/>
          Для вас
        </div>



      </div>
    </div>
  </div>
</template>

<script>
export default {

}
</script>

<style scoped>
.item{
  display: flex;
  flex-direction: column;
  align-items: center;
}
</style>