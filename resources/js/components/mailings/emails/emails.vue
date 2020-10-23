<template>
<div>  
  <gruzka-navbar></gruzka-navbar>  

  <div class="container-fluid">

    <h1>Emails</h1>

    <!-- Add -->
    <a href="/admin/email"><button class="btn btn-success">Добавить</button></a>

    <!-- List -->
    <juge-list :data="'email'" />

  </div>
  
</div>
</template>

<script>
export default {

}
</script>

<style>

</style>