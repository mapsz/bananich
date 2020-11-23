<template>
<div class="row w-100">  
  <!-- Activate/Deactivate     -->
  <div class="col-12 col-md-1 date-activate-deactivate mr-2 align-self-center mb-2 mb-md-0">
    <div class="d-flex justify-content-md-center">
    <span class="date-activate-deactivate-button">
      <b-form-checkbox v-model="active" switch size="lg"/>
    </span>    
    <!-- Inactvie -->
    <div v-if="!active" >Дата</div>
    </div>
  </div>    
  <!-- Date Menu -->    
  <template v-if="active" >
    <div class="input-group input-group-sm date-menu" style="width: auto; max-width:100%">
      <!-- From/To -->
      <div class="d-flex m-2">
        <div class="input-group-prepend">
          <span class="input-group-text" id="date-from">От:</span>
        </div>
        <flat-pickr v-model="date.from" :config="config"></flat-pickr>    
      </div>
      <div class="d-flex m-2">
        <div class="input-group-prepend">
          <span class="input-group-text" id="date-to">До:</span>
        </div>
        <flat-pickr v-model="date.to" :config="config"></flat-pickr>
      </div>
    </div>
    <!-- Near Dates -->
    <div class="col-12 col-md-6 p-0 d-flex-sm justify-content-between align-self-center">
      <span 
        v-for="date in nearDates" :key="date.caption"
        class="near-date"
        :class="compareNearDates(date.date) ? 'active-near-date' : ''"
        @click="setDate(date.date)"
      >
        {{date.caption}}
      </span>
    </div>  
  </template>
</div>
</template>

<script>
export default {
  props: ['model','default'],
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
      active:false,
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
    if(this.default != false){
      this.active = true;
      this.setTodayDates();
      this.dateChanged();
    }
  },
  methods:{
    //Make dates
    makeNearDates(){
      let dates = [];
      dates.push({date:moment().subtract(2, "days"),caption:moment().subtract(2, "days").format('DD.MM')});
      dates.push({date:moment().subtract(1, "days"),caption:'Вчера'});
      dates.push({date:moment(),caption:'Сегодня'});
      dates.push({date:moment().add(1, "days"),caption:'Завтра'});
      dates.push({date:moment().add(2, "days"),caption:moment().add(2, "days").format('DD.MM')});
      return dates;
    },    
    async setTodayDates(){
      this.date.from = moment().format(this.mFormat);
      this.date.to = moment().format(this.mFormat);
      return;
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
    dateChanged(){
      //Set vuex
      if(this.model != undefined){
        this.$store.dispatch(this.model+'/addFilter',{deliveryDate:this.dateSql});
      }
      //Emit
      this.$emit('dateChanged',this.dateSql);
    }
  }
}
</script>

<style scoped>
  .near-date {
    cursor: pointer;
    margin: 0px 5px;
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