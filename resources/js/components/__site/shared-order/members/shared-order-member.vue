<template>
<div>
  <div class="d-flex">
    <div>
      {{n}}.
    </div>
    <!-- Avatar -->
    <div class="user-avatar">
      <img 
        alt="Avatar"
        :src="user.mainImage != undefined ? user.mainImage : '/users/images/main/no-image.png'" 
        style="max-width:100%; max-height:100%; border-radius: 50px;"
      >
    </div>
    <!-- Info -->
    <div class="member-info d-flex" style="flex-direction:column; justify-content:space-around;">
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
      <!-- Comfirm -->
      <div v-if="user" class="member-confirm mt-2 d-flex align-items-center">
        <template v-if="confirm">
          <span  class="info-icon info-icon-confirm mr-2"></span>
          Заказ оформлен
        </template>
        <template v-else>
          <a :href="meh ? ('#confirm') : '/rules#notconfirm'">
            <span class="info-icon mr-2"  style="color:black; text-decoretion:none" />
          </a>
          Заказ не оформлен
        </template>
      </div>
    </div>
  </div>
</div>

  <!-- Pay -->
  <!-- <div> -->
    <!-- <div v-if="pSlots[n].pay == undefined">
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
        {{pSlots[n].pay.user.name}} {{pSlots[n].pay.user.email}}
      </span>
    </div> -->
  <!-- </div>
</div> -->
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
props: ['pSlot'],

computed:{
  ...mapGetters({
    currentUser:       'user/get',
  }),
  meh(){
    if(this.currentUser == undefined || this.currentUser.id == undefined) return false;
    if(!this.user || this.user.id == undefined) return false;

    if(this.user.id == this.currentUser.id) return true;

    return false;
  },
  user(){
    if(this.pSlot == undefined || this.pSlot.user == undefined) return false;
    return this.pSlot.user;
  },
  n(){
    if(this.pSlot == undefined || this.pSlot.n == undefined) return false;
    return this.pSlot.n;
  },
  confirm(){
    if(this.pSlot == undefined || this.pSlot.order == undefined || this.pSlot.order.x_confirm == undefined) return false;
    return this.pSlot.order.x_confirm;
  },
  link(){
    if(this.$route == undefined || this.$route.params == undefined || this.$route.params.order_link == undefined) return false;    
    return this.$route.params.order_link;
  },
},
}
</script>

<style>
.member-confirm{
  font-size:14px;
}
.user-name, .user-email, .user-phone{
  white-space: normal;
  overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
}

.user-name{
  font-size: 16px;
  color: #000000;
}
.user-email, .user-phone{
  font-size: 14px;
  color: rgba(0, 0, 0, 0.6);
}
.member-info{
  overflow: hidden;
}


/* Desktop */
@media screen and (min-width: 992px){
  .user-name{
    font-size: 20px;
    color: #000000;
  }
  .user-email, .user-phone{
    font-size: 18px;
  }
  .member-confirm{
    font-size:16px;
  }
}
</style>