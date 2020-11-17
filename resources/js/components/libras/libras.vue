<template>
<div>  
  <!-- Navbars -->
  <gruzka-navbar></gruzka-navbar>  
  <product-navbar></product-navbar>

  <div class="container-fluid">
    <!-- Title -->
    <h1>Весы</h1>

    
    <div class="row">
      <!-- Add / Sort -->
      <div class="col-4">
        <!-- Update -->
        <div>
          <button @click="updateLibra()" class="btn btn-warning mb-3">Обновить весы</button>
        </div>
        <!-- Sort -->
        <div>
          <button @click="sortByName()" class="btn btn-info mb-3">Сортировать по алфавиту</button>
        </div>
        <!-- Add -->
        <libra-add />
      </div>
      
      <!-- Status -->
      <div class="col-5">
        <h4>Logs</h4>
        <libra-logs />
      </div>

      <!-- Last Update -->
      <div class="col-3">
        <h4>Последнее обновление</h4>
        <!-- Last libra update -->
        <div>
          <b>Весы vesi-side:</b>
          <!-- <div>{{moment.unix(lastProductUpdate).locale("ru").format('LLL')}}</div> -->
          <div>nan</div>
        </div>
        <div>
          <b>Весы server-side:</b>
          <div>{{moment.unix(lastLibraUpdate).locale("ru").format('LLL')}}</div>
        </div>
        <!-- Last product update -->
        <div>
          <b>Продукты:</b>
          <!-- <div>{{moment.unix(lastProductUpdate).locale("ru").format('LLL')}}</div> -->
          <div>nan</div>
        </div>
      </div>    
    </div>    

    <hr>

    <!-- List -->
    <juge-list :data="'libra'" :edit="true" :delete="true" />

  </div>



</div>
</template>

<script>
export default {
data(){return{
  lastProductUpdate:false,
  lastLibraUpdate:false,
  moment:moment,
}},
async mounted() {
  this.getLastProductUpdate();
  this.getLastLibraUpdate();
},
methods:{
  async updateLibra(){
    let r = await ax.fetch('/admin/libra/update',{},'post');
    location.reload();
  },
  async sortByName(){
    let r = await ax.fetch('/admin/libra/sort',{},'post');
    location.reload();
  },
  async getLastProductUpdate(){
    let r = await ax.fetch('/admin/libra/last/product/update');
    this.lastProductUpdate = r;
  },  
  async getLastLibraUpdate(){
    let r = await ax.fetch('/admin/libra/last/update');
    this.lastLibraUpdate = r;
  },  
},
}
</script>

<style>

</style>