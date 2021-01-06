<template>
<div :class="halloween?'halloween':''">
  <header class="header" style="z-index: 100;" :class="(halloween?'halloween':'') +' '+(isX?'bananich-x':'')">

    <!-- navbar-sad -->
    <div class="header-nav">
        <div class="container header-nav-wrap-sad">
          <nav class="navbar-sad">
            <menu-component :menus="menus" :position="'top'"></menu-component>
          </nav>
          <div class="phone header-phone"><a :href="'tel:'+settings.phone_number">📞{{settings.phone_number}}</a></div>
      </div>
    </div>

    <!-- Header -->
    <div class="header-bar" :class="isX?'bananich-x':''" v-scroll="handleScroll" 
      style="position:absolute; width:100%; background-color:white;"
      :style="
        isMobile ? '' : (position > 55 ? 'height: 80px;top:0; position:fixed;' : '')
      "
    >
      <div class="container header-bar-wrap">

        <!-- Logo -->
        <a v-if="isX" href="/"><div class="neo-logo"></div> </a>
        <a v-else href="/"><div class="logo"></div> </a>
        
        <!-- Presents -->
        
        <template v-if="isX">
          <!-- bananichX <a :href="'https://' + (localServer ? 'bananich.loc' : 'bananich.ru')">bananich</a> -->
        </template>
        <template v-else>
          <present-bar :cart="cart" :settings="presentSettings"/>
        </template>

        
        
        <!-- Search -->
        <div class="search">
          <product-input-search />
        </div>

        <!-- User -->
        <div class="group-icon">
          <bonus-header-button v-if="!isX"/>
          <div class="user">
            <a href="/profile">
              <button class="user-btn"><img src="/image/lk.svg" alt="user" style="margin: auto;"></button>
            </a>
          </div>
        </div>

        <!-- Cart -->
        <cart-header />
      </div>
    </div>
  </header>  

  <div style="display: block; " :style="isMobile ? 'height: 62px;' : 'height: 108px;'"></div>

  <!-- Mobile upper header -->
  <div class="tap-bar">
    <div class="container">
      <mobile-bootom-menu></mobile-bootom-menu>
    </div>
  </div>
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    localServer:localServer,
    halloween:halloween,isX:isX,
    presentSettings:{},
    position:0,
  }},
  computed:{    
    isMobile:function(){return window.screen.width <= 768;},
    ...mapGetters({
      menus:'page/get',
      cart:'cart/getCart',
      settings:'settings/beautyGet',
      getCurrentFilters:'product/getFilters'
    }),
    search:function(){
      if(this.getCurrentFilters.search != undefined && this.getCurrentFilters.search !== ""){
        return true;
      }
      return false;
    }
  },    
  mounted(){    
    this.getUser();
    this.getCart();
    this.getSettings();
    this.getOtherSettings();
    this.handleScroll();
    this.getMenu();
  },
    
  methods:{
    ...mapActions({
      'getMenu':'page/fetchData',
      'getCart':'cart/fetch',
      'getUser':'user/fetch',
      'getOtherSettings':'settings/fetch',
    }),
    async getSettings(){
      this.presentSettings = await ax.fetch('/present/settings');
    },
    handleScroll: function (evt, el) {
      let position = window.scrollY;  

      this.position = position;

      // if(position > 900)
      //   this.showUp = true;
      // else
      //   this.showUp = false;
    }    
  }
}
</script>

<style scoped>

.page-x .user-btn{
  background: #8ac2a7;
}

.to-checkout {
    background: #FBE214;
    border: 1px solid #FBE214 !important;
    box-sizing: border-box;
    border-radius: 30px;
    color: #000000;
    width: 100%;
    height: 40px;
    line-height: 40px;
    font-size: 16px;
    text-align: center;
    cursor: pointer;
    display: inline-block;
    padding: 0 20px;
}

.dropdown-sad {
  display: block;
    position: absolute;
    right: 0;
    top: 45px;
    background: #FFFFFF;
    -webkit-box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.15), 0px 0px 20px rgba(0, 0, 0, 0.1);
    box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.15), 0px 0px 20px rgba(0, 0, 0, 0.1);
    border-radius: 30px;
    padding: 40px 40px 20px;
    z-index: 100;
}


@media (min-width: 767px){
  .logo {
    height: 80px !important;
    /* width: 90px !important; */
    margin-left: 35px  !important;
  }
}

@media (max-width: 768px){
  .header-bar {
    height: 62px !important;
    position:fixed !important;
    top:0 !important;
  }
}

.header-bar-wrap {
  padding: 5px;
}

/* Logo */
.logo{
  height: 60px;
  width: 60px;
  margin: 5px;
  margin-left: 0px;
  background-image: url('/image/logo.svg');
  background-size: contain;
  background-repeat: no-repeat;
  background-position: center;
}
.neo-logo{
  height: 45px;
  width: 256px;
  margin: 5px;
  margin-left: 0px;
  background-image: url('/images/neo-logo.png');
  background-size: contain;
  background-repeat: no-repeat;
  background-position: center;
}

@media (max-width: 768px){
  .logo{
    width: 45px !important;
  }  
  .neo-logo{
    width: 130px !important;
    height: 22px;
  }
}


/* Halloween */
.halloween .logo{
  background-image: url('/halloween/logo_halloween_mini.png') !important;
}

@media screen and (min-width: 768px){
  .halloween .header-bar{
    background-image: url(/halloween/ghost.png);
    background-size: 50px;
    background-repeat: no-repeat;
    background-position: top 10px right 50px;
  }
}


.bananich-x{
  background-color: #f3ebe8 !important;
}
</style>