<template>
<div>
  <div class="row">
    <!-- Delivery Date -->
    <div class="col-lg-6">
      <div class="checkout-title">Дата доставки</div>
      <template v-if="polygons">
        <checkout-input v-model="day" :name="'deliveryDate'" :type="'radio'" :list="days" />
      </template>
      <template v-else>
        Укажите адрес!
      </template>      
    </div>
    <!-- Delivery Time -->
    <div v-if="day && polygons" class="col-lg-6">
      <div class="checkout-title">Время доставки</div>
      <checkout-input v-model="time" :name="'deliveryTime'" :type="'radio'" 
        :list="times" 
      />
    </div>        
  </div>
</div>  
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {  
  props: ['polygons'],
  data(){return{
    day:false,
    time:false,    
  }},
  computed:{
    ...mapGetters({
      'availableDays': 'orderLimits/getAvailableDays',
      'settings':   'settings/beautyGet',
    }),
    days:function(){
      if(this.availableDays[0] == undefined) return false;

      let days=[];
      $.each(this.availableDays , ( k, v ) => {
        if(v.slots < 1) return;

        // Price
        let min = v.times[0].price;
        let max = v.times[0].price;
        v.times.forEach(time => {
          if(min > time.price) min = time.price;
          if(max < time.price) max = time.price;
        });

        let captionPrice = min == max ? currencySymbol+min :'от '+currencySymbol+min;
        
        //Style
        let style = "";
        if(this.defaultPrice > 0){
          if(this.defaultPrice > min){
            style = "color: #8ac2a7;font-weight: 600;"
          }
        }        

        days.push(
          {
            'value':v.date,
            'caption':(
              moment(v.date).locale('ru').format('D MMMM') + " " +
              "("+captionPrice+")"
            ),
            'style':style,
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

        //Style
        let style = "";
        if(this.defaultPrice > 0){
          if(this.defaultPrice > v.price){
            style = "color: #8ac2a7;font-weight: 600;"
          }
        }   

        times.push(
          {
            'value':v.time,
            'caption':(
              'с '+ v.time.from + ' до '+v.time.to +
              ' ('+currencySymbol+v.price+')'
            ),
            'style':style,
        });
      });

      return times;

    },
    defaultPrice:function(){
      if(this.settings == undefined && this.settings.x_order_price == undefined) return false;
      return this.settings.x_order_price;
    }
  },
  watch:{
    polygons: function (val, oldVal) {
      if(this.polygons !== null){
        this.fetch(this.polygons.length == 0 ? [0] : this.polygons);
      }
    },
    time:{
      deep: true,
      handler: function (val, oldVal) {
        if(!this.availableDays || this.availableDays == undefined) return false;        
        let day = this.availableDays.find(x => x.date == this.day);
        let time = day.times.find(x => (x.time.from == val.from && x.time.to == val.to));
        let price = time.price;

        if(!this.noCache) this.set({name:'x_price_from_date', value:price})
      },
    },
  },
  mounted(){
    //
  },
  methods:{
    ...mapActions({
      'fetch':'orderLimits/fetchAvailableDays',
      'set':'checkout/setValue'
    }),
  } 
}
</script>

<style>

</style>