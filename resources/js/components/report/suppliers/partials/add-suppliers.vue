<template>
<div class="add-suppliers">
  <!-- Title -->
  <h3 class="d-inline-block">Добавить поставщика</h3>
  <!-- Close -->
  <button @click="$emit('close')" class="btn btn-danger" style="float: right;">X</button>

  <!-- Form -->
  <div class="add-suppliers-form">
    <juge-form :inputs="inputs" :errors="errors" @submit="add"></juge-form>
  </div>

</div>
</template>

<script>
export default {
data(){return{
  inputs:[
    {
      name:'name',
      caption:'Название',
      required:true,
    },
    {
      name:'address',
      caption:'Адрес',
    },
    {
      name:'comment',
      caption:'Комментарий',
    },
    {
      multi:true,
      caption:'Контактное лицо',
      inputs:[
        {
          name:'contact_name',
          caption:'Имя',        
        },
        {
          name:'contact_phone',
          caption:'Номер телефона',
        },
        {
          name:'contact_more',
          caption:'Дополнительно',        
        },
      ]
    }
  ],
  errors:[],
}},
mounted(){
  //
},
methods:{
  async add(data){
    this.errors = [];
    let r = await this.jugeAx('/put/supplier',data,'put');
    if(!r){
      if(this.lastResponse.status != undefined){
        if(this.lastResponse.status == 422){
          this.errors = this.lastResponse.data.errors.name;
        }
      }      
    };
    
    this.$emit('add-success',r);
  } 
},
}
</script>

<style scoped>
  .add-suppliers{
    background-color: #f3fff3;
    border: 1px solid limegreen;
    border-radius: 7px;
    padding: 10px;    
  }
</style>