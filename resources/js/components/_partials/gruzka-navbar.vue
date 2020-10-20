<template>  
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <router-link class="navbar-brand" to="/main">GRUZKA</router-link>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul v-if="isAdmin" class="navbar-nav">
      <li v-for='(link,i) in links' :key='i' :class="current == link.link ? 'active' : ''" class="nav-item">
        <!-- <router-link class="nav-link" :to="link.link">{{link.caption}}</router-link> -->
        <a class="nav-link" :href="link.link">{{link.caption}}</a>
      </li>
    </ul>
    <!-- Auth -->
    <div v-if="user" class="w-100 d-flex" style="justify-content:flex-end">
      <!-- Profile -->
      <div class="align-self-center mx-2">
        <span>{{user.name}}</span>
      </div>
      <!-- Logout -->
      <div>
        <button @click="logout()" class="btn btn-sm btn-outline-danger" type="button">Выход</button>
      </div>
    </div> 
  </div>
</nav>
</template>

<script>
export default {
  data(){return{
    user:{},
    current:this.$route.path,
    adminPrefix:'/admin',
    links:[],
  }},
  computed:{
    isAdmin:function(){
      if(this.user == undefined || this.user.roles == undefined) return null;
      if(this.user.roles[0] == undefined) return false;

      let isRole = false;

      $.each(this.user.roles, (k, role) => {
        if(role.name == 'admin'){
          isRole = true;
          return true;
        } 
      });

      return isRole;
    }
  },
  mounted(){
    this.links = [
      {
        link: this.adminPrefix+"/orders",
        caption:"Заказы",
      },
      {
        link: this.adminPrefix+"/gruzkas",
        caption:"Gruzka",
      },
      {
        link: this.adminPrefix+"/pages",
        caption:"Страницы",
      },
      // {
      //   link: this.adminPrefix+"/containers",
      //   caption:"Контейнеры",
      // },
      {
        link: this.adminPrefix+"/products",
        caption:"Продукты",
      },
      {
        link: this.adminPrefix+"/users",
        caption:"Пользователи",
      },
      {
        link: this.adminPrefix+"/statistics",
        caption:"Статистика",
      },
      {
        link: this.adminPrefix+"/reports",
        caption:"Учёт",
      },
      {
        link: "/driver",
        caption:"Водитель",
      },
      {
        link: this.adminPrefix+"/bonuses",
        caption:"Бонусы",
      },
      // {
      //   link: this.adminPrefix+"/interviews",
      //   caption:"Опрос",
      // },
      {
        link: this.adminPrefix+"/settings",
        caption:"Настройки",
      },
      {
        link: this.adminPrefix+"/coupons",
        caption:"Купоны",
      },
      {
        link: this.adminPrefix+"/not/founds",
        caption:"неНайдено",
      },
      {
        link: this.adminPrefix+"/sms",
        caption:"смс",
      },
    ];

    this.auth();
  },
  methods:{
    async auth(){
      let r = await this.jugeAx('/auth/user');
      this.user = r;
    },
    async logout(){
      let r = await this.jugeAx('/logout',{},'post');
      let response = this.jugeAxResponse();
      if(response.status == 401){
        location.reload(); 
      }
      
      
    },
  },
}
</script>

<style scoped>

.navbar-nav{  
  font-size: 12pt;
}

</style>