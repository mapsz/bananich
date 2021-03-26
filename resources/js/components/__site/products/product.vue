<template>
<juge-main>

  <main>
    <div class="container">
      <!-- Breadcrumbs -->
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Каталог</a></li>
          <li v-if="parentCategory.id > 0" class="breadcrumb-item"><a :href="'/category/'+parentCategory.id">{{parentCategory.name}}</a></li>
          <li v-if="currentCategory.id > 0" class="breadcrumb-item"><a :href="'/category/'+currentCategory.id">{{currentCategory.name}}</a></li>
          <li class="breadcrumb-item active">{{product.name}}</li>
        </ol>
      </nav>

      <div class="row product" style="margin-bottom: 40px;">
        <!-- Image -->
        <div class="col-md-6">
          <img    
            :src="product.productImage" 
            style="    
              border-radius: 20px;
              width: 100%;
              height: auto;
            "
          >
        </div>

        <div v-show="product.name != undefined" class="col-md-6">
          <div class="product-info">

            <!-- Name -->
            <h1 class="title-page my-4">
              {{
                product.name + 
                (product.unit_view ? ', '+product.unit_view:'')
              }}
            </h1>
            <!-- Icons -->
            <product-noty-icons :product="product" />            

            <!-- Price Cart Favorites -->
            <div class="row"> 
              
              <div class="col-md-12 order-1 order-md-2">
                <div class="d-flex justify-content-between">

                  <!-- Price -->
                  <div class="d-flex align-items-center">      
                    <template v-if="isX">
                      <!-- With Discount -->
                      <span v-if="product.final_price_x != product.final_price" class="product-price">
                        <!-- Regular price -->
                        <span style="color: black;">{{Number(product.final_price_x)}}р</span> 
                        <!-- Discount price -->
                        <span class="product-old-price" style="color: #8ac2a7;">-{{Number(product.final_price)}}р</span>                        
                      </span>
                      <!-- No Discount -->
                      <span v-else class="product-price">{{Number(product.final_price_x)}}р</span>
                    </template>              
                    <template v-else>
                      <!-- With Discount -->
                      <span v-if="product.discount" class="product-price">
                        <!-- Regular price -->
                        <span style="color: rgb(255, 92, 0);">{{Number(product.discount.discount_price)}}р</span> 
                        <!-- Discount price -->
                        <span class="product-old-price">-{{Number(product.price)}}р</span>                        
                      </span>
                      <!-- No Discount -->
                      <span v-else class="product-price">{{Number(product.final_price)}}р</span>
                    </template>
                  </div>

                  <!-- To Cart -->
                  <product-add-to-cart class="to-cart-block" :product='product'/>

                  <!-- Left -->
                  <span v-if="this.product.available_unit <= 5 && this.product.always_publish == undefined">
                    {{this.product.available_unit}} ед. на складе
                  </span>
    
                  <!-- Favorites -->
                  <button >
                    <favorite-button :product-id="product.id"/>
                  </button>

                </div>                  
                <!-- Discount annonce -->  
                <div v-if="!isX && product.discount && product.discount.quantity >= 1" style="
                  font-size: 9pt;
                  font-style: italic;
                  color: rgb(255, 92, 0);
                ">
                  *Скидка на {{product.discount.quantity == 1 ? 'первую' : 'первыe'}} <b style="color: rgb(255, 92, 0)">{{product.discount.quantity}}</b> ед.
                </div>
              </div>
            </div> 

            <!-- Charts -->
            <div class="row"> 
              <product-charts />
            </div>



            <!-- More info -->
            <div class="product-text mt-5">
              <!-- Description -->
              <template v-if="product.description">
                <h2 @click="egg++" class="product-title">Описание</h2>
                <span v-if="egg > 4 && gotEgg" v-html="gotEgg" class="egg"></span>
                <span v-else class="mb-3" v-html="product.description"></span>
              </template>
              <template v-if="product.composition">
                <h2 class="product-title">Состав:</h2>
                <span class="mb-3" v-html="product.composition"></span>
              </template>
              <template v-if="product.сountry">
                <h2 class="product-title">Страна производитель:</h2>
                <p class="mb-3">{{product.сountry}}</p>
              </template>
              <template v-if="product.benefit">              
                <h2 class="product-title">Польза:</h2>
                <span class="mb-3" v-html="product.benefit"></span>
              </template>
            </div>


            <!-- To Cart -->
            <div v-if="isMobile" class="d-flex justify-content-center mt-4">
              <product-add-to-cart class="to-cart-block" :product='product'/>
            </div>

          </div>
        </div>
      </div>
    </div>
  </main>
  
