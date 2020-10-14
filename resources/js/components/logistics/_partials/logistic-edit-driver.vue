<template>

  <div v-if="data.id > 0">
  
    <b-button v-b-modal="'logistic-edit-driver-modal-'+data.id" size="sm">✏️🚚</b-button>

    <b-modal :id="'logistic-edit-driver-modal-'+data.id" @show="getDrivers()" title="Замена водителя" hide-footer>
      <div class="row">
        <!-- Change Driver -->
        <div class="col-5">
          <!-- Prev Driver -->
          <div class="mb-2">
            Дата: {{data.date}} 
            <div>
              <b>{{data.driver_id}}</b> 
              <span v-if="data.driver">{{data.driver.name}}</span>  
            </div>
          </div>

          <!-- Text -->
          <div class="mb-2">⬇️ Заменить на ⬇️</div> 

          <!-- Input -->
          <div class="mb-2">
            id: <input v-model="toChange" type="text">            
          </div> 
          
          <!-- Change button -->
          <div>
            <b-button @click="changeDriver()" size="sm" variant="warning">Заменить</b-button>
          </div>

          <!-- Errors -->
          <span v-if="errors" style="color:red">{{errors}}</span>          


        </div>
        <!-- Drivers List -->
        <div class="col-7">
          <div>Список Водителей:</div> 
          <b-button v-if="!drivers" @click="getDrivers()" class="ml-2 mt-3" size="sm" variant="info">загрузить</b-button>

          <ul class="mt-2" v-if="drivers">
            <li v-for='(driver,i) in drivers' :key='i' > 
              <b @click="toChange = driver.id">{{driver.id}}</b> {{driver.name}}
            </li>
          </ul>
        </div>
      </div>
    </b-modal>

  </div>

</template>

<script>
export default {
props: ['data'],
data(){return{
  drivers:false,
  toChange:'',
  errors:false,
}},
methods:{
  async getDrivers(){
    if(this.drivers) return;
    this.drivers = await ax.fetch('/json/drivers');
  },
  async changeDriver(){
    this.errors = false;
    let r = await ax.fetch('/logistic/change/driver',{'date':this.data.date, 'old_id':this.data.driver_id, 'id':this.toChange},'post');

    //Catch errors  
    if(ax.lastResponse.status == 422){
      this.errors = ax.lastResponse.data.errors;
      return false;
    }

    if(r) location.reload();

  },
},
}
</script>

<style>

</style>