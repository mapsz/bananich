<template>
<div>  
  <!-- Pay method buttons -->
  <div class="may-method" style="display: flex;flex-direction: column;">
    <button 
      v-for='(method,i) in methods' :key='i' 
      type="button" 
      class="may-method-item btn"
      :class="selected == method.id ? 'btn-primary' : 'btn-outline-primary'"
      @click="selected=method.id"
    >
      {{method.name}}
    </button>
  </div>

  <!-- Hybrid -->
  <div class="may-method-hybrid" :style="selected == -3 ? 'border: 1px solid #2176bd;border-radius: 5px;background-color: #e7e9eb;' : ''">
    <button 
      type="button" 
      class="may-method-item btn"
      :class="selected == -3 ? 'btn-primary' : 'btn-outline-primary'"
      @click="selected=-3"
      style="margin-top: 0px;"
    >
      Смешанный
    </button>

    <div v-if="selected == -3">
      <div v-for='(method,i) in methods' :key='i' class="form-group m-2 row">
        <label class="col-5" :for="'pay-method-input-'+method.id">{{method.name}}:</label>
        <div class="col-7">
          <input v-model="hybrid[method.id]" type="text" class="form-control" :id="'pay-method-input-'+method.id">
        </div>
      </div>
      <div class="m-2 text-center">
        Сумма: {{hybridSum}}
      </div>
    </div>
  </div>

  
</div>
</template>

<script>
export default {
  model: {event: 'blur'},
  data(){return{
    methods:[],
    selected:-1,
    hybrid:{},
  }},
  computed:{
    hybridSum: function(){
      let sum;
      sum = 0;      
      $.each( this.hybrid, ( k, v ) => {        
        sum += parseInt(v);        
      });
      return parseInt(sum);
    }
  },
  watch: {
    selected: function(){this.$emit('blur', this.selected);},
    hybrid: {
      handler: function (val, oldVal) {
        let r = JSON.parse(JSON.stringify(this.hybrid));
        r.sum = this.hybridSum;
        this.$emit('blur', r);
      },
      deep: true
    }
  },
  mounted(){
    this.get();
  },
  methods:{
    async get(){
      let r = await this.jugeAx('/json/pay/methods');
      if(r){
        this.methods = r;
      } 
    },
  },
}
</script>

<style>
.may-method-hybrid{
  display: flex;
  flex-direction: column;
  margin-top: 5px;
}

</style>