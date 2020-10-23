<template>
<div class="d-flex">  
  <!-- Activate/Deactivate     -->
  <div class="date-activate-deactivate mr-2">
    <span class="date-activate-deactivate-button">
      <toggle-button v-model="active" :labels="{checked: 'On', unchecked: 'Off'}"/>
    </span>
  </div>    
  <!-- Date Menu -->
  <div v-if="active" class="input-group input-group-sm date-menu" style="width: auto;">
    <!-- From/To -->
    <div class="input-group-prepend">
      <span class="input-group-text" id="date-from">От:</span>
    </div>
    <flat-pickr v-model="date.from" :config="config"></flat-pickr>    
    <div class="input-group-prepend">
      <span class="input-group-text" id="date-to">До:</span>
    </div>
    <flat-pickr v-model="date.to" :config="config"></flat-pickr>
    <!-- Near Dates -->
    <div class="ml-2">
      <span 
        v-for="date in nearDates" :key="date.caption"
        class="near-date"
        :class="compareNearDates(date.date) ? 'active-near-date' : ''"
        @click="setDate(date.date)"
      >
        {{date.caption}}
      </span>
    </div>  
  </div>   
  <div v-else >Дата</div>
</div>
</template>

<script>
import {mapActions} from 'vuex';
export default {
  props: ['pActive'],
  data() {
    return {
      config:datePickerConfig,
      mFormat:'DD.MM.YYYY',
      date:{
        format:'DD.MM.YYYY',
        from:null,
        to:null,
      },    
      nearDates:this.makeNearDates(),
      emit:true,
      active:this.pActive,
    }
  },
  computed:{
    dateSql: function(){
      return {
        from:this.date.from ? (
          moment(this.date.from,this.date.format).format('YYYY-MM-DD')
        ) : false,
        to:this.date.to ? (
          moment(this.date.to,this.date.format).format('YYYY-MM-DD')
        ) : false,
      }
      
    }
  },
  watch: {
    date:{
      deep:true,
      handler:function () {this.dateChanged();},
    },
    active: function () {
      if(!this.active){
        this.date.from = null;
        this.date.to   = null;
      }
    },
  },
  async mounted(){
    //Set from/to
    if(this.active){
      await this.setTodayDates();
      this.emit = true;
    }else{
      this.dateChanged();  
    }
  },
  methods:{
    ...mapActions(['setFilter']),
    makeNearDates(){
      let dates = [];
      dates.push({date:moment().subtract(2, "days"),caption:moment().subtract(2, "days").format('DD.MM')});
      dates.push({date:moment().subtract(1, "days"),caption:'Вчера'});
      dates.push({date:moment(),caption:'Сегодня'});
      dates.push({date:moment().add(1, "days"),caption:'Завтра'});
      dates.push({date:moment().add(2, "days"),caption:moment().add(2, "days").format('DD.MM')});
      return dates;
    },
    compareNearDates(nearDate){
      let compare = (
          nearDate.format('DMY') == moment(this.date.from, this.mFormat).format('DMY') &&
          nearDate.format('DMY') == moment(this.date.to, this.mFormat).format('DMY')
        );
        
      return compare;
    },
    setDate(date){
      if(!this.active) return;
      let fDate = date.format(this.mFormat);
      this.date.from = fDate;
      this.date.to = fDate;
    },
    async setTodayDates(){
      this.date.from = moment().format(this.mFormat);
      this.date.to = moment().format(this.mFormat);
      return;
    },
    dateChanged(){      
      if(this.emit){
        this.setFilter({deliveryDate:this.dateSql});
        this.$emit('dateChanged',this.dateSql);
      }
    },
    doActivates(){
      this.active = !this.active;
    }
  }
}
</script>

<style scoped>
  .near-date {
    cursor: pointer;
    margin: 0px 10px;
  }
  .near-date:hover {
    color: limegreen;
    font-weight: 600;
  }
  .active-near-date{
    color:green;
    font-weight: 600;
    cursor: default !important;
  }
  .active-near-date:hover{
    color:green !important;
  }
  .date-activate-deactivate-button{
    cursor:pointer;
  }
</style>