<template>
<div>
  <gruzka-navbar></gruzka-navbar>
  <div class="container-fluid">
    <!-- Add -->
    <router-link :to="'/user/add'">
      <button class="btn btn-success">Добавить пользователя</button>
    </router-link>
   


    <!-- List -->
    <user-list />

  </div>

</div>
</template>

<script>
export default {

}
</script>

<style>

</style>