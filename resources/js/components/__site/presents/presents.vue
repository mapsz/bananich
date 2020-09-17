<template>
  <div>
    <site-header/>


    <main>
      <div class="container">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item active">Подарки</li>
          </ol>
        </nav>
        <div class="row content-page">
          <div class="col-lg-12">
            <div class="title-wrap title-page">
              <h2 class="title-h2">Подарки</h2>
            </div>
            <div class="row row-min content pb-2">

              <!-- products -->

              <div v-for='(product,i) in products' :key='i' class="col-lg-3 col-md-4 col-6">
                <div class="gifts-item" :class="presentSettings['present_'+product.type] > cart.final_summ ? 'hide' : ''">
                  <div class="gifts-item-box">
                  <div class="gifts-item-img" :style="'background-image: url('+product.product.images[0]+');'"></div>
                  <div class="gifts-item-text">
                    <div class="gifts-item-title">{{product.product.name}}</div>
                  </div>
                </div>
                  <button 
                    @click="addPresentToCart(product.product_id)"
                    class="gifts-item-button"
                    :class="                    
                      (cart.presents.findIndex(x => x.product_id == product.product_id) > -1 ? 'active ' : '') +
                      ('color-'+product.type)
                    "
                    :disabled="presentSettings['present_'+product.type] > cart.final_summ ? 'disabled' : false"
                  >
                    {{
                      cart.presents.findIndex(x => x.product_id == product.product_id) > -1 ? 
                      ('Подарок в корзине') :
                      (presentSettings['present_'+product.type] > cart.final_summ ? 'При заказе от ' + presentSettings['present_'+product.type] : 'Получить')
                    }}
                  </button>

                  <!-- <button class="gifts-item-button color-m" disabled="disabled">При заказе от 1000р</button> -->
                  
                  <!-- <button class="gifts-item-button color-s active">Подарок в корзине</button> -->
                </div>
              </div>

            </div>
            <div class="row justify-content-center mb-5">
              <div class="col-md-6"><a href="/catalogue" class="btn-yellow btn-thick">Докупить</a></div>
            </div>
          </div>
        </div>
      </div>
    </main>
    
    <site-footer/>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  computed:{
    ...mapGetters({
      cart:'cart/getCart',
      presentSettings:'presents/getSettings',
      products:'presents/getProducts',
    }),
  },  
  mounted(){
    this.fetchCart();
    this.fetchPresents();    
  },
  methods:{
    ...mapActions({
      'fetchCart':'cart/fetch',
      'fetchPresents':'presents/fetch',
    }),
    async addPresentToCart(id){
      let r = await ax.fetch('/present/cart',{id},'put');

      this.getCart();
    }
  },
}
</script>

<style>

</style>