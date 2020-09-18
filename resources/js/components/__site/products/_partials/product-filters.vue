<template>

  <div class="filt">
    <!-- Button -->
    <div>
      <button @click="dropFilter = !dropFilter" class="filter-btn">
        <img src="/image/filter.svg" alt="Фильтр">
        <span>Фильтры</span>      
      </button>
      <div v-if="currentFiltersCount > 0" class="cart-num">{{currentFiltersCount}}</div>
    </div>

    <form class="dropdown-sad filter-list" style="position: absolute;" :style="dropFilter ? '' : 'display: none;'">

      <div class="dropdown-sad-arr"></div>

      <!-- Mobile title / Close button -->
      <div class="mobile-only mb-2" style="border-bottom: 1px solid gray;padding: 10px;">
        <div style="display: flex;justify-content: space-between;">
          <h4 >Фильтр</h4>
          <span @click="dropFilter = false">❌</span>
        </div>
      </div>
      
      <!-- Categories -->
      <div class="dropdown-sad-item filter-dd" :class="dropCategory ? 'active' : ''">
        <a @click="dropCategory=!dropCategory" class="dropdown-sad-btn">Раздел</a>
        <ul class="dropdown-sad-list">
          <li><a 
              href="#" 
              v-on:click.prevent="filters.categories = [0]"
              :class="(filters.categories != undefined && filters.categories[0] == 0) ? 'font-weight-bold' : ''"
            >
              Все
          </a></li>
          <li v-for='(category,i) in categories' :key='i'><a 
              href="#" 
              v-on:click.prevent="addCategory(category.id)"
              :class="(filters.categories != undefined && (filters.categories.findIndex(x => x == category.id) > -1)) ? 'font-weight-bold' : ''"
            >
              {{category.name}}
          </a></li>
        </ul>
      </div>

      <div class="dropdown-sad-item filter-dd filter-cell" >
        <a @click="dropPrice=!dropPrice" href="#!" class="dropdown-sad-btn">Цена</a>
          <div v-if="dropPrice" class="cell-list">
            <div class="cell-list-wrap">
              <label class="cell-list-input">От <input v-model="filters.price_from" placeholder="0" type="text"> р</label>
              <label class="cell-list-input">До <input v-model="filters.price_to" placeholder="1000" type="text"> р</label>
            </div>
          </div>
      </div>

      <label class="filter-line">
        <div class="filter-line-left">
          Товары за бонусы
        </div>
        <div class="filter-line-right">
          <input v-model="filters.bonus" class="checkbox" name="sort" type="checkbox">
          <div class="checkbox-box"></div>
        </div>
      </label>
      
      <div class="dropdown-sad-item filter-dd filter-cell" :class="dropCcal ? 'active' : ''">
        <a @click="dropCcal=!dropCcal" href="#!" class="dropdown-sad-btn">Калорийность</a>
          <div v-if="dropCcal" class="cell-list">
            <div class="cell-list-text">На 100гр продукта</div>
            <div class="cell-list-wrap">
              <label class="cell-list-input">От <input v-model="filters.cal_from" placeholder="0" type="text"> ккал</label>
              <label class="cell-list-input">От <input v-model="filters.cal_to" placeholder="1000" type="text"> ккал</label>
            </div>
          </div>
      </div>

      <div class="dropdown-sad-item filter-dd filter-cell filter-cell-bju" :class="dropBZU ? 'active' : ''">
        <a @click="dropBZU=!dropBZU" href="#!" class="dropdown-sad-btn">Белки / Жиры / Углеводы</a>
          <div v-if="dropBZU" class="cell-list">
            <div class="cell-list-wrap">
              <div class="cell-list-title">Белки</div>
              <label class="cell-list-input">От <input v-model="filters.prot_from" placeholder="0" type="text"></label>
              <label class="cell-list-input">До <input v-model="filters.prot_to" placeholder="1000" type="text"></label>
            </div>
            <div class="cell-list-wrap">
              <div class="cell-list-title">Жиры</div>
              <label class="cell-list-input">От <input v-model="filters.fat_from" placeholder="0" type="text"></label>
              <label class="cell-list-input">До <input v-model="filters.fat_to" placeholder="1000" type="text"></label>
            </div>
            <div class="cell-list-wrap">
              <div class="cell-list-title">Углеводы</div>
              <label class="cell-list-input">От <input v-model="filters.carb_from" placeholder="0" type="text"></label>
              <label class="cell-list-input">До <input v-model="filters.carb_to" placeholder="1000" type="text"></label>
            </div>
          </div>
      </div>

      <!-- no_lactose -->
      <label class="filter-line">
        <div class="filter-line-left">
          Без лактозы
        </div>
        <div class="filter-line-right">
          <input v-model="filters.no_lactose" class="checkbox" name="sort" type="checkbox">
          <div class="checkbox-box"></div>
        </div>
      </label>
      <!-- no_egg -->
      <label class="filter-line">
        <div class="filter-line-left">
          Без яиц
        </div>
        <div class="filter-line-right">
          <input v-model="filters.no_egg" class="checkbox" name="sort" type="checkbox">
          <div class="checkbox-box"></div>
        </div>
      </label>
      <!-- no_sugar -->
      <label class="filter-line">
        <div class="filter-line-left">
          Без сахара
        </div>
        <div class="filter-line-right">
          <input v-model="filters.no_sugar" class="checkbox" name="sort" type="checkbox">
          <div class="checkbox-box"></div>
        </div>
      </label>
      <!-- no_gluten -->
      <label class="filter-line">
        <div class="filter-line-left">
          Без глютена
        </div>
        <div class="filter-line-right">
          <input v-model="filters.no_gluten" class="checkbox" name="sort" type="checkbox">
          <div class="checkbox-box"></div>
        </div>
      </label>
      <!-- no_heat -->
      <label class="filter-line">
        <div class="filter-line-left">
          Без термической обработки
        </div>
        <div class="filter-line-right">
          <input v-model="filters.no_heat" class="checkbox" name="sort" type="checkbox">
          <div class="checkbox-box"></div>
        </div>
      </label>
      <!-- low_glycemic -->
      <label class="filter-line">
        <div class="filter-line-left">
          Низкий гликемический индекс
        </div>
        <div class="filter-line-right">
          <input v-model="filters.low_glycemic" class="checkbox" name="sort" type="checkbox">
          <div class="checkbox-box"></div>
        </div>
      </label>
      <!-- eco -->
      <label class="filter-line">
        <div class="filter-line-left">
          Эко сертификат
        </div>
        <div class="filter-line-right">
          <input v-model="filters.eco" class="checkbox" name="sort" type="checkbox">
          <div class="checkbox-box"></div>
        </div>
      </label>


      <button @click.prevent="addFilters()" class="btn-yellow">Смотреть товары</button>
    </form>

  </div>  



