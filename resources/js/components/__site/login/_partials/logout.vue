<template>
  <span>
    <a href="/logout" class="form-url" @click="logout()" >Выйти из аккаунта</a>
    <form id="logout-form" action="/logout" method="POST" style="display: none;">
      <input type="hidden" name="_token" v-bind:value="csrf">
    </form>  
  </span>
</template>

<script>
export default {
  data(){return{
    csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
  }},  
  methods:{
    logout(){
      event.preventDefault(); document.getElementById('logout-form').submit();
    }
  },
}
</script>

<style>

</style>