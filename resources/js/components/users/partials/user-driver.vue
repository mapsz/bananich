<template>
<div>
  <h5>Водила</h5>

  <div v-if="isDriver !== null">

    <!-- Not Driver -->
    <div v-if="isDriver == false">

      <!-- To Driver -->
      <b-button variant="primary" v-b-modal.to-driver-confirm>Мутировать в водителя</b-button>

      <b-modal id="to-driver-confirm" title="Точно?" @ok="toDriver()">
        <p class="my-4">{{user.name}} {{user.phone}}</p>
      </b-modal>

    </div>

    <!-- Driver -->
    <div v-if="isDriver == true" style="color:limegreen">
      № <b>{{user.id}}</b> 🚚
    </div>

  </div>


</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {  
computed:{
  ...mapGetters({user:'user/getOne'}),
  isDriver:function(){
    if(this.user == undefined || this.user.roles == undefined) return null;
    if(this.user.roles[0] == undefined) return false;

    let isDriver = false;

    $.each(this.user.roles, (k, role) => {
      if(role.name == 'driver'){
        isDriver = true;
        return true;
      } 
    });

    return isDriver;
  }
},
methods:{
  async toDriver(){
    let r = await ax.fetch('/user/to/driver',{user_id: this.user.id}, 'post');
    location.reload();
  }
},

}
</script>

<style>

</style>