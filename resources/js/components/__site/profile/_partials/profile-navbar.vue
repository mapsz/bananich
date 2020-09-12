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
  links:[
    {
      link:'/profile',
      caption:'Личные данные',
    },
    {
      link:'/profile/favorites',
      caption:'Избранное',
    },
    {
      link:'/profile/bonus',
      caption:'Бонусы',
    },
    {
      link:'/profile/orders',
      caption:'Мои заказы',
    },
  ]
}},
}
</script>

<style>

</style>