<template>
  <div class="sort">

    <button @click="dropSorts = !dropSorts" class="filter-btn">
      <img src="/image/sort.svg" alt="Сортировка">
      <span>По популярности</span>
    </button>

    <form  v-show="dropSorts" class="dropdown-sad sort-list" >
      <div class="dropdown-sad-arr"></div>

      <div class="mobile-only mb-2" style="border-bottom: 1px solid gray;padding: 10px;">
        <div style="display: flex;justify-content: space-between;">
          <h4 >Сортировка</h4>
          <span @click="dropSorts = false">❌</span>
        </div>
      </div>

      <label class="filter-line">
        По популярности <input v-model="sort" class="checkbox" name="sort" type="radio" value="sortPopular"><div class="checkbox-box"></div>
      </label>
      <label class="filter-line">
        Сначала дешевле <input v-model="sort" class="checkbox" name="sort" type="radio" value="sortCheap"><div class="checkbox-box"></div>
      </label>
      <label class="filter-line">
        Сначала дороже <input v-model="sort" class="checkbox" name="sort" type="radio" value="sortExpensive"><div class="checkbox-box"></div>
      </label>
      <label class="filter-line">
        По величине скидки <input v-model="sort" class="checkbox" name="sort" type="radio" value="sortDiscount"><div class="checkbox-box"></div>
      </label>
      <label class="filter-line">
        По калорийности <input v-model="sort" class="checkbox" name="sort" type="radio" value="sortCcal"><div class="checkbox-box"></div>
      </label>
      <label class="filter-line">
        По категории <input v-model="sort" class="checkbox" name="sort" type="radio" value="sortCategory"><div class="checkbox-box"></div>
      </label>
      <button @click.prevent="doSort()" class="btn-yellow">Смотреть товары</button>
    </form>

  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{    
    dropSorts:false,
    sort:'sortPopular',
  }},
  methods:{    
    ...mapActions({
      'addFilter':'product/addFilter',
      'productsFetch':'product/fetchData',
    }),

    doSort(){   
      this.dropSorts = false;
      this.addFilter({sort:this.sort});
      this.productsFetch();
    }
  },

}
</script>

<style scoped>
  @media (max-width: 768px){
    .sort-list {
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
</style>