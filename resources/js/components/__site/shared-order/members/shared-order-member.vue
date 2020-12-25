<template>
<div>
  <div class="d-flex">
    <div>
      {{mSlot}}.
    </div>
    <!-- Avatar -->
    <div class="pl-1" style="width:100px; height:100px;">
      <img src="https://bananich.ru/image/logo.svg" alt="" style="width:100%; height:100%;">
    </div>
    <!-- Info -->
    <div class="d-flex pl-2" style="flex-direction: column;justify-content: space-around;">
      <!-- Name -->
      <div>
        <b>{{user.name != undefined ? user.name : 'Имя Фамилия'}}</b>
      </div>
      <!-- Email -->
      <div>
        {{user.email != undefined ? user.email : 'E-mail'}}
      </div>
      <!-- Phone -->
      <div>
        {{user.phone != undefined ? user.phone : 'Телефон'}}
      </div>
    </div>
  </div>
</div>

  <!-- Pay -->
  <!-- <div> -->
    <!-- <div v-if="slots[n].pay == undefined">
      <button 
        @click="pay(user.id, n)" 
        class="btn btn-info"
      >
        Оплатить {{sOrder.user_price}}p
      </button>
    </div> -->
    <!-- Pay -->
    <!-- <div v-else>
      <span class="text-success">Оплачено</span>
      <span>
        {{slots[n].pay.user.name}} {{slots[n].pay.user.email}}
      </span>
    </div> -->
  <!-- </div>
</div> -->
</template>

<script>
export default {
props: ['user','mSlot'],

}
</script>

<style>

</style>