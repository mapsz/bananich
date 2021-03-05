<template>
  <div>
    <gruzka-navbar />
    <map-navbar />
    <div class="container-fluid">
      <!-- Polygons -->
      <h2>Полигоны</h2>
      <!-- List -->
      <div class="mt-3" style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr;">
        <div v-for="(polygon, i) in polygons" :key="i" class="m-1">
          <div style="border:1px solid black; background-color: white; padding: 5px;" :style="'border-color:'+polygon.border">
            <div :style="'color:'+polygon.color" class="justify-content-between d-flex">
              <!-- Id -->
              <span><b>{{polygon.id}}</b></span>
              <!-- Edit -->
              <button class="btn btn-warning btn-sm" @click="showEdit = polygon.id">✏️</button>
            </div>            
            <div :style="'color:'+polygon.color">{{polygon.name}}</div>
            <!-- Dots -->
            <span>
              dots: {{polygon.coords.length}}
            </span>
            <!-- Prices -->
            <template v-if="polygon.prices.length > 0">
              <div v-for="(price, i) in polygon.prices" :key="i" class="mt-2">
                <span>day: <b>{{price.day == 0 ? 'any' : price.day}}</b></span> 
                <span>time: <b>{{price.time == 0 ? 'any' : price.time}}</b></span>
                <span>Price: <b>{{price.price}}</b></span> 
              </div>              
            </template>
          </div>                
        </div>
      </div>
      <!-- Edit -->
      <x-popup :title="'edit '+showEdit" :active="showEdit" @close="showEdit=false">
        <h3>{{toEditPolygon.name}}</h3>
        <!-- Readme -->
        <div>          
          (<b>Day</b> + <b>Time</b>) <span style="color:limegreen">></span> 
          (Day + <b>Time</b>) <span style="color:limegreen">></span> 
          (<b>Day</b> + Time) <span style="color:limegreen">></span> 
          (Time + Day)
          <div><span style="color:tomato">*</span><b>valued</b> any</div>
        </div>   
        <!-- List -->
        <template v-if="toEditPolygon && toEditPolygon.prices.length > 0">
          <hr>
          <div v-for="(price, index) in toEditPolygon.prices" :key="index" class="mt-2 d-flex justify-content-between align-items-center"> 
            <div>              
              <span>day: <b>{{price.day == 0 ? 'any' : price.day}}</b></span> 
              <span>time: <b>{{price.time == 0 ? 'any' : price.time}}</b></span>
              <span>Price: <b>{{price.price}}</b></span> 
            </div>
            <div>
              <button @click="deletePrice(toEditPolygon.id,price.id)" class="btn btn-danger btn-sm">🗑️</button>
            </div>
          </div>
        </template>
        <!-- Add form -->
        <hr>
        <juge-form :inputs="addPriceInputs" :errors="errors" @submit="addPrice"></juge-form>
      </x-popup>  
    </div>
  </div>
</template>

<script>
export default {
data(){return{
  polygons:[],
  showEdit:false,
  addPriceInputs:[
    {
      name:'price',
      caption:'Цена',
      type:'number',
      required:true,
    },
    {
      name:'day',
      caption:'День',
      type:'select',
      value:0,
      list:[
        {name:'Any', id:0, selected:true},
        {name:'Поденельник', id:1},
        {name:'Вторник', id:2},
        {name:'Среда', id:3},
        {name:'Четверг', id:4},
        {name:'Пятница', id:5},
        {name:'Суббота', id:6},
        {name:'Воскрескнье', id:7},
      ]
    },
    // {
    //   name:'date',
    //   caption:'Дата',
    //   type:'date',
    // },
    {
      name:'time',
      caption:'Время',
      type:'select',
      value:0,
      list:[
        {name:'Any', id:0, selected:true},
        {name:'11-15', id:'11-15'},
        {name:'15-19', id:'15-19'},
        {name:'19-23', id:'19-23'},
      ]
    },
  ],
  errors:[],
}},
computed:{
  toEditPolygon (){
    if(!this.showEdit) return false;
    if(!this.polygons || this.polygons.length < 1 || this.polygons[0].id == undefined) return null;

    let polygon = this.polygons.find(x => x.id == this.showEdit);

    return polygon;
    
  },
},
async mounted() {
  this.polygonsGet();
},
methods:{  
  async polygonsGet(){

    let r = await ax.fetch('/admin/polygons');

    if(r){
      this.polygons = r;
    };

  },
  async deletePrice(polygonId,priceId){
    let data = {polygonId,priceId};

    let r = await ax.fetch('/admin/polygons/price', data, 'delete');

    
    this.polygonsGet();

  },
  async addPrice(data){
    data.polygonId = this.toEditPolygon.id;

    let r = await ax.fetch('/admin/polygons/price', data, 'put');

    this.polygonsGet();
  }
},
}
</script>

<style>

</style>