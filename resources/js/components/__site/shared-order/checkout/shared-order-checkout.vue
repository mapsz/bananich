<template>
<div>
  <juge-main>
    <div class="container my-5">
      <div class="row">
        <div class="x-header my-3">Оформление заказа</div>
        
        <!-- Inputs -->
        <div v-if="load" class="col-12 col-lg-8">

          <div v-if="sOrder && order" class="mb-4">
            <h5><b>Адрес</b></h5>
            <!-- Radio -->
            <div v-if="isAdmin">
              <div style="color:#595959">
                {{sOrder.short_address}}
              </div>
              <div v-if="editable">
                <button @click="goToEdit()" class="edit" style="font-size: 16px;">изменить</button>
              </div>
            </div>
            <div v-else class="form-group mt-3">
              <div  class="form-radio">
                <input v-model="personalAddress" class="custom-radio" type="radio" id="personalAddressNah" :value="0" name="personalAddress">
                <label :for="'personalAddressNah'">{{sOrder.short_address}}</label>
              </div>
              <div  class="form-radio">
                <input v-model="personalAddress" class="custom-radio" type="radio" id="personalAddress" :value="1" name="personalAddress">
                <label :for="'personalAddress'">Донести мою часть закупки до двери (+50р)</label>
              </div>
              <checkout-address v-if="personalAddress" class="checkout-div " :design="'x'" v-model="data.address"  :no-cache="true"/>
            </div>
          </div>
          <!-- <checkout-address class="checkout-div " :design="'x'" v-model="data.address"  :no-cache="true"/> -->

          <checkout-contact class="checkout-div " :design="'x'" v-model="data.contacts"  :no-cache="true"/>

          <div class="row checkout-div">
            <checkout-paymethod v-model="payMethod" :no-cache="true"/>            
            <!-- <checkout-container v-model="data.container"  :no-cache="true"/> -->
          </div>
          
          <checkout-confirm class="checkout-div" v-model="data.confirm" :no-cache="true"/>

          <checkout-comment class="checkout-div" v-model="data.comment" :no-cache="true"/>




        </div>

        <!-- Info -->
        <div class="col-12 col-lg-4">
          <shared-order-numbers />
          <span v-if="confirmable && sOrder">
            Вы можете вносить изменения в корзину до {{moment(sOrder.order_close).locale("ru").format('LLL')}}
          </span>
          <!-- <div v-if="changes" style="color:limegreen;font-weight: 600;">
            Изменения внесены
          </div> -->
          <!-- Errors -->
          <div class="col-12 mb-3"><div v-for='(errorz,z) in errors' :key='z+"d"'><span v-for='(error,j) in errorz' :key='j' style="color:tomato;">❗{{error}}</span></div></div>      

          <shared-order-confirm class="mt-3"  @confirm="doConfirm()" v-if="confirmable && confirm != 1"/>
          <!-- <div v-if="confirmable && confirm" class="d-flex justify-content-center mt-3">
            <button @click="edit()" class="x-btn">
              {{'Внести изменения'}}
            </button>
          </div> -->
        </div>

        <!-- {{payMethod}}
        {{data.payMethod}} -->

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
    payMethod:false,
    moment:moment,
    personalAddress:0,
    // order:false,
    load:false,
    errors:[],
    changes:false,
  }},
  computed:{
    ...mapGetters({
      cart:'cart/getCart',
      order:'sharedOrder/getOrder',      
      sOrder:'sharedOrder/get',
      user:       'user/get',
    }),
    editable(){
      if(!this.sOrder || this.sOrder.editable == undefined) return false;

      return this.sOrder.editable
    },
    isAdmin(){
      if(this.user == undefined && !this.user) return false;
      if(!this.sOrder || this.sOrder.owner_id == undefined || this.sOrder.owner_id < 1) return false;
      if(this.user.id == this.sOrder.owner_id) return true;
      return false;
    },
    link(){
      if(this.$route == undefined || this.$route.params == undefined || this.$route.params.order_link == undefined) return false;    
      return this.$route.params.order_link;
    },
    confirmable(){
      if(this.order == undefined || this.order.confirmable == undefined) return false;
      return this.order.confirmable;
    },
    confirm(){
      if(this.order == undefined || this.order.x_confirm == undefined) return false;
      return this.order.x_confirm;    
    },
    isCartreferrer(){
      return document.referrer.includes('/cart');
    },
  },
  watch:{
    order: function (val, oldVal) {
      console.log(this.load);
      console.log(val);
      if(!val) return false;
      if(val.confirm != undefined) this.data.confirm = val.confirm;
      if(val.name != undefined) this.data.contacts.name = val.name;
      if(val.email != undefined) this.data.contacts.email = val.email;
      if(val.phone != undefined) this.data.contacts.phone = val.phone;
      if(val.comment != undefined) this.data.comment = val.comment;
      if(val.pay_method != undefined) this.data.pay_method = val.pay_method;
      if(val.pay_method != undefined) this.payMethod = val.pay_method;
      
      this.load = true;
    },
    personalAddress: function (val, oldVal) {
      if(this.personalAddress == 0) this.data.address = null;
    },
    sOrder: function (val, oldVal) { //Redirect if closed
      if(!this.sOrder || this.sOrder.status_id == undefined) return false;
      if(this.sOrder.status_id == 100 || this.sOrder.status_id == 200) return false;
      location.href = '/shared/order/' + this.sOrder.link;
    },
    payMethod: function (val, oldVal) { 
      this.data.pay_method = val;
      this.edit();
    },
    data: {
      deep: true,
      handler(){
        this.edit();
      }
    }
  },
  async mounted() {
    window.location.href = '/shared/order/'+this.link;

    await this.fetchOrder(this.link);

    await this.filter({'link':this.link});
    await this.filter({'single':true});
    await this.fetch();
  },
  methods:{
    ...mapActions({
      'filter':'sharedOrder/addFilter',
      'fetchOrder':'sharedOrder/fetchOrder',
      'fetch':'sharedOrder/fetchData',
    }),  
    async get(){
      // let r = await ax.fetch('/shared/order/order',{'link':this.link});
      // if(r) this.order = r;
    },
    async edit(){
      //Refresh errors
      this.errors = [];
      let data = this.data;
      data.id = this.order.id;
      data.personalAddress = this.personalAddress;
      let r = await ax.fetch('/order/customer',this.data,'post');

      //Catch errors
      if(!r){if(ax.lastResponse.status == 422){this.errors = ax.lastResponse.data.errors;return;}}

      //Success
      this.changes = true;
      
      this.fetchOrder(this.link);
    },
    goToEdit(){
      if(!this.link) return;
      location.href = '/shared/order/edit/' +this.link;
    },
    async doConfirm(){
      window.location.href = '/shared/order/'+this.link;
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