<template>
<div>
  <div>
    <!-- Navbar -->
    <gruzka-navbar></gruzka-navbar>

    <!-- Title -->
    <h1 class="mx-2">Gruzka</h1>
    
    <!-- Assemble -->
    <div class="row mx-2 mb-3">
      <span class="align-self-center"><b>Orders:</b> {{Object.keys(orders).length}}</span>
      <!-- <router-link :to="'/gruzka/order'">
        <button class="btn btn-primary mx-3">Gruzka</button>
      </router-link> -->
    </div>    
    
    <!-- Filters -->
    <div class="row mx-0 my-3 order-menu justify-content-around">  
      <!-- Доступные -->
      <div>
        <button 
          class="btn px-1" :class="filters.firstLevel == 1 ? 'btn-primary' : 'btn-outline-primary'"
          @click="filters.firstLevel = 1;filters.secondLevel = 1"
        >
          Доступные
        </button>
      </div>
      <!-- Мои -->
      <div>
        <button 
          class="btn px-1" :class="filters.firstLevel == 2 ? 'btn-primary' : 'btn-outline-primary'"
        >
          Мои Заказы
        </button>
      </div>   
      <!-- By id -->
      <form @submit.prevent="goById()" class="input-group" style="width: 120px;">    
        <input v-model="byId" type="number" class="form-control">
        <div class="input-group-append">
          <button @click.prevent="goById()" class="btn btn-outline-primary px-1" type="button">По ID</button>
        </div>     
      </form> 
    </div>    
    
    <!-- Second level filters -->
    <div class="row mx-0 my-2 order-menu justify-content-around">

      <!-- Доступные -->
      <div v-if="filters.firstLevel == 1" style="display:contents">        
        <div>
          <button 
            class="btn btn-sm px-1" :class="filters.secondLevel == 1 ? 'btn-primary' : 'btn-outline-primary'"
            @click="filters.secondLevel = 1"
          >
            Готовы к сборке
          </button>
        </div>
        <div>
          <button 
            class="btn btn-sm px-1" :class="filters.secondLevel == 2 ? 'btn-primary' : 'btn-outline-primary'"
            @click="filters.secondLevel = 2"
          >
            Собирается
          </button>
        </div>          
        <div>
          <button 
            class="btn btn-sm px-1" :class="filters.secondLevel == 3 ? 'btn-primary' : 'btn-outline-primary'"
            @click="filters.secondLevel = 3"
          >
            Требуют досборки
          </button>
        </div>   
      </div>

      <!-- Мои --> 
      <div v-if="filters.firstLevel == 2" style="display:contents">  
        <div>
          <button 
            class="btn btn-sm px-1" :class="filters.secondLevel == 1 ? 'btn-primary' : 'btn-outline-primary'"
          >
            Собирается
          </button>
        </div>
        <div>
          <button 
            class="btn btn-sm px-1" :class="filters.secondLevel == 2 ? 'btn-primary' : 'btn-outline-primary'"
          >
            Требует досборки
          </button>
        </div> 
        <div>
          <button 
            class="btn btn-sm px-1" :class="filters.secondLevel == 3 ? 'btn-primary' : 'btn-outline-primary'"
          >
            Готов
          </button>
        </div> 
        <div>
          <button 
            class="btn btn-sm px-1" :class="filters.secondLevel == 4 ? 'btn-primary' : 'btn-outline-primary'"
          >
            Уехал +
          </button>
        </div>
      </div>

    </div>

    <!-- List -->
    <table class="table table-sm">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Items</th>
          <th scope="col">Status</th>
          <th scope="col">Assemble</th>
        </tr>
      </thead>
      <tbody>
        <!-- Current Orders -->
        <tr v-for="order in currentOrders" :key="order.id">
            <th scope="row">
              <router-link :to="'/order/'+order.id">{{order.id}}</router-link>         
          </th>
          <td>{{order.items.length}}</td>
          <td>
            {{order.statuses[0].name}}

          </td>
          <td>      
            <router-link  :to="'/admin/gruzka/order/'+order.id">
              <button class="btn btn-primary m-3">
                <font-awesome-icon icon="box-open" /> 
              </button>
            </router-link>
          </td>
        </tr>         

        <!-- Ready orders -->
        <tr v-for="order in orders" :key="order.id">
          <th scope="row">
              <router-link :to="'/order/'+order.id">{{order.id}}</router-link>         
          </th>
          <td>{{order.items.length}}</td>
          <td>
            {{order.statuses[0].name}}

          </td>
          <td>      
            <router-link  :to="'/admin/gruzka/'+order.id">
              <button class="btn btn-primary m-3">
                <font-awesome-icon icon="box-open" /> 
              </button>
            </router-link>
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
      slot:{default: this.$createElement('loader-icon'),},
      orders:[],
      currentOrders:[],
      byId:null,
      filters:{
        firstLevel:1,
        secondLevel:1,
      },
    }
  },
  computed:{
    filter: function(){
      // Доступные
      if(this.filters.firstLevel == 1){
        // Готовы к сборке
        if(this.filters.secondLevel == 1){
          return {status:[600]};
        }
        // Собирается
        if(this.filters.secondLevel == 2){
          return {status:[500]};
        }          
        // Требуют досборки
        if(this.filters.secondLevel == 3){
          return {status:[400]};
        }        
        return;
      }

      // return {status:[600]};
      // Мои
      // if(this.filters.firstLevel == 2){
      //   // Собирается
      //   if(this.filters.secondLevel == 1){
      //     return {status:[500],currentUser:true};
      //   }        
      // }
    }
  },
  watch: {
    filters: {
      handler: function (val, oldVal) {
        this.getOrders();
      },
      deep: true
    }
  },
  async mounted(){    
    await this.getOrders();   
  },
  methods:{ 
    async getOrders(){
      let r = await this.jugeAx('/json/orders',this.filter);

      if(!r) return;

      this.orders = r;
        
    },
    goById(){
      this.$router.push('/admin/gruzka/'+this.byId);
    }
  }  
}
</script>

<style scoped>

table td, table th{
  text-align: center; 
  vertical-align: middle; 
}

</style>