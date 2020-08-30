<template>
<div>
  <gruzka-navbar></gruzka-navbar>
  <div class="container">    
    <div>
      <h4 style="display: inline-block;">Продукт №{{product.id}}</h4>
      <font-awesome-icon 
        @click="edit = !edit"
        class="mr-3" 
        icon="edit" 
        color="#ff8d00"
        style="cursor:pointer;font-size: 20px;float: right;"
      />   
    </div> 
    <div class="product-wrapper row">
      <!-- Images -->
      <div class="col-12 col-md-5	p-0">
        <!-- Images -->
        <div class="mt-2">
          <image-product v-model="product.images" :p-edit="edit"></image-product>
        </div>
      </div>
      <!-- Primary info -->
      <div class="col-12 col-md-7 p-0">
        <!-- Name -->
        <div class="mt-2 mt-md-4 col-12">
          <name-product v-model="product.name" :p-edit="edit" :p-value="product.name"></name-product>
        </div>
        <!-- From (Country) -->
        <div class="mt-1 mt-md-3 mx-3">
          <from-product v-model="product.from" :p-edit="edit"></from-product>
        </div>
        <!-- Price/Unit -->
        <div 
          :class="(edit ? '' : 'd-flex align-items-end product-prices-units') + ' mt-1 mt-md-3 px-3 w-100'"
        >
          <!-- Price -->
          <div class="product-price-unit">
            <price-product v-model="product.price" :p-edit="edit" :p-value="product.price"></price-product>
          </div>
          <!-- Unit -->
          <div :class="edit ? '' : 'ml-3'" class="product-price-unit">
            <unit-product v-model="unit" :p-edit="edit" :p-value="{unit:product.unit,unit_sys:product.unit_sys}"></unit-product>
          </div>
        </div>
        <!-- To Cart -->
        <!-- <div class="to-cart mt-1 mt-md-3 mx-3 position-relative">
          <div v-if="edit" class="to-cart-disable"></div>
          <add-to-cart class="mx-3 my-1"></add-to-cart>
        </div>         -->
      </div>
      <!-- БЖУ -->
      
      <!-- Additional info -->
      <div class="col-12 p-0">
        <!-- Description -->
        <div class="mt-3 product-descriptions">
          <description-product v-model="product.description" :p-edit="edit"></description-product>
        </div> 
      </div>
      <!-- Admin tools -->
      <div class="col-12 product-for-admin mb-2">
        <div>
          <h5 style="display: inline-block;">Admin</h5>
          <font-awesome-icon 
            @click="edit = !edit"
            class="mr-3" 
            icon="edit" 
            color="#ff8d00"
            style="cursor:pointer;font-size: 20px;float: right;"
          />   
        </div> 
        <gruzka-priority-product v-model="product.gruzka_priority" :p-edit="edit" :p-value="product.gruzka_priority"></gruzka-priority-product>
        <strews-product v-model="product.strews" :p-edit="edit" :p-value="product.strews"></strews-product>
      </div>
      <!-- Actions -->
      <div v-if="edit" class="product-action col-12 p-0 m-2">
        <!-- Errors -->
        <div v-if="errors.length > 0" class="product-errors mb-2">
          <ul class="m-0">
            <li v-for="e in errors" :key="e">
              {{e}}
            </li>
          </ul>
        </div>   
        <!-- Buttons -->
        <div class="product-buttons">
          <!-- Save -->
          <button @click="doEdit()" class="btn btn-success">Сохранить</button>
        </div>
      </div>      
    </div>


  </div>
</div>
</template>

<script>

export default {
  data(){return{
    edit:false,
    unit:{},
    product:{},
    errorsResponse:{},
  }},
  mounted(){
    //Add
    if(this.$route.name == "product-add"){
      this.add = true;
    }
    //Get
    if(this.$route.params.id > 0){
      this.get(this.$route.params.id);
    }
  },
  watch: {
    unit: {
      handler: function (val, oldVal) {
        this.product.unit_sys = val.sys;
        this.product.unit = val.view;
      },
      deep: true
    }
  },
  computed:{
    errors: function(){
      let out = [];
      //Formate array
      $.each( this.errorsResponse, ( k, v ) => {
        out.push(v[0]);
      });
      //Remove .data
      $.each( out, ( k, v ) => {
        out[k] = v.replace('data.','');
      });   
      //Translate
      $.each( out, ( k, v ) => {      
        out[k] = v.replace('name','Название');
        out[k] = out[k].replace('price','Цена');
        out[k] = out[k].replace('unit.sys','Единица </>');
      });          
      return out;
    }
  },
  methods:{
    async doEdit(){
      //edit
      let r = await this.jugeAx('/product',{
        data:this.product,
      },'post');   
      //Errors
      if(!r){
        let e = this.jugeAxResponse();
        if(e.status == 422){          
          this.errorsResponse = e.data.errors;
        }
        return false;
      }

      location.reload();
      return true;
    },
    async get(id){
      let r = await this.jugeAx('/json/products',{
        id:id,
      });
      this.product = r;
    }
  },
}
</script>

<style scoped> 
  /* Price Unit */
  @media only screen and (max-width: 991px) {
    .product-prices-units{
      justify-content: space-between;
    }    
  }
  /* To cart */
  .to-cart{
    border: 1px;
    border-color: gray;
    border-style: dotted;
    border-left: 0;
    border-right: 0;
  }
  .to-cart-disable{
    position: absolute;    
    width:100%;
    height:100%;
    background-color:#00000080;
    z-index: 999;    
    cursor: not-allowed;
  }
  /* Error */
  .product-errors.mb-2 {
    border: 1px solid red;
    border-radius: 5px;
    background-color: #ffe4e4;
  }
  .product-for-admin{
    border: 1px solid orange;
    border-radius: 7px;
    background-color: #ffffe1;
    padding: 10px;  
  }
</style>