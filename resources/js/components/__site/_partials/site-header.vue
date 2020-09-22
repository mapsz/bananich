<template>
<div>
  <header class="header" style="z-index: 100;">

    <!-- navbar-sad -->
    <div class="header-nav">
        <div class="container header-nav-wrap-sad">
          <nav class="navbar-sad">
            <menu-component :menus="menus"></menu-component>
          </nav>
          <div class="phone header-phone"><a :href="'tel:'+settings.phone_number">📞{{settings.phone_number}}</a></div>
      </div>
    </div>

    <!-- Header -->
    <div class="header-bar" v-scroll="handleScroll" 
      style="position:absolute; width:100%; background-color:white;"
      :style="position > 55 ? 'height: 80px;top:0; position:fixed;' : ''"
    >
      <div class="container header-bar-wrap">

        <!-- Logo -->
        <a href="/"><img class="logo" src="/image/logo.svg" alt="logo" style="height: 65px;width: 65px;"></a>
        
        <!-- Presents -->
        <present-bar :cart="cart" :settings="presentSettings"/>
        
        <!-- Product input -->
        <product-input-search />

        <!-- User -->
        <div class="group-icon">
          <bonus-header-button />
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

  <div style="margin-top:120px;"></div>

  <!-- Mobile upper header -->
  <div class="tap-bar">
    <div class="container">
      <div class="row">

        <!-- Menu -->
        <div class="col-3">
          <div class="tap-bar-nav">
            <button class="navbar-sad-toggler" style="padding: 0px;">
              <span></span><span></span><span></span>
            </button>
            <span>Меню</span>
          </div>
        </div>

        <!-- Profile -->
        <div class="col-3">
          <div class="tap-bar-user">
            <a href="/profile">
              <button class="tap-bar-user-btn">
                <svg display="none">
                  <symbol id="tap-bar-user" viewBox="0 0 21 22">
                    <path d="M17.7289 14.2206C16.6615 13.1069 15.3911 12.2824 14.005 11.7833C15.4896 10.7164 16.4649 8.93075 16.4649 6.91167C16.4649 3.65198 13.9234 1 10.7995 1C7.67566 1 5.13418 3.65198 5.13418 6.91167C5.13418 8.93075 6.1095 10.7164 7.59409 11.7833C6.20799 12.2824 4.93757 13.1069 3.87023 14.2206C2.01934 16.152 1 18.7198 1 21.4512H2.53118C2.53118 16.6938 6.24034 12.8233 10.7995 12.8233C15.3587 12.8233 19.0679 16.6938 19.0679 21.4512H20.5991C20.5991 18.7198 19.5797 16.152 17.7289 14.2206ZM10.7995 11.2256C8.51995 11.2256 6.66535 9.2904 6.66535 6.91167C6.66535 4.53294 8.51995 2.59775 10.7995 2.59775C13.0791 2.59775 14.9337 4.53294 14.9337 6.91167C14.9337 9.2904 13.0791 11.2256 10.7995 11.2256Z"/>
                  </symbol>
                </svg>
                <svg class="tap-bar-user-icon">
                  <use xlink:href="#tap-bar-user"></use>
                </svg>
              </button>
            </a>
            <span>Профиль</span>
          </div>
        </div>

        <!-- Cart -->
        <div class="col-3">
          <div class="tap-bar-cart">
            <a href="/cart">
              <button class="tap-bar-cart-btn">
                <svg display="none">
                  <symbol id="tap-bar-cart" viewBox="0 0 28 26">
                    <path d="M0.247517 8.57174C0.446033 8.33685 0.737518 8.20144 1.0447 8.20144H3.94484L9.6404 0.427387C9.98204 -0.0392006 10.6357 -0.138667 11.1007 0.202971C11.566 0.545322 11.6659 1.20076 11.3246 1.66663L6.53693 8.20149H21.7416L16.9539 1.66663C16.6123 1.20038 16.7129 0.545322 17.1778 0.202971C17.6428 -0.139051 18.2968 -0.0385429 18.6384 0.427387L24.3341 8.20149H26.9552C27.2624 8.20149 27.5539 8.33691 27.7524 8.57179C27.9509 8.80668 28.0363 9.11691 27.9858 9.42052L25.3738 25.1251C25.2899 25.6297 24.8539 26 24.3434 26H3.65669C3.1458 26 2.7101 25.6301 2.62621 25.1251L0.0142727 9.42052C-0.036314 9.11724 0.0489998 8.80662 0.247517 8.57174ZM4.54154 23.9061H23.4583L25.722 10.2954H2.27785L4.54154 23.9061Z" />
                    <path d="M14.0002 12.7385C14.5772 12.7385 15.0449 13.2072 15.0449 13.7855V20.6606C15.0449 21.2389 14.5772 21.7076 14.0002 21.7076C13.4231 21.7076 12.9554 21.2393 12.9554 20.6606V13.7855C12.9554 13.2072 13.4231 12.7385 14.0002 12.7385Z" />
                    <path d="M8.60173 12.7385C9.17879 12.7385 9.64648 13.2072 9.64648 13.7855V20.6606C9.64648 21.2389 9.17879 21.7076 8.60173 21.7076C8.02461 21.7076 7.55692 21.2393 7.55698 20.6606V13.7855C7.55698 13.2072 8.02467 12.7385 8.60173 12.7385Z" />
                    <path d="M19.3976 12.7385C19.9747 12.7385 20.4424 13.2072 20.4424 13.7855V20.6606C20.4424 21.2389 19.9747 21.7076 19.3976 21.7076C18.8206 21.7076 18.3529 21.2393 18.3529 20.6606V13.7855C18.3529 13.2072 18.8206 12.7385 19.3976 12.7385Z" />
                  </symbol>
                </svg>
                <svg class="tap-bar-cart-icon">
                  <use xlink:href="#tap-bar-cart"></use>
                </svg>
              </button>
            </a>
            <span>Корзина</span>
            <div v-if="cart.items != undefined" class="cart-num-mobile">{{cart.pre_price}}</div>
          </div>
        </div>

        <!-- Search -->
        <div class="col-3">
          <div class="tap-bar-search">
            <button class="tap-bar-search-btn"><img src="/image/search.svg" alt="search" style="margin: auto;"></button>
            <span>Поиск</span>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    cartDrop:false,
    presentSettings:{},
    position:0,
  }},
  computed:{
    ...mapGetters({
      menus:'menu/get',
      cart:'cart/getCart',
      settings:'settings/beautyGet',
    }),    
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
      'getMenu':'menu/fetchData',
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
.cart-num-mobile {
    position: absolute;
    font-size: 12px;
    font-weight: 600;
    background: #fbe214;
    color: #000000;
    border-radius: 14px;
    padding: 2px 4px 1px;
    left: 50px;
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

@media (max-width: 768px){
  .header-bar {
    height: 62px !important;
    position:fixed !important;
    top:0 !important;
  }
}
</style>