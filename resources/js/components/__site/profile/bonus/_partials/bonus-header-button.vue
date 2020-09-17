<template>  
  <div class="bonuses">
    <a href="/profile/bonus">
      <div v-if="currentBonus > 0" class="bonuses-num">{{currentBonus}}</div>
      <button class="bonuses-btn">Б</button>
    </a>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  computed:{
    ...mapGetters({
        bonuses: 'bonus/get',
        user: 'user/get',        
      }),
    currentBonus: function(){
      return (this.bonuses != undefined && this.bonuses[0] != undefined) ? this.bonuses[0].left : 0;
    },
  },
  watch: {
    user: {
      handler: function (val, oldVal) {
        if(this.user) this.fetch();
      },
      deep: true
    }
  },
  methods:{    
    ...mapActions({'fetch':'bonus/fetchData',}),
  },
}
</script>

<style>

</style>