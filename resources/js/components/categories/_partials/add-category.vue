<template>
<div class="category-add">
  <h3 class="d-inline-block">Добавить категорию</h3>


  <!-- Form -->
  <div >
    <juge-form :inputs="inputs" :errors="errors" @submit="put"></juge-form>
  </div>

</div>
</template>

<script>
export default {
  data(){return{
    product:false,
    productCount:0,
    search:'',
    errors:[],
    inputs:[
      {
        name:'name',
        caption:'Название',
        required:true,
      },
      {
        name:'sort',
        caption:'Сортировка',
      },
    ]
  }},
  methods:{ 
    async put(data){
      let r = await ax.fetch('/category',data,'put');  


      location.reload();
      
    },    
  },
}
</script>

<style scoped>
  .category-add {
      background-color: #e4f9e4;
      padding: 20px;
      border: 1px solid green;
      border-radius: 7px;
      margin: 10px 0px;
  }
</style>