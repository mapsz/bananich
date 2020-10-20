<template>
<div>
  <h5>Зрузчик</h5>

  <div v-if="isCollector !== null">

    <!-- Not Driver -->
    <div v-if="isCollector == false">

      <!-- To Driver -->
      <b-button variant="primary" v-b-modal.to-driver-confirm>Мутировать в грузчика</b-button>

      <b-modal id="to-driver-confirm" title="Точно?" @ok="toCollector()">
        <p class="my-4">{{user.name}} {{user.phone}}</p>
      </b-modal>

    </div>

    <!-- Driver -->
    <div v-if="isCollector == true" style="color:limegreen">
      № <b>{{user.id}}</b> 📦
    </div>

  </div>


</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {  
computed:{
  ...mapGetters({user:'user/getOne'}),
  isCollector:function(){
    if(this.user == undefined || this.user.roles == undefined) return null;
    if(this.user.roles[0] == undefined) return false;

    let isCollector = false;

    $.each(this.user.roles, (k, role) => {
      if(role.name == 'collector'){
        isCollector = true;
        return true;
      } 
    });

    return isCollector;
  }
},
methods:{
  async toCollector(){
    let r = await ax.fetch('/user/to/collector',{user_id: this.user.id}, 'post');
    location.reload();
  }
},

}
</script>

<style>

</style>