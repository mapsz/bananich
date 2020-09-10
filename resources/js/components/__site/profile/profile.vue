<template>
  <div>
    <site-header></site-header>

    <main class="home">
      <div class="container">
        <!-- Breadcrumbs -->
        <breadcrumbs />
        <div class="row content-page">
          <!-- Navbar -->
          <div class="col-lg-4">            
            <profile-navbar></profile-navbar>
          </div>
          
          <div class="col-lg-8">            
            <div class="title-wrap title-page">
              <h2 class="title-h2">Личные данные</h2>
            </div>          
            <div class="content">
              <!-- Edit -->
              <div class="row">
                <div class="col-lg-8">
                  <form class="profile-form" action="">
                    <div class="form-group">
                      <label  class="form-label" for="name">Ваше имя</label>
                      <div v-if="edit==false" class="form-content form-content-name active">{{user.name}}</div>
                      <input v-model="data.name" v-if="edit==true" id="name" class="form-input " type="text">
                    </div>
                    <div class="form-group">
                      <label  class="form-label" for="surname">Ваша фамилия</label>
                      <div v-if="edit==false" class="form-content active">{{user.surname}}</div>
                      <input v-model="data.surname" v-if="edit==true" id="surname" class="form-input " type="text">
                    </div>
                    <div class="form-group">
                      <label  class="form-label" for="surname">Ваш адрес</label>
                      <div v-if="edit==false" class="form-content active"></div>
                      <input v-model="data.address" v-if="edit==true" id="surname" class="form-input " type="text">
                    </div>
                    <div class="form-group">
                      <label  class="form-label" for="surname">Ваш e-mail</label>
                      <div v-if="edit==false" class="form-content active">{{user.email}}</div>
                      <input v-model="data.email" v-if="edit==true" id="surname" class="form-input " type="text">
                    </div>
                    <span v-if="edit==true" style="color:orange">Замена емаил когда будет домен</span><!--  TODO @@@ -->
                    <div class="form-button">
                      <a v-if="edit==false" @click="edit=true" class="form-url" href="#">Редактировать личные данные</a>
                      <button @click.prevent="doEdit()" v-if="edit==true" class="btn-yellow btn-big">Сохранить изменения</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <form action="" class="profile-password">
                    Изменить пароль
                    <span style="color:orange">Замена пароля когда будет домен</span><!--  TODO @@@ -->
                    <div class="row profile-password-wrap">
                      <div class="col-md-4 profile-password-group"><input type="text" class="form-input" placeholder="Старый пароль"></div>
                      <div class="col-md-4 profile-password-group"><input type="text" class="form-input" placeholder="Новый пароль"></div>
                      <div class="col-md-4 profile-password-group"><button class="btn-yellow btn-empty">Подтвердить</button></div>
                    </div>
                    <logout />
                  </form>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <site-footer></site-footer>
  </div>
</template>

<script>
import {mapGetters} from 'vuex';
export default {
  data(){return{
    data:{},
    edit:false,
  }},
  computed:{
    ...mapGetters({user:'user/get'}), 
  },
  methods:{
    doEdit(){
      //
    }
  },
}
</script>

<style>

</style>