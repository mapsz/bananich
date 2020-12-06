<template>
  <div class="row">
    <!-- Delivery Time -->
    <div class="col-lg-6">
      <div class="checkout-title">Дата доставки</div>
      <checkout-input v-model="day" :name="'deliveryDate'" :type="'radio'" 
        :list="days" 
      />
    </div>
    <!-- Delivery Time -->
    <div v-if="day" class="col-lg-6">
      <div class="checkout-title">Время доставки</div>
      <checkout-input v-model="time" :name="'deliveryTime'" :type="'radio'" 
        :list="times" 
      />
    </div>
  </div>  
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {  
  data(){return{
    day:false,
    time:false,
  }},
  computed:{
    ...mapGetters({
      'availableDays': 'orderLimits/getAvailableDays',
    }),   
    days:function(){
      if(this.availableDays[0] == undefined) return false;

      let days=[];
      $.each(this.availableDays , ( k, v ) => {
        if(v.slots < 1) return;
        days.push(
          {
            // {from:'01:00:00',to:'12:00:00'}
            'value':v.date,
            'caption':moment(v.date).locale('ru').format('D MMMM')
        });
      });
      return days;
    },
    times:function(){
      if(this.availableDays[0] == undefined) return false;
      if(!this.day) return false;

      let day = this.availableDays.find(x => x.date == this.day);
      if(!day) return false;
      
      let times =[];
      $.each(day.times , ( k, v ) => {
        if(v.slots < 1) return;
        times.push(
          {
            'value':v.time,
            'caption':'с '+ v.time.from + ' до '+v.time.to,
        });
      });

      return times;

    }
  },
  // watch: {
  //   day: function(){
  //     //
  //   },
  // },
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

<style scoped>
.form-group{
  margin-bottom: 0px !important;
}
</style>