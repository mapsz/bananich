<template>
<div class="container my-3" style="max-width: 600px">

  <!-- Navbar -->
  <ul class="modal-sad-tabs">
    <li class="modal-sad-tabs-item" :class="show=='signin' ? 'active' : ''">
      <a @click="changeShow('signin')" href="/login">Вход</a>
    </li>
    <li class="modal-sad-tabs-item" :class="show=='signup' ? 'active' : ''">
      <a @click="changeShow('signup')" href="/register">Регистрация</a>
    </li>
  </ul>

  <!-- Signin -->
  <signin v-if="show == 'signin'"></signin>

  <!-- Signup -->
  <signup v-if="show == 'signup'"></signup>


</div>
</template>

<script>
export default {
  props: ['p-show'],
  data(){return{
    show:'signin',

  }},
  mounted(){
    if(this.pShow) this.show=this.pShow;
  },
  methods:{
    changeShow(show){
      event.preventDefault();
      this.show = show;
    },
  },
}
</script>

<style scoped>

</style>