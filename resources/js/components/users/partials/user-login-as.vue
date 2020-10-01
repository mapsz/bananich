<template>
<div>
  <h5>Авторизоваться</h5>
  <a :href="'/login/as/user?id='+user.id">{{user.name}}</a>
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  computed:{
    ...mapGetters({user:'user/getOne'}),    
  },
}
</script>

<style>

</style>