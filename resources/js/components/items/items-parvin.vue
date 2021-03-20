<template>
    <!-- List -->
  <div class="container-fluid" ref="orderList">
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th>Название</th>
          <th>Сумма</th>
          <th>Поставщики</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in items" :key="item.name">
          <td>{{item.name}}</td>
          <td>{{item.summ}}</td>
          <td v-if="item.product != undefined && item.product.suppliers != undefined && item.product.suppliers[0] != undefined">
            <span v-for='(supplier,i) in item.product.suppliers' :key='i'>
              {{supplier.name + ' '}}
            </span>            
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  data(){return{
    items:[],
  }},
  mounted(){
    this.getItems();
  },
  methods:{
    async getItems(){

      let r = await this.jugeAx('/json/items',{
        parvinBuild:1,
      });

      if(r) this.items = r;


    },
  }
}
</script>

<style>

</style>