</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
data(){return{  
  dropFilter:false,
  dropCategory:false,
  dropPrice:false,
  dropCcal:false,
  dropBZU:false,
  filters:{},
}},
computed:{  
  ...mapGetters({categories:'category/get','getCurrentFilters':'product/getFilters',}),
  currentFiltersCount: function(){
    let count = 0;
    for (const [key, value] of Object.entries(this.getCurrentFilters)) {
      if(value) count++;
    }
    return count;
  },
  isMobile:function(){return window.screen.width <= 768;},

}, 
methods:{
  ...mapActions({
    'addFilter':'product/addFilter',
    'productsFetch':'product/fetchData',
  }),
  async addFilters(){
    // Add filters
    await $.each( this.filters, async ( k, v ) => {
      var obj = {};
      obj[k] = v;
      await this.addFilter(obj);
    });    

    //Get data
    this.dropFilter = false;
    this.productsFetch();
  },
  async addCategory(id){
    if(this.filters.categories == undefined) this.filters.categories = [0];

    //Remove category
    let categoryIndex = this.filters.categories.findIndex(x => x == id);
    if(categoryIndex > -1){
      this.filters.categories.splice(categoryIndex,1);
      //Trigger
      this.filters = JSON.parse(JSON.stringify(this.filters));
      return;
    } 

    //Remove zero
    let zeroIndex = this.filters.categories.findIndex(x => x == 0);
    if(id > 0 && zeroIndex > -1) this.filters.categories.splice(zeroIndex,1);

    //Add category
    this.filters.categories.push(id);

    //Trigger
    this.filters = JSON.parse(JSON.stringify(this.filters));
  }
},
}
</script>

<style scoped>
  @media (max-width: 768px){
    .filter-list {
      position: fixed !important;
      top: 0px;
      width: 300px;
      height: 100%;
      overflow:scroll;
    }
    .mobile-only {
      display:inherit !important;
    }
  }

  @media (min-width: 769px){
    .mobile-only {
      display:none !important;
    }
  }

  .cart-num { 
    right: -25px !important;
    left: inherit !important;
  }
</style>