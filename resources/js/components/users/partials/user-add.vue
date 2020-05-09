<template>
<div>
  <gruzka-navbar></gruzka-navbar>
  <div class="container-fluid">
    <h2>Добавть пользователя</h2>

    <!-- Имя -->
    <div class="form-group row">
      <label for="inputName" class="col-sm-2 col-form-label">Имя</label>
      <div class="col-sm-10">
        <input v-model="name" id="inputName" type="text" placeholder="">
      </div>
    </div>
    <!-- Пароль -->
    <div class="form-group row">
      <label for="inputEmail" class="col-sm-2 col-form-label">Емаил</label>
      <div class="col-sm-10">
        <input v-model="email" id="inputEmail" type="email" placeholder="">
      </div>
    </div>
    <!-- Пароль -->
    <div class="form-group row">
      <label for="inputPassword" class="col-sm-2 col-form-label">Пароль</label>
      <div class="col-sm-10">
        <input v-model="password" id="inputPassword" type="password" placeholder="">
      </div>
    </div>

    <div>
      <ul>
        <li v-for="e in errorsResponse" :key="e">
          {{e}}
        </li>
      </ul>

    </div>

    <button @click="put()" class="btn btn-success">Добавить</button>

  </div>
</div>
</template>

<script>
export default {
data(){return{
  name:"",
  email:"",
  password:"",
  errorsResponse:[],
}},
methods:{
  async put(){
    this.errorsResponse = [];

    //Put
    let r = await this.jugeAx('/user',{
      data:{
        name:this.name,
        email:this.email,
        password:this.password,
      }
    },'put');   
    
      //Errors
    if(!r){
      let e = this.jugeAxResponse();
      if(e.status == 422){          
        this.errorsResponse = e.data.errors;
      }
      return false;
    }

    this.$router.push('/users');
    return true;
  }
},
}
</script>

<style>

</style>