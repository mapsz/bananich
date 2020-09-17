<template>
<div>
  <gruzka-navbar></gruzka-navbar>  
  <order-navbar></order-navbar>

  <div class="container-fluid">
    <h2>Orders Limit</h2>
    <!-- Settings -->
    <div class="row mb-3 mx-0 pb-2 pt-2 border-bottom border-top">
      <!-- Intervals -->
      <div class="col-4">
        <form>
          <div v-for='(ti,i) in timeIntervals' :key='i' class="form-group row">
            <label :for="ti.name" class="col-sm-4 col-form-label">{{ti.caption}}</label>
            <div class="col-sm-8">
              <input 
                v-model="intervals[ti.name]"
                type="number" 
                :id="ti.name" 
                :name="ti.name" 
              >
            </div>
          </div>
          <button @click.prevent="saveIntervals()" class="btn btn-success" type="submit">Save</button>
        </form>
      </div>

      <!-- Settings -->
      <div class="col-4">
        <form >
          <div class="form-group row">
            <label for="ol-days" class="col-sm-6 col-form-label">Total Orders</label>
            <div class="col-sm-6">
              <input type="number" id="ol-days" name="order_limit_total_orders" v-model="otherSettings['order_limit_total_orders']" >
            </div>
          </div>
          <div class="form-group row">
            <label for="ol-days" class="col-sm-6 col-form-label">Available days count</label>
            <div class="col-sm-6">
              <input type="number" id="ol-days" name="order_limit_days_count" v-model="otherSettings['order_limit_days_count']">
            </div>
          </div>
          <input type="hidden" name="action" value="" />
          <div class="form-group row">
            <label for="ol-time" class="col-sm-6 col-form-label">End orders time (00-23)</label>
            <div class="col-sm-6">
              <input type="number" id="ol-time" name="order_limit_day_end_time" v-model="otherSettings['order_limit_day_end_time']" min="0" max="23">
            </div>
          </div>
          <button @click.prevent="saveOtherSettings()" class="btn btn-success" type="submit">Save</button>
        </form>
      </div>
    </div> 

    <!-- Calendar --> 
    <div class="row m-0 mb-2 pb-2 border-bottom">
      <table style="font-size:16pt; width:100%;">
        <thead style="border-bottom: 1px dashed black;font-weight: 700;">
          <!-- Titles -->
          <tr>
            <td></td>
            <td v-for='(day,i) in days' :key='i' :class="moment().format('DD.MM') == moment(day).format('DD.MM') ? 'now' : ''">
              <span class="d-flex justify-content-center">
                {{moment(day).format('DD.MM')}}
              </span>          
            </td>    
          </tr>
        </thead>
        <tbody>
          <!-- Total -->
          <tr style="font-weight: 700;border-bottom: 1px solid black;">
            <td>Total:</td>
            <td v-for='(day,i) in days' :key='i' :class="moment().format('DD.MM') == moment(day).format('DD.MM') ? 'now' : ''">
              <span class="d-flex justify-content-center">
                {{ orders.filter(x => x.delivery_date == moment(day).format('YYYY-MM-DD')).length }}
              </span>     
            </td>
          </tr>
          <!-- Time intervals -->
          <tr v-for='(ti,i) in timeIntervals' :key='i' >
            <!-- Title -->
            <td>{{ti.caption}}</td>
            <!-- Interval counts -->
            <td v-for='(day,i) in days' :key='i' :class="moment().format('DD.MM') == moment(day).format('DD.MM') ? 'now' : ''">
              <span class="d-flex justify-content-center">
                 {{ orders.filter(x => x.delivery_date == moment(day).format('YYYY-MM-DD')).filter(x => moment(x.delivery_time_from ,'DD:mm:ss').format('DD:00')+'-'+moment(x.delivery_time_to ,'DD:mm:ss').format('DD:00') == ti.caption).length }}
              </span>     
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>


</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{
    moment:moment,
    intervals:{},
    timeIntervals:[
      {caption:'11:00-23:00',name:'order_limit_interval_11_23'},
      {caption:'11:00-15:00',name:'order_limit_interval_11_15'},
      {caption:'15:00-19:00',name:'order_limit_interval_15_19'},
      {caption:'19:00-23:00',name:'order_limit_interval_19_23'},
    ],
    otherSettings:{}
  }},
  computed:{
    ...mapGetters({
      orders: 'orderLimits/getCalendar',
      settings: 'orderLimits/getSettings',
    }),    
    days: function(){
      let min = 0;
      let max = 0;

      $.each(this.orders , ( k, v ) => {
        let unix = moment(v.delivery_date).unix();
        if (min > unix || min == 0) min = unix;
        if (max < unix || max == 0) max = unix;
      });
      
      if(min == 0 ||min == 0) return false;

      let day = min;
      let days = [];
      
      days.push(moment.unix(min));
      do{
        day = moment.unix(day).add(1, 'd').unix();
        days.push(moment.unix(day));
      }while(day <= max);

      return days;
    }
  },
  watch: {
    settings: function(){
      if(this.settings.order_limit_interval_11_15 != undefined) this.intervals.order_limit_interval_11_15 = this.settings.order_limit_interval_11_15;
      if(this.settings.order_limit_interval_11_23 != undefined) this.intervals.order_limit_interval_11_23 = this.settings.order_limit_interval_11_23;
      if(this.settings.order_limit_interval_15_19 != undefined) this.intervals.order_limit_interval_15_19 = this.settings.order_limit_interval_15_19;
      if(this.settings.order_limit_interval_19_23 != undefined) this.intervals.order_limit_interval_19_23 = this.settings.order_limit_interval_19_23;

      if(this.settings.order_limit_total_orders != undefined) this.otherSettings.order_limit_total_orders = this.settings.order_limit_total_orders;
      if(this.settings.order_limit_days_count != undefined) this.otherSettings.order_limit_days_count = this.settings.order_limit_days_count;
      if(this.settings.order_limit_day_end_time != undefined) this.otherSettings.order_limit_day_end_time = this.settings.order_limit_day_end_time;
    },
  },
  mounted(){
    this.fetchCalendar();
    this.fetchSettings();
  },
  methods:{
    ...mapActions({
      'fetchCalendar'         :'orderLimits/fetchCalendar',
      'fetchSettings'         :'orderLimits/fetchSettings',
    }),
    async saveIntervals(){
      let r = await ax.fetch('/settings', this.intervals, 'post');
      location.reload();
    },
    async saveOtherSettings(){
      let r = await ax.fetch('/settings', this.otherSettings, 'post');
      location.reload();
    },
  },

}
</script>

<style scoped>
  .now{
    font-size: 18pt;
    color: green;
  }
  .available-days{
    display: flex;
    flex-direction: column;
    align-items: center; 
  }
</style>