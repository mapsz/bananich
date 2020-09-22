<template>
  <ul 
    v-if="menus != undefined && menus[0] != undefined"
    class="m-0 menu-navbar" 
    style="line-height: 1; "
    :style="columns == undefined ? 'display: flex' : ('display: grid;grid-template-columns: repeat(' +columns+ ', 1fr);') "
  >
    <li v-for='(menu,i) in menus' :key='i' class="m-2">
      <a 
        v-if="menu.pages != undefined && menu.pages[0] != undefined" 
        :href="'/'+menu.pages[0].link" 
        class="nav-link-sad"
        style="font-size:12pt"
      >
        {{menu.name}}
      </a>
    </li>
  </ul>
</template>

<script>
export default {
  props: ['columns','menus'],
}
</script>

<style>

  @media screen and (max-width: 991px) {
    .menu-navbar{
      grid-template-columns: repeat(1, 1fr) !important;
    }
  }
</style>