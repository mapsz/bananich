<template>
<div>
  <!-- Action -->
  <span @click="open()" style="cursor: pointer;">✏️</span>
  
  <!-- Modal -->
  <div v-if="edit" class="modal" :id="'add-purchase-price-modal-'+this.data.id" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Изменить цену закупки</h5>
            <button @click="edit=false" type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <input v-model="price" type="text">
        </div>
        <div class="modal-footer">
          <button @click="save()" type="button" class="btn btn-primary">Save</button>
          <button @click="edit=false" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>         
        </div>
      </div>
    </div>
  </div>
  
</div>
</template>

<script>
export default {
  props: ['data'],
  data(){return{
    edit:false,
    price:null,
  }},
  methods:{
    async open(){
      this.edit = true;
      setTimeout(() => $('#add-purchase-price-modal-'+this.data.id).modal('show'), 100);
      
      // this.getProductCount(this.product.id);
    },
    async save(){
      let data = {};
      data.product_id = this.data.id;
      data.price = this.price;

      let r = await this.jugeAx('/put/purchase/prices',data,'put');
      this.$emit('success');
      $('#add-purchase-price-modal-'+this.data.id).modal('hide');
      setTimeout(() => {this.edit = true;}, 100);

    }
  }
}
</script>

<style>

</style>