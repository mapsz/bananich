<template>
<div>
  <h5>Авторизоваться</h5>
  <a @click="login()" href="#">{{user.name}} ↘️</a>
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  computed:{
    ...mapGetters({user:'user/getOne'}),    
  },
  methods:{
    async login(){
      localStorage.cart = false;
      window.location.href = '/login/as/user?id='+this.user.id;
    }
  },
}
</script>

<style>

</style>