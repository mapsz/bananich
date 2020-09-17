<template>
  <div v-if="currentBonus > 0" class="d-flex">
    <div class="cart-bonuse-ico">
      <img src="image/icons/bonus.svg" alt="Bonuse">
    </div>
    <div class="cart-bonuse-text">
      У вас {{currentBonus}} активных бонусов!
    </div>
  </div>  
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  computed:{
    ...mapGetters({bonuses: 'bonus/get',}),
    currentBonus: function(){
      return (this.bonuses != undefined && this.bonuses[0] != undefined) ? this.bonuses[0].left : 0;
    },
  },

}
</script>

<style>

</style>