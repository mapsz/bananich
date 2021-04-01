<template>  
<div>  
  <gruzka-navbar></gruzka-navbar>  

  <div class="container">
    <h1>Sklad</h1>
    <div class="mt-3">
      <div class="row">
        <div class="col-3">
          <h4>Status</h4>

        </div>

        <div class="col-2">
          <h4>Actions</h4>
          <!-- Reset PC -->
          <div class="m-2"><button @click="resetPc()" class="btn btn-info btn-sm">Reset PC</button></div>
          <div class="m-2"><button @click="resetPc()" class="btn btn-info btn-sm">Reset SMS</button></div>          
        </div>

        <div class="col-7">
          <h4>Log</h4>
          <div>
            <div v-for="(log, i) in logs" :key="i" class="" style="border-bottom:gray 1px solid">
              {{moment(log.created_at).format('DD.MM.YY HH:mm')}}
              <span 
                :class="
                  (log.direction == 'OUT' ? 'text-info ' : '')+
                  (log.direction == 'IN' ? 'text-warning ' : '')
                "
              >
                {{log.direction}}                
              </span>
              <span v-if="log.query != undefined">{{log.query}}</span>
            </div>
          </div>

          
          
        </div>
      </div>
    </div>
    
  </div>


    
</div>  
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
data(){return{
  moment:moment,
}},
computed:{
  ...mapGetters({
    data:'sklad/get',
    rawLogs:'sklad/getLogs'
  }),
  logs(){
    if(this.rawLogs == undefined || !this.rawLogs) return [];

    this.rawLogs.forEach(log => {
      let body = JSON.parse(log.body);
      if(body.query != undefined) log.query = body.query;
      log.direction = body.direction;
    });

    return this.rawLogs;
  },
},
async mounted() {
  this.firstFetch();
},
methods:{
  ...mapActions({
    fetch:'sklad/fetch',
    fetchLogs:'sklad/fetchLogs',
    firstFetch:'sklad/firstFetch',
    resetPc:'sklad/resetPc',
  }),  
},
}
</script>

<style>

</style>