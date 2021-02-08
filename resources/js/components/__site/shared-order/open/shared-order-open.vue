<template>
  <div>
    <juge-main>
      <div class="container my-3">

        <div v-if="!isEdit" class="x-header">Формирование коллективной закупки</div>
        <div v-if="isEdit" class="x-header">Редактирование коллективной закупки</div>

        <!-- Open blocks -->
        <shared-order-open-blocks class="mt-5" v-if="!isEdit"/>

        <!-- Inputs -->
        <div class="inputs">

          <!-- Member count -->
          <div class="row">
            <div class="col-12 col-lg-6 mb-3 label">
              <span><b>Сколько человек</b> будет участвовать в закупке?</span>            
            </div>
            <div class="col-12 col-lg-6">
              <div class="ml-lg-4">
                <input v-model="data.memberCount" type="range" class="form-control-range custom-range" id="memberCount" min="2" :max="maxMemberCount">
                <div class="mx-1 d-flex justify-content-between">
                  <template v-for="(n, i) in maxMemberCount">
                    <span
                      v-if="n > 1"
                      :key="n"
                      @click="data.memberCount = n"
                      :style="data.memberCount == n ? 'font-weight: 600;' : ''"
                    >
                      {{n}}
                    </span>
                  </template>

                </div>
              </div>
            </div>
          </div>         
          
          <!-- Date -->
          <template v-if="availableDays">
            <hr class="my-30">
            <div class="row">
              <div class="col-12 col-lg-6 mb-3 label">
                <span><b>Дата</b>  доставки</span>            
              </div>
              <div class="col-12 col-lg-6">
                <div class="ml-lg-4 date-inputs">
                  <div v-for='(input,i) in availableDays' :key='i' class="mb-3" >
                    <input 
                      v-model="data.date" 
                      @change="data.time = null" 
                      class="custom-radio" 
                      type="radio" 
                      :id="'date-'+i" 
                      :value="input.date" 
                      :name="'date'"
                    >
                    <label :for="'date-'+i" class="input-label">{{input.date}}</label>
                  </div>
                </div>
              </div>
            </div>
          </template>

          <!-- Time -->
          <template v-if="availableTimes && data.date">
            <hr class="my-30">
            <div class="row">
              <div class="col-12 col-lg-6 mb-3 label">
                <span><b>Время</b> доставки</span>            
              </div>
              <div class="col-12 col-lg-6">
                <div class="ml-lg-4 date-inputs">
                  <div v-for='(input,i) in availableTimes' :key='i' class="mb-3" >
                    <input v-model="data.time" class="custom-radio" type="radio" :id="'time-'+i" :value="input.value" :name="'time'">
                    <label :for="'time-'+i" class="input-label">{{input.caption}}</label>
                  </div>
                </div>
              </div>
            </div>
          </template>

          <!-- Address -->
          <template>
            <hr class="my-30">
            <div class="row">
              <div class="col-12 col-lg-6 mb-3 label">
                <span><b>Адрес</b> доставки</span>            
              </div>
              <div class="col-12 col-lg-6">
                <div class="ml-lg-4">     
                  <!-- Show -->
                  <choose-address />

                  <!-- <checkout-address class="checkout-div" :design="'x'" v-model="data.address"/> -->
                </div>
              </div>
            </div>
          </template>

          <!-- Comment -->
          <template v-if="0">
            <hr class="my-30">
            <div class="row">
              <div class="col-12 col-lg-6 mb-3 label">
                <span><b>комментарий</b> к закупке</span>            
              </div>
              <div class="col-12 col-lg-6">
                <div class="ml-lg-4">                  
                  <checkout-comment class="checkout-div" :design="'x'" v-model="data.comment" :no-cache="true"/>
                </div>
              </div>
            </div>
          </template>

          <!-- Annonce -->
          <template v-if="!isEdit">
            <div class="row mt-5">
              <div class="col-12 col-lg-6 offset-lg-6">
                <div class="announce-block">
                  <div><b>Хотите вступить в совместную закупку, но не с кем?</b></div> 
                  <div>Мы найдем для вас соседа!</div> 
                </div>
              </div>
            </div>
          </template>

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
                <!-- Open -->
                <template v-if="!isEdit">
                  <button @click="open(true)" class="x-btn x-btn-trans mb-2">
                    Найти соседа
                  </button>
                  <button @click="open()" class="x-btn">
                    Открыть закупку
                  </button>
                </template>
                <!-- Edit -->
                <template v-if="isEdit">
                  <button @click="edit()" class="x-btn">
                    Редактировать
                  </button>
                </template>
              </div>
            </div>
          </div>

        </div>



      </div>

      
    <login-modal :p-show="showLogin" :p-show-type="'signup'" @close="showLogin=false" />
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
    memberCount:2,
    address:null,
    date:null,
    time:null,
    comment:"",
  },  
  isEdit:false,
  errors:[],
  showLogin:false,
}},
computed:{
  ...mapGetters({
    sOrders:        'sharedOrder/get',
    user:           'user/get',
    settings:       'settings/beautyGet',
    availableDaysEx:'orderLimits/getAvailableDays',
  }),
  availableDays:function(){
    if(!this.availableDaysEx) return false;

    let days = this.availableDaysEx;

    if(this.sOrder != undefined && this.sOrder.delivery_date != undefined){
      if(days.findIndex(x => x.date == this.sOrder.delivery_date) < 0){
        days = [{
          date:this.sOrder.delivery_date,
        }].concat(days);      
      }      
    }


    //Launch remove days
    let noBadDays = [];
    days.forEach(day => {
      if(
        day.date != '2021-01-20' &&
        day.date != '2021-01-21'        
      ){
        noBadDays.push(day);
      }
    });

    return noBadDays;

  },
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
    let times = [];
    if(!this.availableDays) return times;
    if(!this.data.date) return times;

    //Add current time
    if(this.sOrder != undefined && this.sOrder.delivery_date != undefined){
      if(this.sOrder.delivery_date == this.data.date){
        //time
        if(this.sOrder.delivery_time_from != undefined && this.sOrder.delivery_time_to != undefined){
          times.push({
            'value':{
              from: this.sOrder.delivery_time_from.replace(':00:00', ''),
              to:   this.sOrder.delivery_time_to.replace(':00:00', '')
            },
            'caption':
              'с '+ this.sOrder.delivery_time_from.replace(':00:00', '') + 
              ' до '+ this.sOrder.delivery_time_to.replace(':00:00', '')                   
          });
        }
      }
    }    
    
    //Get day
    let date = moment(this.data.date).format('YYYY-MM-DD');
    let day = this.availableDays.find(x => x.date == date);
    if(!day || day.times == undefined) return times;

    //Times    
    day.times.forEach(v => {
      //Skip no free slot
      if(v.slots == undefined || v.slots < 1) return;
      //Skip already exists
      let index = times.findIndex(x => (x.value.from == v.time.from && x.value.to == v.time.to));
      if(index >= 0){times.splice(index, 1);} 
      //Add
      times.push({
        'value':v.time,
        'caption':'с '+ v.time.from + ' до '+v.time.to,
      });      
    });

    return times;
  },
  loaded:function(){
    if(this.maxMemberCount) return true;
    return false;
  },
  link(){
    if(this.$route == undefined || this.$route.params == undefined || this.$route.params.order_link == undefined) return false;    
    return this.$route.params.order_link;
  },
  sOrder(){
    if(this.sOrders == undefined || this.sOrders.length < 1) return false;
    return this.sOrders[0];
  },
},
watch:{
  sOrder: function (val, oldVal) {
    if(val.id == undefined) return;

    //Member count
    if(val.member_count != undefined)
      this.data.memberCount = val.member_count;

    //address
    if(val.address != undefined)
      this.data.address = val.address;

    //comment
    if(val.comment != undefined)
      this.data.comment = val.comment.body;

    //time
    if(val.delivery_time_from != undefined && val.delivery_time_to != undefined){
      this.data.time = {
        from: val.delivery_time_from.replace(':00:00', ''),
        to:   val.delivery_time_to.replace(':00:00', '')
      };
    }
      
    //date
    if(val.delivery_date != undefined){
      this.data.date = val.delivery_date;
    }

    // delivery_time_from: (...)
    // delivery_time_to: (...)


  },
  user: function (val, oldVal) {
    if(!this.user){this.showLogin = true;}
    if(this.user){this.showLogin = false;}
  }
},
async mounted(){

  
  if(this.$route.path == '/shared/order') this.$router.push('/shared/order/open');

  await this.handle();

  //Check edit
  if(location.href.includes('/shared/order/edit')){
    this.isEdit = true;
    //Get order
    await this.filter({'link':this.link});
    await this.get();
  } 

  //Redirect if exist
  let exist = await this.byAuth();
  if(exist && exist.link != undefined && !this.isEdit){window.location.href = '/shared/order/'+exist.link}

  //Get pre
  if(this.$route != undefined && this.$route.query != undefined  && this.$route.query.pre != undefined){
    this.data.memberCount = this.$route.query.pre;
  }

  //Get available days
  await this.fetchAvailableDays();
},
methods:{
  ...mapActions({
    'fetchAvailableDays':'orderLimits/fetchAvailableDays',
    'byAuth':'sharedOrder/byAuth',
    'handle':'sharedOrder/handle',
    'filter':'sharedOrder/addFilter',
    'get':'sharedOrder/fetchData',
    'update':'sharedOrder/update',
  }),  
  async open(neighbor = false){
    if(!this.user){this.showLogin = true;return}
    
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
    let data = this.data;
    if(neighbor) data.neighbor = true;
    let r = await ax.fetch('/shared/order/open',data,'put');

    //Catch errors
    if(!r){if(ax.lastResponse.status == 422){this.errors = ax.lastResponse.data.errors;return;}}

    //Success
    if(r){window.location.href = '/shared/order/'+r.link + (neighbor ? '?neighbor=true' : '')};

  },
  async edit(){
    if(this.sOrder == undefined) return;    
    //Refresh errors
    this.errors = [];
    let data = this.data;
    data.id = this.sOrder.id;
    let r = await ax.fetch('/shared/order',data,'post');

    //Catch errors
    if(!r){if(ax.lastResponse.status == 422){this.errors = ax.lastResponse.data.errors;return;}}

    //Success
    if(r){window.location.href = '/shared/order/'+this.sOrder.link};

    console.log(r);
  }
},
}
</script>

<style scoped>
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
.date-inputs{
  display: grid;   
  grid-template-columns: 1fr 1fr ;
}
.input-label{    
  font-size: 18px;
  line-height: 130%;
}

/* Desktop */
@media screen and (min-width: 992px){
  .label{
    max-width: 540px;   
    font-size: 30px;
  }
  .inputs{
    margin-top:100px;
  }
  .actions{
    margin-top:50px;
  }
  .input-label{    
    font-size: 22px;
    line-height: 130%;
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