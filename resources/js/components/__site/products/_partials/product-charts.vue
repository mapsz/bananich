<template>
  <!-- КБЖУ -->
  <div v-show="product.calories > 0" class="col-md-12 order-2 order-md-1 mt-4 mt-sm-0">                  
    <div class="calories">
      <div class="row">
        <!-- PFCC -->
        <div class="col-12 col-lg-5">    
          <div>
            <div style="display: flex; text-align: center;justify-content: center;"><span><b>БЖУ на 100гр продукта</b></span></div>    
            <div class="pfcc-block my-3">
              <div style="width:100%; position: relative; z-index: 2;">
                <canvas id="pfc-chart"></canvas>
              </div> 
              <div class="calories-range-text" style="z-index:1">{{product.calories}} <span>ккал</span></div>   
            </div>
          </div>
        </div>

        <!-- БЖУ -->
        <div class="col-12 col-lg-7 calories-scale">
          <div style="height: 100%;">
            <div style="display: flex; justify-content: center;">
              <span 
                data-toggle="tooltip" 
                :title="'Углеводы:'+settings.day_norm_carbs+' | Жиры: '+settings.day_norm_fats+' | Белки:'+settings.day_norm_proteins"
              >
                <b>Дневная норма</b>
              </span>
            </div>        
            <!-- lines -->  
            <div style="height: 100%;display: flex;flex-direction: column;justify-content: center;">              
              <div v-for='(line,i) in lines' :key='i' class="d-flex justify-content-center align-items-center">
                <div class="product-line" style="margin-right: 20px;">
                  <div class="product-line-header d-flex justify-content-between mb-1">
                    <span>{{line.caption}}</span>
                    <span class="bold">{{line.value}}г</span>
                  </div>
                  <div class="calories-scale-line" style="width:200px"><div class="calories-scale-position" :class="line.color" :style="'width: '+line.percent+'%;'"></div></div>
                </div>
                <div class="product-percent">{{line.percent}}%</div>
              </div>
            </div>
          </div>
        </div> 
      </div>
    </div>
  </div>
</template>

<script>

import Chart from 'chart.js'
import {mapGetters, mapActions} from 'vuex';
export default {
watch: {
  product: function(){
    if(this.product.calories != undefined && this.product.calories > 0) this.setChats();      
  },
},
computed:{
  ...mapGetters({settings:'settings/beautyGet',product:'product/getOne'}),
  lines: function(){
    if(this.product.calories == undefined || !(this.product.calories > 0)) return [];
    if(this.settings.day_norm_carbs == undefined) return [];

    return [
      {
        caption:'Углеводы',
        color:'yellow',
        value:this.product.carbohydrates,
        percent:Math.round(this.product.carbohydrates / this.settings.day_norm_carbs * 100),
      },
      {
        caption:'Жиры',
        color:'green',
        value:this.product.fats,
        percent:Math.round(this.product.fats / this.settings.day_norm_fats * 100),
      },
      {
        caption:'Белки',
        color:'blue',
        value:this.product.proteins,
        percent:Math.round(this.product.proteins / this.settings.day_norm_proteins * 100),
      },
    ];
  }
},
mounted(){  
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  });
  this.getSettings();
},
methods:{
   ...mapActions({
      'getSettings':'settings/fetch',
    }),  
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
              borderWidth:3,
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

<style scoped>
  .pfcc-block{
    width: 180px;    
    height: 180px;
    display: flex;
    position: relative;
    margin: auto;
  }
</style>