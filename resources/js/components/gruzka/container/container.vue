<template>
<div>
  <!-- Navbar -->
  <gruzka-navbar></gruzka-navbar> 

  <!-- Put -->
  <div class="row m-2">
    <label class="align-self-center" for="name" >Название</label>
    <input v-model="сontainerName" class="mx-2" type="text"  id="name">
    <button @click="putContainer" class="btn btn-success">Сохранить</button>
  </div>

  <!-- List -->
  <div class="container-fluid" ref="orderList">
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Название</th>
          <th scope="col">
            <font-awesome-icon icon="edit" />
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="container in containers" :key="container.id">
          <td>{{container.id}}</td>
          <td>{{container.name}}</td>
          <td>
            <button class="btn btn-warning m-3">
              <font-awesome-icon  icon="edit"/>
            </button>
            <button @click="deleteContainer(container.id)" class="btn btn-danger m-3">
              <font-awesome-icon icon="trash-alt"/>
            </button>  
          </td>
        </tr>
      </tbody>
    </table>
  </div>


</div>
</template>

<script>
export default {
  data(){
    return {
      сontainerName:"",
      containers:[],
    }
  },  
  mounted(){
    this.getContainers();
  },  
  methods:{
    async putContainer(){
      let r = await this.jugeAx('/container',{name:this.сontainerName},'put');
      if(!r) return;
      this.getContainers();
    },
    async getContainers(){
      let r = await this.jugeAx('/json/containers');
      if(!r) return;
      this.containers = r;
    },
    async deleteContainer(id){
      let r = await this.jugeAx('/container',{id:id},'delete');
      if(!r) return;
      this.getContainers();
    }
  }
}
</script>

<style>

</style>