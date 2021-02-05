<template>
<div class="sitebar">
  <div class="sitebar-title">Профиль</div>
  <ul class="sitebar-menu">
    <li 
      v-for='(link,i) in links' :key='i' 
      class="sitebar-item"
      :class="$route.path == link.link ? 'active' : ''"
    >
      <a class="sitebar-link" :href="link.link">{{link.caption}}</a>
    </li>
  </ul>
</div>
</template>

<script>
export default {
data(){return{
  isX:isX,
  links:[],
}},
async mounted() {

  this.links.push({link:'/profile',caption:'Личные данные',});
  this.links.push({link:'/profile/favorites',caption:'Избранное',});

  if(isX){
    // this.links.push({link:'/profile/shared/orders',caption:'Мои закупки',});
    this.links.push({link:'/profile/orders',caption:'Мои заказы',});
  }else{
    this.links.push({link:'/profile/bonus',caption:'Бонусы',});
    this.links.push({link:'/profile/orders',caption:'Мои заказы',});
  }

  

},
}
</script>

<style>

</style>