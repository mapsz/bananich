<template>
<div>
  <juge-main>
    <div class="container my-5">
      <div class="row">
        <div class="x-header my-3">Оформление заказа</div>
        
        <!-- Inputs -->
        <div v-if="load" class="col-12 col-lg-8">

          <checkout-contact class="checkout-div " :design="'x'" v-model="data.contacts"  :no-cache="true"/>

          <div class="row checkout-div">
            <!-- <checkout-container v-model="data.container"  :no-cache="true"/> -->
            <checkout-paymethod v-model="data.pay_method" :no-cache="true"/>
          </div>
          
          <checkout-comment class="checkout-div" v-model="data.comment" :no-cache="true"/>

        </div>

        <div class="col-12 col-lg-4">
          <shared-order-numbers />
        </div>

        <!-- Errors -->
        <div class="mb-3"><div v-for='(errorz,z) in errors' :key='z+"d"'><span v-for='(error,j) in errorz' :key='j' style="color:tomato;">❗{{error}}</span></div></div>      

        <!-- Big Action -->
        <div class="d-flex justify-content-center">
          <button @click="edit()" class="x-btn">
            Оформить
          </button>
        </div>

      </div>


    </div>
  </juge-main>
</div>
</template>

<script>
import {mapGetters,mapActions} from 'vuex';
export default {
  data(){return{    
    data:{contacts:{}},
    // order:false,
    load:false,
    errors:[],
  }},
  computed:{
    ...mapGetters({
      cart:'cart/getCart',
      order:'sharedOrder/getOrder',
    }),
    link(){
      if(this.$route == undefined || this.$route.params == undefined || this.$route.params.order_link == undefined) return false;    
      return this.$route.params.order_link;
    },
  },
  watch:{
    order: function (val, oldVal) {
      if(!val) return false;
      if(val.name != undefined) this.data.contacts.name = val.name;
      if(val.email != undefined) this.data.contacts.email = val.email;
      if(val.phone != undefined) this.data.contacts.phone = val.phone;
      if(val.comment != undefined) this.data.comment = val.comment;
      if(val.pay_method != undefined) this.data.pay_method = val.pay_method;

      this.load = true;
    },
  },
  async mounted() {
    this.fetchOrder(this.link);
  },
  methods:{
    ...mapActions({
      'fetchOrder':'sharedOrder/fetchOrder',
    }),  
    async get(){
      let r = await ax.fetch('/shared/order/order',{'link':this.link});
      if(r) this.order = r;
    },
    async edit(){    
      //Refresh errors
      this.errors = [];
      let data = this.data;
      data.id = this.order.id;
      let r = await ax.fetch('/order/customer',this.data,'post');

      //Catch errors
      if(!r){if(ax.lastResponse.status == 422){this.errors = ax.lastResponse.data.errors;return;}}

      //Success
      if(r){window.location.href = '/shared/order/'+this.link};

    console.log(r);
    }
  }
}
</script>

<style scoped>
  .checkout-div{
    margin-bottom: 30px;
    padding-bottom: 30px;
  }
  .checkout-div:last-child{
    margin-bottom: 0px;
    padding-bottom: 0px;
  }

</style>