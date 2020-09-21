<template>
  <div>
    <form @submit.prevent="change()">
      <input v-model="count" type="number" style="width:75px">
      <button type="submit">Save</button>
      <span v-if="ok" style="color:limegreen">ok</span>
    </form>
  </div>
</template>

<script>
export default {
  props: ['data'],
  data(){return{
    count:JSON.parse(JSON.stringify(this.data.count)),
    ok:false,
  }},
  methods:{
    async change(){
      this.ok = false;
      let r = await ax.fetch('/coupon',{id:this.data.id, count:this.count},'post');

      if(r == 1){
        this.ok = true;
      }
    }
  },
}
</script>

<style>

</style>