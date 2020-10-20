<template>
  <ul 
    v-if="showMenus != undefined && showMenus[0] != undefined"
    class="m-0 menu-navbar" 
    style="line-height: 1; "
    :style="columns == undefined ? 'display: flex' : ('display: grid;grid-template-columns: repeat(' +columns+ ', 1fr);') "
  >
    <li v-for='(menu,i) in showMenus' :key='i' class="m-2">
      <a 
        :href="'/'+menu.link" 
        class="nav-link-sad"
        style="font-size:12pt"
      >
        {{menu.menu_title}}
      </a>
    </li>
  </ul>
</template>

<script>
export default {
  props: ['columns','menus','position'],
  computed:{
    showMenus: function(){
      if(this.menus == undefined) return [];
      let menus = [];
      
      $.each(this.menus, (k, menu) => {
        if(menu.menu.findIndex(x => x.name == this.position) > -1){
          menus.push(menu);
        }        
      });
      return menus;
    }
  },
}
</script>

<style>

  @media screen and (max-width: 991px) {
    .menu-navbar{
      grid-template-columns: repeat(1, 1fr) !important;
    }
  }
</style>