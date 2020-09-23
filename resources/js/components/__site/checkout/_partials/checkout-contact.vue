<template>
<div class="row checkout-address">
  <div class="col-12">
    <div class="checkout-title">Ваши данные</div>
    <div>
      <!-- Pre data -->
      <template>
        <div class="form-group"> 
          <div class="pl-3 form-content bold" :class="!edit ? 'active' : ''">{{user.name}}</div>          
          <checkout-input v-if="edit" v-model="name" :name="'name'" :placeholder="'Ваше имя'" />
        </div>

        <div class="form-group">
          <div class="pl-3 form-content"  :class="!edit ? 'active' : ''">{{user.phone}}</div>
          <checkout-input v-if="edit" v-model="phone" :name="'phone'" :placeholder="'Ваш телефон'" />
        </div>

        <div class="form-group">
          <div class="pl-3 form-content" :class="!edit ? 'active' : ''">{{user.email}}</div>
          <checkout-input v-if="edit" v-model="email" :name="'email'" :placeholder="'Ваш e-mail'" />
        </div>
      </template>

      <!-- Edit data -->
      <div v-if="user && edit==false" class="form-button" style="margin-top:0px">      
        <button @click="edit=true" class="form-url" style="margin-top:0px">Это не мои данные</button>
      </div>

    </div>
  </div>
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
model: {event: 'blur'},
data(){return{
  name:false,
  phone:false,
  email:false,
  edit: true,
  
  loadUser:false,
}},
computed:{
  ...mapGetters({user:'user/get',cart:'cart/getCart'}),
},
watch: {
  user: function(){
    this.loadUserData();      
  },
},
async mounted(){
  // this.getUser();
},
methods:{
  ...mapActions({'set':'checkout/setValue'}),
  isPreData(){
    if(this.user.name && this.user.phone && this.user.email){
      return true;
    }    
    return false;
  },
  loadUserData(){
    if(this.loadUser) return;
    if(!this.user) return;
    if(this.user == undefined ) return;

    this.loadUser = true;

    if(this.name === null && this.phone === null && this.email === null){
      if(this.isPreData()) this.edit = false;
    }

    if(this.user.name !== undefined && this.name === null){  
      this.set({name:'name', value:this.user.name});
      this.name = this.user.name;
    }
    if(this.user.phone !== undefined && this.phone === null){      
      this.set({name:'phone', value:this.user.phone});
      this.phone = this.user.phone;
    }
    if(this.user.email !== undefined && this.email === null){      
      this.set({name:'email', value:this.user.email});
      this.email = this.user.email;
    }

    
  }
},
}
</script>

<style>
.btn-signup {
    text-decoration: underline;
}
</style>