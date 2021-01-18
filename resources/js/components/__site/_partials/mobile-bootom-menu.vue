<template>
  <div>


      <div class="row" style="max-width: 100%;">

        <!-- Menu -->
        <div class="col-3" v-click-outside="hideMenu">
          <div class="tap-bar-nav" style="position: relative;z-index: 99;">
            <button @click="menuDrop = !menuDrop" class="navbar-sad-toggler" style="padding: 0px;">
              <span></span><span></span><span></span>
            </button>
            <!-- <span>Меню</span> -->
          </div>
          <div  v-show="menuDrop" class="mobile-menu" >
            <div class="mobile-only mb-2" style="border-bottom: 1px solid gray;padding: 10px;">
              <div style="display: flex;justify-content: center;">
                <h4 >Меню</h4>
              </div>
            </div>
            <menu-component :columns="1" :menus="menus" :position="'mobile'"></menu-component>
          </div>
        </div>

        <!-- Profile -->
        <div @click="profileDrop = !profileDrop" class="col-3"  v-click-outside="hideProfile">
          <div class="tap-bar-user" style="position: relative;z-index: 99;">
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
              <!-- <span>Профиль</span> -->
          </div>

          <div  v-show="profileDrop" class="mobile-menu">
            <div class="mobile-only mb-2" style="border-bottom: 1px solid gray;padding: 10px;">
              <div style="display: flex;justify-content: center;">
                <h4 >Профиль</h4>
              </div>
            </div>
            <ul v-if="user" class="menu-navbarmenu-navbar">
              <li class="m-2"><a href="/profile" class="nav-link-sad" style="font-size:12pt">Личные данные</a> </li>
              <li class="m-2"><a href="/profile/favorites" class="nav-link-sad" style="font-size:12pt">Избранное</a> </li>
              <li class="m-2"><a href="/profile/bonus" class="nav-link-sad" style="font-size:12pt">Бонусы</a> </li>
              <li class="m-2"><a href="/profile/orders" class="nav-link-sad" style="font-size:12pt">Мои заказы</a> </li>
            </ul>
            <div v-else style="font-size: 12pt;color: black;"> 
              <a href="/register" style="font-size: 12pt;color: black; text-decoration: underline !important;">Зарегистрироваться</a> 
              или 
              <a href="/login" style="font-size: 12pt;color: black; text-decoration: underline !important;">войти</a> 
            </div>
          </div>
        </div>

        <!-- Cart -->
        <div class="col-3">
          <a href="/cart">
            <div class="tap-bar-cart">
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
              
              <!-- <span>Корзина</span> -->
              <div v-if="itemsCount > 0" class="cart-num-mobile">{{summ}}р</div>
            </div>
          </a>
        </div>

        <!-- Search -->
        <template>
          <div @click="searchShow=!searchShow" class="col-3" > 
            <div class="tap-bar-search" :style="search ? 'background-color: #fbe214;border-radius: 7px;' : ''">
              <button class="tap-bar-search-btn"><img src="/image/search.svg" alt="search" style="margin: auto;"></button>
              <!-- <span>Поиск</span> -->
            </div>
          </div>        
          <div v-show="searchShow" class="search-modal">
            <product-input-search />
          </div>
        </template>

      </div>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{  
      menuDrop:false,
      cartDrop:false,
      profileDrop:false,    
      searchShow:false,
  }},
  watch: {
    menuDrop: function(){
      if(this.menuDrop) this.searchShow=false;
    },
    profileDrop: function(){
      if(this.profileDrop) this.searchShow=false;
    },
  },
  computed:{
    ...mapGetters({
      user:'user/get',
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
    },
    itemsCount:function(){
      return this.cart.items != undefined ? this.cart.items.length : 0
    },
    summ(){
      if(this.cart == undefined) return false;

      if(this.cart.type != undefined && this.cart.type == 2){
        if(this.cart.pre_price_x == undefined) return false;
        return this.cart.pre_price_x;
      }else{
        if(this.cart.pre_price == undefined) return false;
        return this.cart.pre_price;
      }
    }, 
  },
  methods:{    
    hideMenu(){this.menuDrop =false;},
    hideProfile(){this.profileDrop =false;},
    hideSearch(){this.searchShow =false;},
  },
}
</script>

<style scoped>

.page-x .cart-num-mobile{
  background: #8ac2a7!important;
}

.search-modal{
  position: absolute;
  top: -70px;
  background-color: white;
  width: 100%;
  padding: 10px;
}

.mobile-menu{  
  position: fixed !important;
  background-color: white;
  padding-bottom: 20px;
  right: 0;
  bottom: 44px;
  width: 250px;
  overflow: scroll;
  box-shadow: none;
  border-radius: 0px;
  box-shadow: 0 0 15px rgb(0 0 0);
  border: 1px solid #b6b6b6;
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

.tap-bar-cart-icon, .tap-bar-user-icon, .tap-bar-search-btn img, .navbar-sad-toggler {
  width: 30px !important;
  height: 30px !important;
}

.navbar-sad-toggler span:nth-child(2){
  width: 30px !important;
}

.navbar-sad-toggler span{
  margin-bottom: 5px !important;
  height: 3px !important;
}

.navbar-sad-toggler span:last-child{
  margin-bottom: 0px !important;
}


</style>