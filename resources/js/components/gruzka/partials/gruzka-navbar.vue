<template>  
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <router-link class="navbar-brand" to="/main">GRUZKA</router-link>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li v-for='(link,i) in links' :key='i' :class="current == link.link ? 'active' : ''" class="nav-item">
        <router-link class="nav-link" :to="link.link">{{link.caption}}</router-link>
      </li>
    </ul>
    <!-- Auth -->
    <div v-if="user" class="w-100 d-flex" style="justify-content:flex-end">
      <!-- Profile -->
      <div class="align-self-center mx-2">
        <!-- <span>{{user.name}}</span> -->
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
    links:[
      {
        link:"/main",
        caption:"main",
      },
      {
        link:"/order-list",
        caption:"Заказы",
      },
      {
        link:"/confirm",
        caption:"Подтверждение",
      },
      {
        link:"/gruzka",
        caption:"Gruzka",
      },
      {
        link:"/containers",
        caption:"Контейнеры",
      },
      {
        link:"/products-list",
        caption:"Продукты",
      },
      {
        link:"/users",
        caption:"Пользователи",
      },
      {
        link:"/strews",
        caption:"Сыпучка",
      },
      {
        link:"/statistics",
        caption:"Статистика",
      },
      {
        link:"/report",
        caption:"Учёт",
      },
      {
        link:"/deliveries",
        caption:"Выдача",
      },
    ]
  }},
  mounted(){
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