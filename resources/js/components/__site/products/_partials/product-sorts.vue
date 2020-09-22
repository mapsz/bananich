<template>
  <div class="sort" style="margin-right: 4px;">

    <button @click="dropSorts = !dropSorts" class="filter-btn">
      <img src="/image/sort.svg" alt="Сортировка">
      <span>{{sort.caption}}</span>
    </button>

    <form  v-show="dropSorts" class="dropdown-sad sort-list" >
      <div class="dropdown-sad-arr"></div>

      <div class="mobile-only mb-2" style="border-bottom: 1px solid gray;padding: 10px;">
        <div style="display: flex;justify-content: space-between;">
          <h4 >Сортировка</h4>
          <span @click="dropSorts = false">❌</span>
        </div>
      </div>

      <label v-for='(sort_,i) in sorts' :key='i' class="filter-line">
        {{sort_.caption}} <input v-model="sort" class="checkbox" name="sort" type="radio" :value="sort_"><div class="checkbox-box"></div>
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
    sort:
      {
        name:'sortPopular',
        caption:'По популярности',
      }
      ,
    sorts:[
      {
        name:'sortPopular',
        caption:'По популярности',
      },
      {
        name:'sortCheap',
        caption:'Сначала дешевле',
      },
      {
        name:'sortExpensive',
        caption:'Сначала дороже',
      },
      {
        name:'sortDiscount',
        caption:'По величине скидки',
      },
      {
        name:'sortCcal',
        caption:'По калорийности',
      },
    ],
  }},
  methods:{    
    ...mapActions({
      'addFilter':'product/addFilter',
      'productsFetch':'product/fetchData',
    }),

    doSort(){   
      this.dropSorts = false;
      this.addFilter({sort:this.sort.name});
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