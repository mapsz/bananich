<template>
  <div class="scale">
    <div class="scale-list">

      <!-- S -->
      <div class="scale-line size-s" 
        :class="
        (cart.final_summ < settings.present_s ? 'active' : '') + 
        (cart.final_summ >= settings.present_s ? 'achived' : '')"
      >
        <div class="scale-size">S</div>
        <template v-if="cart.final_summ < settings.present_s">
          <div class="scale-progress">
            <span>{{settings.present_s - cart.final_summ}}р до уровня S</span>
            <div class="scale-progress-line">
              <div class="scale-progress-position" :style="'width: '+100 /((settings.present_s - 0) / (cart.final_summ - 0)) +'%;'"></div>
            </div>
          </div>
          <div class="scale-gift">
            <a href="/presents">
              <img src="/image/gift.svg" alt="gift">
            </a>
          </div>  
        </template>              
      </div>

      <!-- M -->
      <div class="scale-line size-m"
        :class="
        (cart.final_summ >= settings.present_s && cart.final_summ < settings.present_m ? 'active' : '') + 
        (cart.final_summ >= settings.present_m ? 'achived' : '')"    
      >
        <div class="scale-size">M</div>
        <template v-if="cart.final_summ >= settings.present_s && cart.final_summ < settings.present_m">
          <div class="scale-progress">
            <span>{{settings.present_m - cart.final_summ}}р до уровня M</span>
            <div class="scale-progress-line">
              <div class="scale-progress-position" :style="'width: '+100 /((settings.present_m - settings.present_s) / (cart.final_summ - settings.present_s)) +'%;'"></div>
            </div>
          </div>
          <div class="scale-gift">
            <a href="/presents">
              <img src="image/gift.svg" alt="gift">
            </a>
          </div>   
        </template>         
      </div>

      <!-- L -->
      <div class="scale-line size-l "
        :class="
        (cart.final_summ >= settings.present_m && cart.final_summ < settings.present_l ? 'active' : '') + 
        (cart.final_summ >= settings.present_l ? 'achived' : '')"     
      >
        <div class="scale-size">L</div>
        <template v-if="cart.final_summ >= settings.present_m && cart.final_summ < settings.present_l">
          <div class="scale-progress">
            <span>{{settings.present_l - cart.final_summ}}р до уровня L</span>
            <div class="scale-progress-line">
              <div class="scale-progress-position" :style="'width: '+100 /((settings.present_l - settings.present_m) / (cart.final_summ - settings.present_m)) +'%;'"></div>
            </div>
          </div>
          <div class="scale-gift">
            <a href="/presents">
              <img src="image/gift.svg" alt="gift">
            </a>
          </div>  
        </template>              
      </div>

      <!-- XL -->
      <div class="scale-line size-xl"
        :class="
        (cart.final_summ >= settings.present_l  ? 'active' : '')"      
      >
        <div class="scale-size">XL</div>
        <template v-if="cart.final_summ >= settings.present_l">
          <div class="scale-progress">
            <span v-if="cart.final_summ < settings.present_xl">{{settings.present_xl - cart.final_summ}}р до уровня XL</span>
            <div class="scale-progress-line">
              <div v-if="cart.final_summ < settings.present_xl" class="scale-progress-position" :style="'width: '+100 /((settings.present_xl - settings.present_l) / (cart.final_summ - settings.present_l)) +'%;'"></div>
              <div v-else class="scale-progress-position" :style="'width: 100%;'"></div>
            </div>
          </div>
          <div class="scale-gift">
            <a href="/presents">
              <img src="image/gift.svg" alt="gift">
            </a>
          </div>  
        </template>   
      </div>

    </div>
  </div>  
</template>

<script>
export default {
props: ['cart','settings'],
}
</script>

<style>

</style>