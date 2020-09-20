<template>
  <div class="scale">
    <div class="scale-list">

      <!-- achived -->
      <div v-if="!(currentPresent == false || currentPresent == 'xl')" class="scale-line achived"
        :class="
          (currentPresent == 's' ? 'size-s' : '') +
          (currentPresent == 'm' ? 'size-m' : '') +
          (currentPresent == 'l' ? 'size-l' : '') +
          (currentPresent == 'xl' ? 'size-xl' : '') +
          (currentPresent == 'done' ? 'size-xl' : '') "
      >
        <div class="scale-size">{{
            (currentPresent == 's' ? 'S' : '') +
            (currentPresent == 'm' ? 'M' : '') +
            (currentPresent == 'l' ? 'L' : '') +
            (currentPresent == 'xl' ? '' : '')   }}
        </div>     
      </div>

      <!-- Active -->
      <div 
        class="scale-line active" 
        :class="
          (currentPresent == false ? 'size-s' : '') +
          (currentPresent == 's' ? 'size-m' : '') +
          (currentPresent == 'm' ? 'size-l' : '') +
          (currentPresent == 'l' ? 'size-xl' : '') +
          (currentPresent == 'xl' ? 'size-xl' : '')        
        "
      >
        <div class="scale-size">
          {{
            (currentPresent == false ? 'S' : '') +
            (currentPresent == 's' ? 'M' : '') +
            (currentPresent == 'm' ? 'L' : '') +
            (currentPresent == 'l' ? 'XL' : '') +
            (currentPresent == 'xl' ? 'XL' : '')   
          }}
        </div>
          <div class="scale-progress">
            <!-- Left -->
            <span>
              {{
                (currentPresent == false ? toNextTarget+'р до уровня S' : '') +
                (currentPresent == 's' ? toNextTarget+'р до уровня M' : '') +
                (currentPresent == 'm' ? toNextTarget+'р до уровня L' : '') +
                (currentPresent == 'l' ? toNextTarget+'р до уровня XL' : '') +
                (currentPresent == 'xl' ? '' : '') 
              }}
            </span>
            <div class="scale-progress-line">
              <!-- Progress -->
              <div 
                class="scale-progress-position" 
                :style="'width: '+
                  (nextTarger == 'done' ? '100' : 100 / ((nextTarger - 0) / (cartValue - 0))) +
                  '%;'"
              ></div>
            </div>
          </div>
          <div class="scale-gift">
            <a href="/presents">
              <img src="/image/gift.svg" alt="gift">
            </a>
          </div>             
      </div>

      <!-- Target -->
      <div v-if="currentPresent == false" class="scale-line size-m">
        <div class="scale-size">M</div>
      </div>
      <div v-if="currentPresent == false || currentPresent == 's'" class="scale-line size-l">
        <div class="scale-size">L</div>
      </div>
      <div v-if="currentPresent == false || currentPresent == 's' || currentPresent == 'm'" class="scale-line size-xl">
        <div class="scale-size">XL</div>
      </div>


    </div>  
  </div>  
</template>

<script>
export default {
props: ['cart','settings'],
mounted(){
  // fbq('track', 'AddPaymentInfo');
},
computed:{
  cartValue:function(){
    if(this.cart.pre_price == undefined) return 0;
    return this.cart.pre_price;
  },
  currentPresent:function(){
    if(this.cartValue >= this.settings.present_xl) return 'xl';
    if(this.cartValue >= this.settings.present_l) return 'l';
    if(this.cartValue >= this.settings.present_m) return 'm';
    if(this.cartValue >= this.settings.present_s) return 's';
    return false;
  },
  nextTarger: function(){
    if(this.cartValue >= this.settings.present_xl) return 'done';
    if(this.cartValue >= this.settings.present_l) return this.settings.present_xl;
    if(this.cartValue >= this.settings.present_m) return this.settings.present_l;
    if(this.cartValue >= this.settings.present_s) return this.settings.present_m;
    return this.settings.present_s;
  },
  toNextTarget:function(){
    if(this.cartValue >= this.settings.present_xl) return 'done';
    if(this.cartValue >= this.settings.present_l) return this.settings.present_xl - this.cartValue;
    if(this.cartValue >= this.settings.present_m) return this.settings.present_l - this.cartValue;
    if(this.cartValue >= this.settings.present_s) return this.settings.present_m - this.cartValue;
    return this.settings.present_s - this.cartValue;
  }
},
}
</script>

<style scoped>
  .achived {
    border-radius: 50%;
    line-height: 28px;
    text-align: center;
    width: 28px;
    height: 28px;
    margin-right: 11px;
  }
  .size-s.achived {
    background: #FBE214;
  }
  .size-m.achived {
    background: #FFB800;
  }
  .size-l.achived {
    background: #FF7F0A;
  }
  .size-xl.achived {
    background: #FF5C00;
  }
</style>