<template>
<div>
  
  <h4>Клиент</h4>

  <!-- Search -->
  <juge-pre-search @choose="choose" :model="'user'"/>

  <!-- User -->
  <div v-if="user" class="mt-2 d-flex">
    <!-- Image -->
    <div class="mx-3">
      <img :src="user.mainImage" alt="" style="width:100px">
    </div>
    <!-- Details -->
    <div class="mx-3">
      <div> <b>{{user.id}}</b> </div>
      <div>{{user.name}} {{user.surname}}</div>
      <div>{{user.email}}</div>
      <div>{{user.phone}}</div>
    </div>
    <!-- Comments -->
    <!-- <div class="mx-3">
      <user-comments :user-id="user.id" />
    </div> -->
    <!-- Cancel -->
    <div class="mx-3" style="align-self: center;">
      <button @click="choose(false)" class="btn btn-info">Отменить Клиента</button>
    </div>
  </div>
  
</div>
</template>

<script>
export default {
data(){return{
  user:false,
}},
methods:{
  choose(row){
    this.user = row;
    this.$emit('choose',row);
  }
},
}
</script>

<style>

</style>