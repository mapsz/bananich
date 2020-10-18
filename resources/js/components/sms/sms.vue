<template>
<div>
  <!-- Menu -->
  <gruzka-navbar></gruzka-navbar>

  <div class="container-fluid">    
    <h1>sms</h1>

    <!-- Send sms -->
    <div class="send-sms">
      <!-- Show send sms button -->
      <button v-if="!showSendSms" @click="showSendSms = true" class="btn btn-primary">
        Отправить СМС
      </button>

      <div v-if="showSendSms" class="send-sms-form border p-3" style="background-color: #e4e4f5;">
        <div class="d-flex justify-content-between">
          <h4>Отправить СМС</h4>
          <button @click="showSendSms = false" class="btn btn-sm btn-outline-danger">❌</button>
        </div>

        <juge-form :inputs="inputs" :errors="errors" :button="'Отправить'" @submit="sendSms"></juge-form>
      </div>

    </div>

    <button @click="inputSms()" class="my-3 btn btn-primary">Input</button>

    <!-- List -->
    <div class="list-sms">
      <juge-list :data="'sms'" :pages="true"></juge-list>
    </div>

  </div>


</div>
</template>

<script>
export default {
data(){return{
  showSendSms:false,
  errors:[],
  inputs:[
    {
      name:'to',
      caption:'номер',
      required:true,
    },
    {
      name:'priority',
      caption:'приоритет',
      required:true,
    },
    {
      name:'body',
      caption:'текст',
      type:'textarea',
      required:true,
    },
  ]  
}},
methods:{
  inputSms(){
    this.$store.dispatch('sms/addFilter',{input:1});
  },
  sendSms(sms){
    let r = ax.fetch('/sms/add/send' , sms, 'put');

    // if(r) location.reload();
    
  }
},
}
</script>

<style>

</style>