<template>
  <div>

    <!-- Name / Status -->
    <div class="d-flex justify-content-between">
      <!-- Name -->
      <span><b>{{item.name}}</b></span>
      <!-- Status -->
      <span 
        v-if="item.statuses[0] != undefined"
        :style="
          item.statuses[0].id == 100 ? 'color:red' : '' +
          item.statuses[0].id == 200 ? 'color:#d56d00' : '' +
          item.statuses[0].id == 300 ? 'color:green' : ''                
        "
      >
        {{item.statuses[0].name}}
      </span>      
    </div>
    <!-- Price per single -->
    <div class="d-flex justify-content-between">
      <!-- Price 1 -->      
      <span class="mr-2">₽{{item.price_one}} за 1(кг\шт)</span>
      <!-- Price unit -->      
      <span class="mr-2">₽{{item.price_unit}} за единицу</span>
    </div>
    <!-- Discounts -->
    <div v-if="item.discount != undefined" class="d-flex justify-content-between">
      <span>
      <!-- Title -->
        <span style="width: 120px;display: inline-block;">Акция:</span>
        <!-- Quantity -->
        <span>x{{item.discount.quantity}} максимально</span>  
      </span>
      <!-- Price -->
      <span>₽{{item.discount.discount_price}} за единицу</span>              
    </div>
    <!-- Pre -->
    <div class="d-flex  justify-content-between">      
      <span>
        <!-- Title -->
        <span style="width: 120px;display: inline-block;">Предварительно:</span>
        <!-- Quantity -->
        <span>x{{item.quantity}} ({{item.quantity * item.gram_sys}})</span>
      </span>      
      <span>
        <!-- Price -->
        <span v-if="item.price != item.price_final" class="mr-2">₽{{item.price}}</span>
        <!-- Price Final -->
        <span><b>₽{{item.price_final}}</b></span>
      </span>
    </div>    
    <!-- Resoult -->
    <div v-if="item.quantity_result != undefined && item.quantity_result > 0" class="d-flex  justify-content-between">      
      <span>
        <!-- Title -->
        <span style="width: 120px;display: inline-block;">Погружено:</span>
        <!-- Quantity -->
        <span>x{{item.quantity_unit_result}} ({{item.quantity_result}})</span>
      </span>      
      <span>
        <!-- Price -->
        <span v-if="item.price_result != item.price_final_result" class="mr-2">₽{{item.price_result}}</span>
        <!-- Price Final -->
        <span><b>₽{{item.price_final_result}}</b></span>
      </span>
    </div>

    <div v-if="0">
      <div class="d-flex justify-content-between">
        <div style="flex:5">
          <!-- Name -->
          <div>
            <b>{{item.name}}</b> 
          </div>                    
          <div class="d-flex justify-content-between">
            <span style="color:gray">
              <!-- Price -->
              ₽{{parseInt(item.price) / item.quantity}} 
              <!-- Quantity -->
              x{{item.quantity}}
            </span>
            <!-- Statuses -->
            <span 
              v-if="item.statuses[0] != undefined"
              :style="
                item.statuses[0].id == 100 ? 'color:red' : '' +
                item.statuses[0].id == 200 ? 'color:#d56d00' : '' +
                item.statuses[0].id == 300 ? 'color:green' : ''                
              "
            >
              {{item.statuses[0].name}}
              <!-- Quantity Result -->
              <span v-if="item.statuses[0].id == 300">
                {{item.quantity_result}}
              </span>
            </span>
          </div>
        </div>     
        <!-- Total Price  -->
        <div class="m-2 align-self-center">
          ₽{{parseInt(item.price)}}
        </div>             
      </div>                                     
      <!-- Comment -->
      <div>
        <span><i>{{item.comment}}</i></span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['item'],

}
</script>

<style>

</style>