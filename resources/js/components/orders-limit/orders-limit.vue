<template>
<div>
  <gruzka-navbar></gruzka-navbar>  
  <order-navbar></order-navbar>

  <div class="container-fluid">
    <h2>Orders Limit</h2>
    <!-- Settings -->
    <div class="row mb-3 mx-0 pb-2 pt-2 border-bottom border-top">
      <!-- Intervals -->
      <div class="col-4">
        <form>
          <div v-for='(ti,i) in timeIntervals' :key='i' class="form-group row">
            <label :for="ti" class="col-sm-4 col-form-label">{{ti}}</label>
            <div class="col-sm-8">
              <input 
                type="number" 
                :id="ti" 
                :name="ti" 
                :value="'@@@todo'"
              >
            </div>
          </div>
          <button class="btn btn-success" type="submit">Save</button>
        </form>
      </div>

      <!-- Settings -->
      <div class="col-4">
        <form >
          <div class="form-group row">
            <label for="ol-days" class="col-sm-6 col-form-label">Available days count</label>
            <div class="col-sm-6">
              <input type="number" id="ol-days" name="ol-days" :value="'@@@todo'">
            </div>
          </div>
          <input type="hidden" name="action" value="" />
          <div class="form-group row">
            <label for="ol-time" class="col-sm-6 col-form-label">End orders time (00-23)</label>
            <div class="col-sm-6">
              <input type="number" id="ol-time" name="ol-time" :value="'@@@todo'" min="0" max="23">
            </div>
          </div>
          <button class="btn btn-success" type="submit">Save</button>
        </form>
      </div>
    </div> 
  </div>


</div>
</template>

<script>
export default {
  data(){return{
    timeIntervals:[
      '11:00-23:00',
      '11:00-15:00',
      '15:00-19:00',
      '19:00-23:00'
    ]
  }},

}
</script>

<style scoped>
  .now{
    font-size: 18pt;
    color: green;
  }
  .available-days{
    display: flex;
    flex-direction: column;
    align-items: center; 
  }
</style>