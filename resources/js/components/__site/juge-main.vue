<template>
  <div :class="isX?'page-x':''">
    <site-header />
    <announces />
      <template functional>

        <slot/>

      </template>
    <site-footer />
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
data(){return{
  isX:isX,
}},
computed:{
  ...mapGetters({
    sOrders:    'sharedOrder/get',
    myOrder:    'sharedOrder/getMyOrder',
  }),  
  link(){
    if(this.$route == undefined || this.$route.params == undefined || this.$route.params.order_link == undefined) return false;    
    return this.$route.params.order_link;
  },
  sOrder(){
    if(this.sOrders == undefined || this.sOrders.length < 1) return false;
    return this.sOrders[0];
  },
  invite(){
    return Cookies.get('x_invite');
  }
},
async mounted() {

  //X busines
  if(isX){

    //Get my shared order
    await this.fetchMySharedOrder();

    //Shared order
    if(this.$route.name != undefined && this.$route.name == 'sharedOrder'){

      {//Get shared order
        await this.filter({'link':this.link});
        await this.get();
      }
      
      //Set invite
      if(
        this.myOrder.id == undefined && 
        this.sOrder.link != undefined &&
        this.sOrder.joinable
      ){
        Cookies.set('x_invite', this.sOrder.link);
      }

    }

    //Fist Time
    // if(!Cookies.get('x_not_first_time') && this.myOrder.id == undefined && this.$route.name != 'welcome'){
    //   window.location.href = '/welcome';
    // }else{
    //   Cookies.set('x_not_first_time');
    // }

  }

},
methods:{  
  ...mapActions({
    'filter':'sharedOrder/addFilter',
    'get':'sharedOrder/fetchData',
    'fetchMySharedOrder':'sharedOrder/byAuth',
  }),
},

}
</script>

<style>
  body{
    font-family: "Open Sans", "Roboto";
  }
  
  .page-x{
    background: #f3ebe8;      
  }
  .page-x .custom-radio + label:before {
    min-width: 17px;
  }
  .page-x .custom-radio:checked + label:before {
    background-color: #8AC2A7;
    border: 1px solid #8AC2A7;
    min-width: 17px;
  }
  .page-x .btn-yellow{
    background: #8AC2A7;
    border-color: #8AC2A7;
  }
  /* Checkbox */
  .page-x .checkbox:checked + .checkbox-box:after, .checkbox:not(:checked) + .checkbox-box:after {
    background-color: #8ac2a7 !important;
  }
  /* Anchor */
  .juge-anchor{
    position: absolute;
    top: -80px;
  }
  /* x-or */
  .x-or{
    display: grid;
    grid-template-columns: 1fr auto 1fr;
  }
  .x-or-or{
    align-self: center;
    margin: 0 5px;
    font-size: 12px;
    color: #757575;
  }
  /* x-button */
  .x-btn{    
    font-size: 16px;
    border-radius: 50px;
    background: #8AC2A7;
    height: 50px;
    padding: 0px 33px;
  }
  .x-btn-trans{
    background: #00000000;
    border: 1px solid rgba(0, 0, 0, 0.3);
  }
  .x-btn-red{
    background: #EB5757;
  }
  .x-btn-sm{
    height: 30px !important;
    padding: 0px 10px !important;
  }
  .announce-block{
    font-size: 16px;
    border-left: 5px #8AC2A7 solid;
    padding-left: 16px;
  }
  .info-icon{
    display: flex;
    justify-content: center;
    align-items: center;
    width: 30px;
    height: 30px;
    border-radius: 15px;
    background-color: #EB5757;
  }
  .info-icon::after{    
    content: "i";
    font-weight: 600;
    font-size: 21px;
  }
  .info-icon-confirm{
    background-color: #8ac2a7;
  }
  .info-icon-confirm::after{    
    content: "✓";
  }
  .info-icon-cancel{
    background-color: #ff000000;
    border: 1px solid black;
  }
  .info-icon-cancel::after{    
    content: "×";
  }

  .my-30{
    margin-top: 30px!important;
    margin-bottom: 30px!important;
  }
  .x-header{  
    font-size: 25px;
    font-weight: 600;
    line-height: 140%;
  }
  .edit{
    text-decoration-line: underline;    
    font-size: 15px;
  }
  .user-avatar{
    width: 75px;
    height: 75px;
    margin:0px 10px;
    background-color: #aba5a3;
    border-radius: 50px;
    display: flex;
    justify-content: center;
  }
  .user-avatar img{    
    max-width: 100%;
    max-height: 100%;
    border-radius: 50px;
  }
  .breadcrumb {
    background-color: #ffffff00 !important;
  }
  .breadcrumb a{
    color:black!important;
  }
  .breadcrumb-item.active {
    font-weight: 600;
  }
  .page-x .custom-checkbox:checked + label:before {
    background-color: #8ac2a7;
  }
  .shared-order-confirmed{
    display: flex;    
    line-height: 120%;
  }
  .shared-order-confirmed .shared-order-confirmed-check{
    font-size: 40px;    
    align-self: center;
    margin-right: 10px;
  }
  .shared-order-confirmed .shared-order-confirmed-success{
    color: #16c60c;
    font-weight: 600;
  }

  /* Desktop */
  @media screen and (min-width: 992px){
    .announce-block{
      max-width: 560px;
      font-size: 20px;
    }
    .x-btn{
      font-size: 18px;
      height: 60px;
      padding: 0px 33px;
    }
    .x-header{  
      max-width: 651px;
      font-size: 56px;
    }
    .mb-lg-100{
      margin-bottom:100px!important;
    }
    .edit{
      font-size: 20px;
    }
    .user-avatar{
      width:100px;
      height:100px;
      border-radius: 50px;
    } 
  }
</style>