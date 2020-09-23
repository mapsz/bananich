<template> 
<div class="col-lg-5">
  <div class="checkout-checkout">
    <!-- Sitebar -->
      <div v-scroll="handleScroll" class="cart-sitebar" style="margin-bottom:20px">
        <buy-info />
        <!-- Aggrees -->
        <checkout-agreements />
        <!-- Errors -->
        <ul>
          <template v-for='error in errors'>
            <li v-for='err in error' :key="err" style="color:tomato">
              {{err}}
            </li>
          </template>
        </ul>            
        <button @click="$emit('do-order')" class="btn-yellow btn-thick">Оформить заказ</button>
      </div>
    <!-- Sitebar -->
  </div>
</div>
</template>

<script>
export default {
props: ['errors'],
methods:{
  handleScroll: function (evt, el) {
    let position = window.scrollY;
    let windowSize = document.getElementById('app').clientHeight;
    let footerSize = document.getElementsByClassName('footer')[0].clientHeight;
    let topStart = windowSize - document.getElementsByClassName('checkout-data')[0].clientHeight - footerSize;    
    let top = topStart - position;

    let bottom = (windowSize - (position + footerSize) - document.body.offsetHeight) - ((windowSize - (position + footerSize) - document.body.offsetHeight) * 2);
    // let bottom = (windowSize - footerSize) - position + document.body.offsetHeight;

    if(top < 0){
      $('.checkout-checkout').css('top','20px');
      $('.checkout-checkout').css('position','fixed');
    }else{
      $('.checkout-checkout').css('position','inherit');
    }

    if(bottom > 0){
      $('.checkout-checkout').css('top','inherit');
      $('.checkout-checkout').css('bottom',bottom);
    }else{
      if(top > 0){
        $('.checkout-checkout').css('top','20px');
      }
      $('.checkout-checkout').css('bottom','inherit');
    }
      
    
  }
},
}
</script>

<style scoped>

@media screen and (max-width: 991px) { 
  .checkout-checkout{
    position: inherit !important;
    bottom: inherit !important;
    top: inherit !important;
    width: inherit !important;
  }
}

.checkout-checkout{
  position: fixed;
  width: 400px;
}


</style>