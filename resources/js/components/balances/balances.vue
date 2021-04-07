<template>
<div>
  <gruzka-navbar />
  <balances-navbar />
  
  <div class="container-fluid">  
    <h1>Баланс</h1>

    <!-- User -->
    <bonus-user :isBalance="true" @choose="choose"/>

    <!-- Bonus Move -->
    <div v-if="user" class="my-3 mt-2">
      <button  @click="balanceMove = 1" class="btn" :class="balanceMove == 1 ? 'btn-success' : 'btn-outline-success'">Добавить</button>
      <button  @click="balanceMove = 2" class="btn" :class="balanceMove == 2 ? 'btn-danger' : 'btn-outline-danger'">Отнять</button>

      <div v-if="balanceMove === 1" class="text-success"><h4>Добавить</h4> </div>
      <div v-if="balanceMove === 2" class="text-danger"><h4>Отнять</h4></div>
      <juge-form v-if="balanceMove" class="mt-3" :inputs="inputs" :errors="errors" @submit="doBalanceMove"></juge-form>
    </div>
  
    <!-- Move List -->  
    <div class="my-3">
      <h4>Список Движений</h4>
      <juge-list :data="'balance'" :pages="true"></juge-list>
    </div>

  </div>
  
</div>  
</template>

<script>
export default {
data(){return{
  balanceMove:false,
  errors:false,
  user:false,
}},
computed:{
  inputs: function(){
    let inputs = [
    {
      name:'quantity',
      caption:'Количество',
      required:true,
    },
    {
      name:'comment',
      caption:'Комментарий',
    },
  ];

  return inputs;
    
  }
},
methods:{  
  async choose(user){
    this.user = user;
    //Clear page filter
    this.$router.push({});
    this.$store.dispatch('balance/clearFilters');
    //Add filter
    if(!user){
      this.$store.dispatch('balance/addFilter',{1:1});
    }else{
      this.$store.dispatch('balance/addFilter',{'user_id':user.id});
    }      
  },
  async doBalanceMove(data){
    this.errors = false;
    data.id = this.user.id;
    if(this.balanceMove == 2) data.quantity -= data.quantity*2; 
    let r = await ax.fetch('/balance',data,'put');
    //Catch errors
    if(!r){      
      if(ax.lastResponse.status == 422){
        this.errors = ax.lastResponse.data.errors;
        return;
      }
    }

    this.user.balance += data.quantity;
    this.choose(this.user);
    this.balanceMove = false;  
  }
},
}
</script>

<style>

</style>