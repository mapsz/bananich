<template>
  <div>
    <site-header/>
      <div class="container my-3">
        <h1 class="m-3">Shared order open</h1>

        <div v-if="loaded" class="row">
          <div class="col-6">
            <!-- Member count -->
            <div class="form-group">
              <label for="memberCount">Количество учатников: {{data.memberCount}}</label>
              <input v-model="data.memberCount" type="range" class="form-control-range" id="memberCount" min="1" :max="maxMemberCount">
            </div>

            <!-- Address -->
            <div>
              <checkout-address v-model="data.address" />
            </div>

            <!-- Date -->
            <div v-if="datePickerConfig">
              <h5>Дата</h5>
              <datepicker v-model="data.date" 
                :language="datePickerConfig.ru" 
                :monday-first="true" 
                :disabled-dates="datePickerConfig.disabledDates" 
              />
            </div>

            <!-- Time -->
            <div v-if="availableTimes" class="col-lg-6">
              <div class="checkout-title">Время доставки</div>
              <checkout-input v-model="data.time" :name="'deliveryTime'" :type="'radio'" 
                :list="availableTimes" 
              />
            </div>

            <!-- Comment -->
            <div class="mt-3">
              <checkout-comment class="checkout-div" v-model="data.comment"/>
            </div>

            <!-- Errors -->
            <div v-for='(errorz,z) in errors' :key='z+"d"'>
              <span v-for='(error,j) in errorz' :key='j'>
                {{error}}
              </span>    
            </div>            

            <!-- Open -->
            <div class="mt-3">
              <button @click="open()" class="btn btn-success">открыть</button>
            </div>

          </div>
        </div>

      </div>
    <site-footer/>
  </div>
</template>

<script>
//Date picker
import Datepicker from 'vuejs-datepicker';
import {ru} from 'vuejs-datepicker/dist/locale'
import {mapGetters, mapActions} from 'vuex';
export default {
components: {Datepicker},
data(){return{  
  data:{
    memberCount:1,
    address:null,
    date:null,
    time:null,
    comment:"",
  },
  errors:[],
}},
computed:{  
  ...mapGetters({
    settings:'settings/beautyGet',
    availableDays: 'orderLimits/getAvailableDays',
  }),
  maxMemberCount:function(){
    if(this.settings == undefined) return false;
    if(this.settings.x_max_member_count == undefined) return false;
    if(this.settings.x_max_member_count < 1) return false;

    return this.settings.x_max_member_count;

  },
  datePickerConfig:function(){

    if(this.availableDays == undefined) return false;
    if(!Array.isArray(this.availableDays)) return false;
    if(this.availableDays.length < 1) return false;

    //Min date    
    let minDate = new Date(this.availableDays[0].date);
    this.availableDays.forEach(day => {
      let dayDate = new Date(day.date);
      if(minDate > dayDate) minDate = dayDate;
    });
    minDate.setDate(minDate.getDate() - 1);

    //Max date    
    let maxDate = new Date(this.availableDays[0].date);
    this.availableDays.forEach(day => {
      let dayDate = new Date(day.date);
      if(maxDate < dayDate) maxDate = dayDate;
    });

    //Exclude days
    let diffDays = Math.ceil(Math.abs(maxDate - minDate) / (1000 * 60 * 60 * 24));
    let excludeDays = [];
    for (let i = 0; i < diffDays+2; i++) {
      let date = new Date(JSON.parse(JSON.stringify(minDate)));
      date = moment(date.setDate(date.getDate() + i)).format('YYYY-MM-DD')
      let find = this.availableDays.findIndex(x => x.date == date);
      if(find == -1){
        excludeDays.push(new Date(date))
      }      
    }

    //Return
    return {
      ru:ru,
      disabledDates:{
        to:   minDate,
        from: maxDate,
        dates: excludeDays,        
      }
    }
  },
  availableTimes:function(){
    if(!this.datePickerConfig) return false;
    if(!this.data.date) return false;
    
    //Get day
    let date = moment(this.data.date).format('YYYY-MM-DD');
    let day = this.availableDays.find(x => x.date == date);

    //Times
    let times = [];
    day.times.forEach(v => {
        if(v.slots < 1) return;
        times.push(
          {
            'value':v.time,
            'caption':'с '+ v.time.from + ' до '+v.time.to,
        });
      
    });

    return times;
  },
  loaded:function(){
    if(this.maxMemberCount) return true;
    return false;
  }
},
async mounted() {
  this.fetch();
},
methods:{  
  ...mapActions({
    'fetch'         :'orderLimits/fetchAvailableDays',
  }),  
  async open(){
    //Refresh errors
    this.errors = [];

    //Fetch
    let r = await ax.fetch('/shared/order/open',this.data,'put');

    //Catch errors
    if(!r){if(ax.lastResponse.status == 422){this.errors = ax.lastResponse.data.errors;return;}}

    //Success
    if(r){
      window.location.href = '/shared/order/'+r.link;
    }


  },  
},
}
</script>

<style>

</style>