</juge-main>
</template>

<script>


    
// window.myChart = new Chart(ctx);

import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    isX:isX,
    halloween:halloween,
    id:this.$route.params.id,
    egg:0,    
  }},
  computed:{
    isMobile:function(){return window.screen.width <= 768;},
    ...mapGetters(
      {
        categories:'category/getAll',
        product:'product/getOne',
        cart:'cart/getCart'      
      }
    ), 
    currentCategory:function(){
      if (this.$route.params.catId == undefined) return false;
      if (this.categories[0] == undefined) return false;
      return this.categories.find(x => x.id == this.$route.params.catId);
    },
    parentCategory:function(){
      if (this.$route.params.parent_cat_id == undefined) return {'id':0,'name':''};
      if (this.categories[0] == undefined) return {'id':0,'name':''};
      return this.categories.find(x => x.id == this.$route.params.parent_cat_id);
    },
    //egs
    gotEgg:function(){
      if(this.product.name.includes('Гранат')) return this.granatEgg;
      return false;
    },
    granatEgg:function(){
      return "<p><a href='https://www.instagram.com/vorontsovada_rosso'>Darya Vorontsova</a></p><p><b>&laquo;Гранат&raquo;</b></p><p><br></p><p>Сквозь меня прорастает волшебный гранат,</p><p>Ветвь с шипами уж видно сквозь кожу.</p><p>Я была у жреца, то был средний мой брат,</p><p>Он ответом помочь мне не может.</p><p><br></p><p>И к провидцу я в дом поспешила тогда,</p><p>В дом второго и младшего</p><p>брата,</p><p>Говорил он: &laquo;в грядущем лишь душная мгла&nbsp;</p><p>И кровавые ветви граната&raquo;.</p><p><br></p><p>Я у травниц - сестер побывала своих.</p><p>Все отвары, увы, бесполезны.&nbsp;</p><p>На плечах по утрам уж поют соловьи..!</p><p>Нет лекарства от странной болезни. &nbsp;</p><p><br></p><p>Стала кожа менять на древесный свой цвет,</p><p>Мои пальцы корой обрастают.</p><p>Ни молитв, ни пророчества.. Где же ответ?</p><p>Для чего его Боги скрывают?&nbsp;</p><p><br></p><p>Я однажды пошла в жаркий день за водой.</p><p>Облака над дорогою плыли.</p><p>На ногах мои корни покров земляной</p><p>Задевали и борозды рыли.</p><p><br></p><p>Всё сложнее идти, оперлась на бедро..</p><p>Корни с силой вдруг в землю вцепились!&nbsp;</p><p>И упало на землю пустое ведро.</p><p>Корни в недра земли устремились.</p><p><br></p><p>Засветились алеющим светом глаза,</p><p>Покраснело вечернее солнце.</p><p>Еще миг и последняя в жизни слеза</p><p>О мой ствол навсегда разобьется.&nbsp;</p><p><br></p><p>По дороге идет мой мужающий брат.</p><p>И ведро мое он поднимает.</p><p>Еще многие годы он и средний мой брат,</p><p>И все сестры меня поливают.&nbsp;</p><p><br></p><p>Много лун над растущею кроной взошло,</p><p>Ее мудрость способна познать я.&nbsp;</p><p>Время жизни сестер моих тихо прошло,</p><p>Вскоре к ним прилегли мои братья.</p><p><br></p><p>Душным днем над листвою зарделся цветок -</p><p>Яркий первенец, весточка плода.</p><p>Ветер, дождь, солнца луч его пламенем жёг -&nbsp;</p><p>Он прекрасен в любую погоду.</p><p><br></p><p>Рос цветок за цветком, наливались плоды,</p><p>И, однажды, в день года грядущего</p><p>В нашу местность бродяга какой - то прибыл,</p><p>В капюшоне на брови опущенном.</p><p><br></p><p>Лишь под сенью моей скинул он капюшон,</p><p>Молодое лицо открывая.</p><p>В свои мысли глубОко он был погружен,</p><p>Отрывая часть хлебного края.</p><p><br></p><p>И задумчиво, долго его он жевал.</p><p>И смотрел на вечернее небо.</p><p>То ли пел, то ли что - то под нос бормотал.</p><p>Отдал птицам остатки от хлеба.</p><p><br></p><p>Я спустила к нему самый спелый гранат,</p><p>Будто самое солнце вложила!</p><p>Он раскрыл его - зёрен алеющий град&nbsp;</p><p>Покатился всем соком по жилам!&nbsp;</p><p><br></p><p>И зарделись глаза, и раскрылись уста,</p><p>И горят зачарованным светом!</p><p>Его палец коснулся большого шипа.</p><p>Его кровь я впитала с обетом -</p><p><br></p><p>Обещал он навек мою тайну хранить,</p><p>Обладать стал он знанием ясным.&nbsp;</p><p>Обещал свою мудрость и силу растить,</p><p>Сделать мир и добрей, и прекрасней.</p><p><br></p><p>Заходила луна и вновь скоро взошла,</p><p>Не видны в тучах крупные звезды.</p><p>Мимо девушка пыльной дорогою шла,</p><p>Заблудилась, закапали слёзы.&nbsp;</p><p><br></p><p>Я и ей протянула свой лучший гранат.</p><p>Ее пальчики плод разломили.</p><p>Подарила гроза ей свой первый раскат,</p><p>Светом молний ее озарила.</p><p><br></p><p>И зарделись глаза, и раскрылись уста,</p><p>И горят зачарованным светом!&nbsp;</p><p>Ее палец коснулся большого шипа.</p><p>Ее кровь я впитала с обетом -</p><p><br></p><p>Обещала она мою тайну хранить,</p><p>Обрела она дар врачеванья.</p><p>Обещала и тело, и душу лечить -&nbsp;</p><p>Раны мира и боль мирозданья.</p><p>&nbsp;</p><p>И под сенью моей побывали с тех пор</p><p>Архитектор, певец и художник,&nbsp;</p><p>Композитор, артистка, поэт, режиссер,&nbsp;</p><p>И швея, и танцор, и сапожник..</p><p><br></p><p>Их не счесть, но я каждое помню лицо.</p><p>Обещания выполнил каждый.&nbsp;</p><p>Но наш мир все ж далек от тех сказочных снов,</p><p>Что я видела в детстве однажды.</p><p><br></p><p>И в одну из красивейших душных ночей</p><p>По дороге, на тонких ногах,</p><p>Шла Она с жутким взглядом немых палачей,</p><p>С топором неприметным в руках.</p><p><br></p><p>Она молча сорвет дозревающий плод&nbsp;</p><p>И раздавит в холодных ладонях,</p><p>И на губы, все в трещинах, соком польет.</p><p>Сок в иссушенном горле утонет.</p><p><br></p><p>Черной мглой застелило большие глаза.</p><p>Зло Богов в ее суть поселилось.</p><p>Звёзды все, и небесная вся бирюза,</p><p>И луна в острие отразились.</p><p><br></p><p>И хватила Она о мой ствол топором!&nbsp;</p><p>Из ствола захлестал на дорогу</p><p>Человеческой крови горячий поток -</p><p>Жертва новому ложному Богу.</p><p><br></p><p>И Она задыхалась. Весь внутренний смрад&nbsp;</p><p>Залепил ее ноздри и уши.</p><p>Небо дрогнуло громом, посыпался град,</p><p>Стёр он в пыль ее черную душу.</p><p><br></p><p>На дорогу наутро сбежался народ,</p><p>Посмотреть все на кровь&nbsp;</p><p>И на град захотели.</p><p>И увидели люди: кровавый потоп</p><p>И мое обнаженное</p><p>Мертвое тело.</p>";
    },
  }, 
  async mounted(){
    await this.fetchProduct(this.id);    
    await this.getCart();
    await this.fetchCategories();

  },
  methods:{
    ...mapActions({
      'fetchProduct':'product/fetchOne',
      'getCart':'cart/fetch',
      'editItem':'cart/editItem',
      'fetchCategories':'category/fetch',
    }),    
    toCart(id,count = 1){
      this.editItem({id,count});
    },
    getItem(id){
      if(this.cart.items == undefined) return false;
      return this.cart.items.find(x => x.product_id == id);
    }
  }
}
</script>

<style scoped>
  .catalog-item-icon img{
    height:30px;
    margin-right: 5px;
  }
</style>

<style >
  .to-cart-block .to-cart-big{
    display:block !important;
  }
  .to-cart-block .to-cart{
    display:none !important;
  }
  .egg p{
    margin:0px;
  }
</style>