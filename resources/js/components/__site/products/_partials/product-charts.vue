<template>
  <!-- КБЖУ -->
  <div class="col-md-12 order-2 order-md-1 mt-4 mt-sm-0">                  
    <div class="calories">
      <div class="calories-header d-flex justify-content-between mb-4">
        <span>БЖУ на 100гр продукта</span>
        <span>Дневная норма<span style="color:orange">??</span><!-- todo @@@--></span>
      </div>

      <div class="row">
        <!-- Chart -->
        <div class="col-4 calories-range">          
            
                   
          <div class="pfc-chart" style="position: relative; z-index:2">
            <canvas id="pfc-chart" ></canvas>
          </div>

          
          <div class="calories-range-text" style="z-index:1">{{product.calories}} <span>ккал</span></div>   

        </div>


        <!-- БЖУ -->
        <div class="col-8 calories-scale">
          <!-- Углеводы -->
          <div class="d-flex justify-content-between align-items-center">
            <div class="product-line">
              <div class="product-line-header d-flex justify-content-between mb-1">
                <span>Углеводы</span>
                <span class="bold">{{product.carbohydrates}}г</span>
              </div>
              <div class="calories-scale-line"><div class="calories-scale-position yellow" :style="'width: '+product.carbohydrates+'%;'"></div></div>
            </div>
            <div class="product-percent">40%<span style="color:orange">??</span><!-- todo @@@--></div>
          </div>
          <!-- Жиры -->
          <div class="d-flex justify-content-between align-items-center">
            <div class="product-line">
              <div class="product-line-header d-flex justify-content-between mb-1">
                <span>Жиры</span>
                <span class="bold">{{product.fats}}г</span>
              </div>
              <div class="calories-scale-line"><div class="calories-scale-position green" :style="'width: '+product.fats+'%;'"></div></div>
            </div>
            <div class="product-percent">70%<span style="color:orange">??</span><!-- todo @@@--></div>
          </div>
          <!-- Белки -->
          <div class="d-flex justify-content-between align-items-center">
            <div class="product-line">
              <div class="product-line-header d-flex justify-content-between mb-1">
                <span>Белки</span>
                <span class="bold">{{product.proteins}}г</span>
              </div>
              <div class="calories-scale-line"><div class="calories-scale-position blue" :style="'width: '+product.proteins+'%;'"></div></div>
            </div>
            <div class="product-percent">40%<span style="color:orange">??</span><!-- todo @@@--></div>
          </div>
        </div>                  
      </div>
    </div>
  </div>
</template>

<script>

import Chart from 'chart.js'
export default {
props: ['product'],
watch: {
  product: function(){
    if(this.product.calories != undefined);
    this.setChats();
  },
},

mounted(){  

},
methods:{
  setChats(){
    var ctx = document.getElementById('pfc-chart');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
          data: {
            labels: [
              'Углеводы',
              'Жиры',
              'Белки'
            ],
            datasets: [{
              borderWidth:5,
              data: [this.product.carbohydrates, this.product.fats, this.product.proteins],
              label: 'БЖУ',
              backgroundColor: [
                '#ffb800',
                '#6fcf97',
                '#2f80ed'
              ],
              hoverOffset: 4
            }]
          },
        options: {       
          cutoutPercentage:75,     
          aspectRatio:1,  
          legend: {display: false}, //Hide labels
        }
    });   
  }
},
}
</script>

<style>

</style>