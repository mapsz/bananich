<template>
  <div>
    <!-- Latest -->
    <div v-for='(log,i) in logs' :key='i' >
      <span v-if="i < 7">  
        <span>{{log.created_at}}</span>
        <span :class="log.type ? 'text-'+log.type : ''">{{log.body}}</span> 
      </span>
    </div>

    <!-- More -->
    <div>
      <b-button v-b-toggle.collapse-1 variant="outline-primary" size="sm">еще</b-button>
      <b-collapse id="collapse-1" class="mt-2">
        <div v-for='(log,i) in logs' :key='i' >
          <span v-if="i > 6">  
            <span>{{log.created_at}}</span>
            <span :class="log.type ? 'text-'+log.type : ''">{{log.body}}</span> 
          </span>
        </div>
      </b-collapse>
    </div>

  </div>
</template>

<script>
export default {
data(){return{
  logs:[],  
}},
async mounted() {
  this.get();
},
methods:{
  async get(){
    let r = await ax.fetch('/admin/libra/logs');
    this.logs = r;
  }
},
}
</script>

<style>

</style>