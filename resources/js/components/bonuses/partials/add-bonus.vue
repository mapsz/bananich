<template>
<div class="container-fluid">


    
  <!-- Actions -->
  <div class="my-3">
    <!-- Add -->
    <div class="purchases-add">
      <button v-if="!add" @click="add=true" class="btn btn-success">Добавить</button>
      <div v-if="add">
        <div class="add-bonus-container mb-3">
          <h3 class="d-inline-block">Добавить</h3>
          <!-- Close -->
          <button @click="add=false" class="btn btn-danger" style="float: right;">X</button>
        </div>
      </div>
    </div>
  </div>  




  <!-- Form -->
  <!-- <div v-if="product && suppliers.length > 0" class="add-suppliers-form">
    <juge-form :inputs="inputs" :errors="errors" @submit="put"></juge-form>
  </div> -->

</div>
</template>

<script>
export default {
data(){return{
  add:false,
}},
}
</script>

<style scoped>
  .add-bonus-container {
      background-color: #e4f9e4;
      padding: 20px;
      border: 1px solid green;
      border-radius: 7px;
      margin: 10px 0px;
  }
</style>