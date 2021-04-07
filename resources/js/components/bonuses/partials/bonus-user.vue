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
    <!-- Bonus -->
    <div class="mx-3">
      <div>Доступно</div>
      <div> 
        <b v-if="isBalance">
          {{user.balance}}
        </b> 
        <b v-else>
          {{user.bonus}}
        </b>
      </div>
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
props: ['isBalance'],
data(){return{
  user:false,
}},
mounted(){
  if(this.isBalance){
    this.$store.dispatch('user/addFilter',{'with_balance':1});
  }else{
    this.$store.dispatch('user/addFilter',{'with_bonus':1});
  }
},
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