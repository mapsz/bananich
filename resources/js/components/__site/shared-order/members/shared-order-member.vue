<template>
<div>
  <div class="d-flex">
    <div>
      {{mSlot}}.
    </div>
    <!-- Avatar -->
    <div class="user-avatar mx-3">
      <img 
        alt="Avatar"
        :src="user.mainImage != undefined ? user.mainImage : '/users/images/main/no-image.png'" 
        style="max-width:100%; max-height:100%; border-radius: 50px;"
      >
    </div>
    <!-- Info -->
    <div class="d-flex" style="flex-direction:column; justify-content:space-around;">
      <!-- Name -->
      <div class="user-name">
        <b>{{user.name != undefined ? user.name : 'Имя Фамилия'}}</b>
      </div>
      <!-- Email -->
      <div class="user-email">
        {{user.email != undefined ? user.email : 'E-mail'}}
      </div>
      <!-- Phone -->
      <div class="user-phone">
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
.user-avatar{
  width:100px;
  height:100px;
  background-color: #aba5a3;
  border-radius: 50px;
  display: flex;
  justify-content: center;
}
.user-name{
  font-size: 20px;
  color: #000000;
}
.user-email, .user-phone{
  font-size: 18px;
  color: rgba(0, 0, 0, 0.6);
}
/* #aba5a3 */
</style>