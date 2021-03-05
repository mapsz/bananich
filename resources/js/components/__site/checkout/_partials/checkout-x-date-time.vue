<template>
<div>
  asd
</div>  
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    
  }},
  computed:{
    ...mapGetters({
      'availableDays': 'orderLimits/getAvailableDays',
    }),  
  },
  mounted(){
    this.fetch();
  },
  methods:{
    ...mapActions({
      'fetch'         :'orderLimits/fetchAvailableDays',
    }),
  } 
}
</script>

<style>

</style>