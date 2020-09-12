<template>
<div>
  <site-header></site-header>

  <main>
    <div class="container">
      <!-- Breadcrumbs -->
      <breadcrumbs />
      <div class="row content-page">
        <!-- Navbar -->
        <div class="col-lg-4">            
          <profile-navbar></profile-navbar>
        </div>

        <!-- Product list -->
        <div class="col-lg-8">          
          <h1>Избранные</h1>
          <div class="row">
            <!-- Карточка товара -->
            <div v-for='(product,i) in products' :key='i' class="col-6 col-lg-4 ">
              <product-gallery-card :product="product" />
            </div>

            <span v-if="products.length < 1">У вас нету избранных товаров</span>

          </div>  
        </div>


      </div>
    </div>

    

  </main>

  <site-footer></site-footer>
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    products:[],
  }},
  computed:{
    ...mapGetters({favorites:'favorite/get',}), 
  },
  async mounted(){
    await this.fetch();
    this.getProducts();
  },
  methods:{
    ...mapActions({'fetch':'favorite/fetchData',}),
    async getProducts(){
      let ids = [];
      $.each(this.favorites , ( k, v ) => {
        ids.push(v.product_id);
      });
      this.products = await ax.fetch('http://bananich.loc/juge?&model=product',{ids:ids});
    }
  },
}
</script>

<style>

</style>