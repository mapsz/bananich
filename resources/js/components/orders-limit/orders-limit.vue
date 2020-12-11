<template>
<div>
  <gruzka-navbar></gruzka-navbar>  
  <order-navbar></order-navbar>

  <div class="container-fluid">
    <h2>Orders Limit</h2>
    <!-- Settings -->
    <div class="row mb-3 mx-0 pb-2 pt-2 border-bottom border-top">

      <!-- Settings -->
      <div class="col-12">
        <form class="form-inline">
          <div class="form-group ">
            <label for="ol-days" class="col-sm-6 col-form-label">Available days count</label>
            <div class="col-sm-6">
              <input type="number" id="ol-days" name="order_limit_days_count" v-model="otherSettings['order_limit_days_count']" style="width:50px">
            </div>
          </div>
          <input type="hidden" name="action" value="" />
          <div class="form-group ">
            <label for="ol-time" class="col-sm-6 col-form-label">End orders time (00-23)</label>
            <div class="col-sm-6">
              <input type="number" id="ol-time" name="order_limit_day_end_time" v-model="otherSettings['order_limit_day_end_time']" min="0" max="23" style="width:50px">
            </div>
          </div>
          <button @click.prevent="saveOtherSettings()" class="btn btn-success" type="submit">Save</button>
        </form>
      </div>

      <div class="col-12"><hr></div>

      <div class="col-12">
        <div class="row" v-if="daySettings">
          <!-- Week days -->
          <div v-for="(n, i) in 8" :key="i" class="col border">

            <div class="text-center mb-3">
              <b>{{ i ==0 ? 'Все' : moment().day(i).locale("ru").format('dddd')}}</b>
            </div>

            <div v-if="!(Object.keys(intervals[i]).length === 0) || !(i > 0)">
              <form>
                <div v-for='(ti,j) in timeIntervals' :key='j' class="form-group row mb-2">
                  <label :for="ti.name" class="col-sm-7 col-form-label p-0 pl-2">{{ti.caption}}</label>
                  <div class="col-sm-5 p-0 pl-3" style="align-self: center; display: flex;">
                    <input 
                      v-model="intervals[i][ti.name]"
                      type="number" 
                      :id="ti.name" 
                      :name="ti.name" 
                      style="width:40px; height: 25px;"
                    >
                  </div>
                </div>
                <div class="d-flex justify-content-center">
                  <button v-if="i > 0" @click.prevent="removeIntervals(i)" class="btn btn-sm btn-danger mb-2 mr-3" type="submit">Cancel</button>
                </div>
              </form>
            </div>
            <div v-else class="d-flex justify-content-center">
              <button @click.prevent="intervals[i] = no(intervals[0])" class="btn btn-sm btn-info mb-2" type="submit">Open</button>
            </div>
          </div>          
          <!-- Save -->
          <div class="col-12">
            <div class="d-flex justify-content-center mt-2">
              <button @click.prevent="saveIntervals()" class="btn btn-success mb-2" type="submit">Save</button>
            </div>
          </div>
          

        </div>
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
    intervals:{0:{},1:{},2:{},3:{},4:{},5:{},6:{},7:{}},
    timeIntervals:[
      {caption:'Total',name:'order_limit_total_orders'},
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
    },
    toSendIntervals: function(){
      let to = {};
      let ints = JSON.parse(JSON.stringify(this.intervals))

      $.each(ints, function(i, val) {
        $.each(val, function(k, v) {
          to[k + (i==0 ? '' : '_'+i)] = v;
        });  
      });

      return to;
    },
    daySettings: function(){
      if(this.settings == undefined || this.settings.order_limit_total_orders == undefined) return false;
      return true;
    }
  },
  watch: {
    settings: function(){
      //Other
      if(this.settings.order_limit_days_count != undefined) this.otherSettings.order_limit_days_count = this.settings.order_limit_days_count;
      if(this.settings.order_limit_day_end_time != undefined) this.otherSettings.order_limit_day_end_time = this.settings.order_limit_day_end_time;
    
      //Days
      for (let i = 0; i < 8; i++) {
        if(i == 0){
          this.intervals[i].order_limit_total_orders = this.settings.order_limit_total_orders != undefined ? this.settings.order_limit_total_orders : 0;;
          this.intervals[i].order_limit_interval_11_23 = this.settings.order_limit_interval_11_23 != undefined ? this.settings.order_limit_interval_11_23 : 0;
          this.intervals[i].order_limit_interval_11_15 = this.settings.order_limit_interval_11_15 != undefined ? this.settings.order_limit_interval_11_15 : 0;
          this.intervals[i].order_limit_interval_15_19 = this.settings.order_limit_interval_15_19 != undefined ? this.settings.order_limit_interval_15_19 : 0;
          this.intervals[i].order_limit_interval_19_23 = this.settings.order_limit_interval_19_23 != undefined ? this.settings.order_limit_interval_19_23 : 0;
        }
        else{
          if(this.settings['order_limit_total_orders_'+i]!= undefined){
            this.intervals[i].order_limit_total_orders = this.settings['order_limit_total_orders_'+i]
          }
          if(this.settings['order_limit_interval_11_23_'+i]!= undefined){
            this.intervals[i].order_limit_interval_11_23 = this.settings['order_limit_interval_11_23_'+i]
          }
          if(this.settings['order_limit_interval_11_15_'+i]!= undefined){
            this.intervals[i].order_limit_interval_11_15 = this.settings['order_limit_interval_11_15_'+i]
          }
          if(this.settings['order_limit_interval_15_19_'+i]!= undefined){
            this.intervals[i].order_limit_interval_15_19 = this.settings['order_limit_interval_15_19_'+i]
          }
          if(this.settings['order_limit_interval_19_23_'+i]!= undefined){
            this.intervals[i].order_limit_interval_19_23 = this.settings['order_limit_interval_19_23_'+i]
          }
        }        
      }    
    },
  },
  mounted(){
    this.reload();
  },
  methods:{
    ...mapActions({
      'fetchCalendar'         :'orderLimits/fetchCalendar',
      'fetchSettings'         :'orderLimits/fetchSettings',
    }),
    async saveIntervals(){
      let r = await ax.fetch('/settings', this.toSendIntervals, 'post');
      if(r){
        //Success
        Vue.toasted.show("ага 🐪",{type:'success',position:'bottom-right'});
        this.reload();
      }
    },
    async saveOtherSettings(){
      let r = await ax.fetch('/settings', this.otherSettings, 'post');
      if(r){
        //Success
        Vue.toasted.show("ага 🐪",{type:'success',position:'bottom-right'});
        this.reload();
      }
    },
    async reload(){
      this.fetchCalendar();
      this.fetchSettings();
    },
    async removeIntervals(i){
      this.intervals[i] = {};
      let r = await ax.fetch('/settings', {name:'order_limit_total_orders_'+i}, 'delete');
       r = await ax.fetch('/settings', {name:'order_limit_interval_11_23_'+i}, 'delete');
       r = await ax.fetch('/settings', {name:'order_limit_interval_11_15_'+i}, 'delete');
       r = await ax.fetch('/settings', {name:'order_limit_interval_15_19_'+i}, 'delete');
       r = await ax.fetch('/settings', {name:'order_limit_interval_19_23_'+i}, 'delete');
      if(r){
        //Success
        Vue.toasted.show("ага 🐪",{type:'success',position:'bottom-right'});
        this.reload();
      }
      location.reload();
    },
    no(v){
      return JSON.parse(JSON.stringify(v));
    }
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