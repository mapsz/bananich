<template>
  <div>
    <juge-main>
      <div class="container my-3">

        <div class="header">Формирование коллективной закупки</div>

        <div class="inputs">

          <!-- Member count -->
          <div class="row">
            <div class="col-12 col-lg-6 mb-3 label">
              <span><b>Сколько человек</b> будет участвовать в закупке?</span>            
            </div>
            <div class="col-12 col-lg-6">
              <div class="ml-lg-4">
                <input v-model="data.memberCount" type="range" class="form-control-range custom-range" id="memberCount" min="1" :max="maxMemberCount">
                <div class="mx-1 d-flex justify-content-between">
                  <span 
                    @click="data.memberCount = n"
                    v-for="(n, i) in maxMemberCount" :key="i" 
                    :style="data.memberCount == n ? 'font-weight: 600;' : ''"
                  >
                    {{n}}
                  </span>
                </div>
              </div>
            </div>
          </div>

          <hr class="my-30">
          
          <!-- Date/Time -->
          <div class="row">            
            <checkout-date-time class="checkout-div w-100" :design="'x'" v-model="data.dateTime"/> 
          </div>

          <hr class="my-30">

          <!-- Address -->
          <div class="row">
            <div class="col-12 col-lg-6 mb-3 label">
              <!-- <span><b>Дата</b> доставки</span>      -->
              <checkout-address class="checkout-div" :design="'x'" v-model="data.address"/>
            </div>
          </div>

          <hr class="my-30">

          <!-- Comment -->
          <div class="row">
            <div class="col-12 col-lg-6 mb-3 label">
              <!-- <span><b>Дата</b> доставки</span>      -->
              <checkout-comment class="checkout-div" v-model="data.comment"/>
            </div>
          </div>
          
          <!-- Annonce -->
          <div class="row">
            <div class="col-12 col-lg-6 offset-lg-6">
              <div class="announce-block">
                <div><b>Хотите вступить в совместную закупку, но не с кем?</b></div> 
                <div>Мы найдем для вас соседа!</div> 
              </div>
            </div>
          </div>

 

          <!-- Actions -->
          <div class="row">
            <div class="col-12 col-lg-6 offset-lg-6 mb-3">
              <div class="actions">
                <!-- Errors -->
                <div class="mb-3">
                  <div v-for='(errorz,z) in errors' :key='z+"d"'>
                    <span v-for='(error,j) in errorz' :key='j' style="color: tomato;">
                      ❗{{error}}
                    </span>    
                  </div>
                </div>
                <button class="x-btn x-btn-trans mb-2">
                  Найти соседа
                </button>
                <button @click="open()" class="x-btn">
                  Начать закупку
                </button>
              </div>
            </div>
          </div>

        </div>


        <div v-if="loaded && 0" class="row">
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
    </juge-main>
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
  //Redirect if exist
  let exist = await this.byAuth();
  if(exist && exist.link != undefined){window.location.href = '/shared/order/'+exist.link}


  await this.fetchAvailableDays();
},
methods:{  
  ...mapActions({
    'fetchAvailableDays':'orderLimits/fetchAvailableDays',
    'byAuth':'sharedOrder/byAuth',
  }),  
  async open(){
    //Refresh errors
    this.errors = [];
    if(this.data.dateTime != undefined){
      if(this.data.dateTime.date  != undefined){
        this.data.date = this.data.dateTime.date;
      }
      if(this.data.dateTime.time  != undefined){
        this.data.time = this.data.dateTime.time;
      }
    }

    //Fetch
    let r = await ax.fetch('/shared/order/open',this.data,'put');

    //Catch errors
    if(!r){if(ax.lastResponse.status == 422){this.errors = ax.lastResponse.data.errors;return;}}

    //Success
    if(r){window.location.href = '/shared/order/'+r.link};

  },
},
}
</script>

<style scoped>
.header{  
  font-size: 25px;
  font-weight: 600;
  line-height: 140%;
}
.inputs{
  margin-top:24px;
}
.label{
  font-size: 20px;
  line-height: 160%;
  text-transform: uppercase;
}
.actions{
  margin-top:36px;
}
.actions .x-btn{
  width:100%;
}

/* Desktop */
@media screen and (min-width: 992px){
  .header{  
    max-width: 651px;
    font-size: 56px;
  }
  .label{
    max-width: 540px;   
    font-size: 30px;
  }
  .inputs{
    margin-top:200px;
  }
  .actions{
    margin-top:50px;
  }
}

.custom-range::-webkit-slider-thumb {
  background: #8AC2A7;
}
.custom-range::-moz-range-thumb {
  background: #8AC2A7;
}
.custom-range::-ms-thumb {
  background: #8AC2A7;
}
</style>