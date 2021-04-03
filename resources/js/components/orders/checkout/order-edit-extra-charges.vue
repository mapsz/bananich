<template>
<div>

  <!-- List -->
  <div class="order-edit-extra-charges-list">
    <template v-for="(extra, i) in extras"  >
      <!-- Label -->
      <span :key="'label-'+extra.name+i"  style="display: flex;align-self: center;">
        {{extra.name}}
      </span>
      <!-- Input -->
      <span :key="'input-'+extra.name+i"  style="display: flex;align-self: center;">
        {{extra.value}}
      </span>
      <!-- Description -->
      <span :key="'description-'+extra.name+i" style="display: flex;align-self: center;">
        <button @click="doRemove(extra.id)" class="btn btn-danger btn-sm">🗑️</button> 
      </span>
    </template>
  </div>

  <!-- Add -->
  <form action="" @submit.prevent="doAdd()" class="pt-3">
    <div class="row">
      <div class="col-4">
        <div class="form-group">
          <label for="order-edit-extra-charges-add-name">Название</label> 
          <input v-model="add.name" type="text" id="order-edit-extra-charges-add-name" class="form-control">
        </div>
      </div>
      <div class="col-4">
        <div class="form-group">
          <label for="order-edit-extra-charges-add-value">Значение</label> 
          <input v-model="add.value" type="number" id="order-edit-extra-charges-add-value" class="form-control">
        </div>
      </div>
      <div class="col-4" style="display: flex;align-self: center;">
        <div>
          <button type="submit" class="btn btn-success btn-sm">🌱🌱</button>
        </div>        
      </div>
    </div>
  </form>  

</div>
</template>

<script>
import {mapGetters,mapActions} from 'vuex';
export default {
data(){return{
add:{
  name:"",
  value:"",
}
}},
computed:{
  ...mapGetters({order:'order/getOne'}),
  extras:function(){
    if(this.order == undefined || this.order.extra_charges == undefined || this.order.extra_charges[0] == undefined) return [];
     return this.order.extra_charges;
  }
},
methods:{
  ...mapActions({fetch:'order/fetchOne'}),
  async doAdd(){
    let data;
    data = this.add;
    data.orderId = this.order.id;
    let r = await ax.fetch('/order/extra/charge', data, 'put');
    if(r) this.fetch();    
  },
  async doRemove(id){
    let r = await ax.fetch('/order/extra/charge', {id}, 'delete');
    if(r) this.fetch();    
  },
},

}
</script>

<style scoped>

.order-edit-extra-charges-list{
  display: grid;
  grid-template-columns: auto auto 1fr;
  grid-gap: 10px;
  border-bottom: 1px dashed gray;
  padding-bottom: 10px;
}

</style>