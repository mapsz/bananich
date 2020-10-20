<template>
  <div>
    <gruzka-navbar></gruzka-navbar>
    <div class="container">
      <juge-form :inputs="inputs" :errors="errors" @submit="submit"></juge-form>
    </div>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  computed:{
    ...mapGetters({page:'page/getOne',inputs:'page/getInputs',errors:'page/getErrors'}),    
  },
  mounted(){
    this.fetch();
    this.fetchInputs();
  },
  methods:{
    ...mapActions({
      'fetch':'page/fetchOne',
      'fetchInputs':'page/fetchInputs',
    }),
    async submit(data){
      let id = await ax.fetch('/page',data,'put');
      location.href = '/admin/page/'+id;
    }
  },
}
</script>

<style>

</style>