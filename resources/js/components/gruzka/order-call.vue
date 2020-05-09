<template>
<div class="container-fluid">
  <gruzka-navbar></gruzka-navbar>

  <div class="row">
    <button class="btn btn-danger mx-2">Отменён</button>
    <button class="btn btn-primary mx-2">Список заказов</button>
    <button class="btn btn-secondary mx-2">Нет ответа</button>
    <button @click="callSuccess()" class="btn btn-success mx-2">Успешен</button>
  </div>

  <order :pId="orderId"></order>
  @@@
</div>
</template>

<script>
export default {  
  data(){
    return {
      slot:{default: this.$createElement('loader-icon'),},
      orderId:this.$route.params.id,
    }
  },  
  mounted(){
  },  
  methods:{  
    async callSuccess(){
      let l = this.$loading.show({},this.slot);
      let r = await axios.put('/order/status',{orderId:this.orderId,statusId:600})
        .then((r) => {
          this.redirectNext();
        })

      l.hide();
    },
    async redirectNext(){
      let l = this.$loading.show({},this.slot);
      let r = await axios.get('/json/orders',{
        params:{
            deliveryDate:{
              from:moment().format('YYYY-MM-DD'),
              to:moment().format('YYYY-MM-DD')
            },          
            status:800,
          }
        })
        .then((r)=>{
          window.location.replace("/call/order/"+Object.values(r.data.data)[0].id);
          return true;
        })    

      if(r) return;
      l.hide();     
    }    
  },
}
</script>

<style>

</style>