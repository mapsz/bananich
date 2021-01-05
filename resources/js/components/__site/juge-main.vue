<template>
  <div :class="isX?'page-x':''">
    <site-header />
      <template functional>

        <slot/>

      </template>
    <site-footer />
  </div>
</template>

<script>
export default {
data(){return{
  isX:isX,
}},

}
</script>

<style>
  .page-x{
    background: #f3ebe8;  
    font-family: Open Sans;
  }
  .page-x .custom-radio:checked + label:before {
      background-color: #8AC2A7;
      border: 1px solid #8AC2A7;
  }
  .page-x .btn-yellow{
    background: #8AC2A7;
    border-color: #8AC2A7;
  }
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
  .announce-block{
    font-size: 16px;
    border-left: 5px #8AC2A7 solid;
    padding-left: 16px;
  }
  .info-icon{
    display: inline-block;
    width: 30px;
    height: 30px;
    border-radius: 15px;
    background-color: #EB5757;    
  }
  .info-icon::after{    
    display: block;
    content: "i";
    font-weight: 600;
    font-size: 21px;
    margin-left: 12px;
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
  }
</style>