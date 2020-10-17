<template>
<div>
  
  <gruzka-navbar></gruzka-navbar>

  <div class="container-fluid" ref="orderList">

    <h1>Бонусы</h1>

    <!-- Add -->
    <!-- <add-bonus></add-bonus> -->

    <!-- User -->
    <bonus-user @choose="choose"/>

    <!-- Bonus Move -->
    <div v-if="user" class="mt-2">
      <button  @click="bonusMove = 1" class="btn" :class="bonusMove == 1 ? 'btn-success' : 'btn-outline-success'">Добавить бонусы</button>
      <button  @click="bonusMove = 2" class="btn" :class="bonusMove == 2 ? 'btn-danger' : 'btn-outline-danger'">Отнять бонусы</button>

      <div v-if="bonusMove === 1" class="text-success"><h4>Добавить</h4> </div>
      <div v-if="bonusMove === 2" class="text-danger"><h4>Отнять</h4></div>
      <juge-form v-if="bonusMove" class="mt-3" :inputs="inputs" :errors="errors" @submit="doBonusMove"></juge-form>
    </div>

    <!-- Move List -->  
    <div class="my-3">
      <h4>Список Движений</h4>
      <juge-list :data="'bonus'" :pages="true"></juge-list>
    </div>
  </div>

</div>
</template>

<script>
export default {
  data(){return{
    bonusMove:false,
    errors:false,
    user:false,
  }},
  computed:{
    inputs: function(){
      let inputs = [
      {
        name:'count',
        caption:'Количество',
        required:true,
      },
      {
        name:'comment',
        caption:'Комментарий',
      },
    ];

    if(this.bonusMove === 1){
      inputs.push(
        {
          name:'dieDays',
          caption:'срок жизни(дни)',
          type:'number',
        }
      )
    }

    return inputs;
      
    }
  },
  mounted(){
    this.$store.dispatch('bonus/addFilter',{all_users:1});
  },
  methods:{
    async choose(user){
      this.user = user;
      //Clear page filter
      this.$router.push({});
      this.$store.dispatch('bonus/clearFilters');
      //Add filter
      if(!user){
        this.$store.dispatch('bonus/addFilter',{all_users:1});
      }else{
        this.$store.dispatch('bonus/addFilter',{'user':user.id});
      }      
    },
    async doBonusMove(data){
      this.errors = false;
      data.id = this.user.id;
      data.type = this.bonusMove;
      let r = await ax.fetch('/bonus/add',data,'put');
      //Catch errors
      if(!r){      
        if(ax.lastResponse.status == 422){
          this.errors = ax.lastResponse.data.errors;
          return;
        }
      }

      this.choose(this.user);
      this.bonusMove = false;
    },
  },

}
</script>

<style>

</style>