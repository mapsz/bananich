<template>
<div>
  <button @click="showPopup=true" class="btn btn-info btn-sm">🦙</button>

  <!-- Parent -->
  <span v-if="data.referral_parent != undefined && data.referral_parent.id != undefined">
    <a :href="'/admin/user/'+data.referral_parent.id">{{data.referral_parent.name}}</a>    
  </span>  
  <!-- Reward -->
  <span v-if="data.refferal_reward != undefined">{{data.refferal_reward}}p</span>


  <x-popup v-if="couponId" 
    :title="'Реферал'" 
    :active="showPopup"
    @close="showPopup=false" 
    :id="'coupon-referral-list-modal-'+couponId"
  >
    <!-- Code -->
    <div><b>{{data.code}}</b></div>

    <!-- Referral -->
    <template>
      <!-- Parent -->
      <span v-if="data.referral_parent != undefined && data.referral_parent.id != undefined">
        <a :href="'/admin/user/'+data.referral_parent.id">{{data.referral_parent.id}} {{data.referral_parent.name}}</a>    
      </span>  
      <!-- Reward -->
      <span v-if="data.refferal_reward != undefined">{{data.refferal_reward}}p</span>
    </template>
    
    <!-- Form -->
    <juge-form class="mt-3" :inputs="inputs" :errors="errors" @submit="save" />

  </x-popup>
</div>
</template>

<script>
export default {
props: ['data'],
data(){return{
  showPopup:false,
  errors:[],
  inputs:[
    {
      name:'parentId',
      caption:'Аккаунт (ID)',
      type:'number',
      required:true,
    },
    {
      name:'reward',
      caption:'Награда',
      type:'number',
      required:true,
    },
  ],
}},
computed:{
  couponId(){
    if(this.data == undefined || this.data.id == undefined || this.data.id < 1) return false;
    return this.data.id;    
  },
},
methods:{
  async save(data){
    //Add coupon id
    data.couponId = this.couponId;

    let r = await ax.fetch('/coupon/referral', data, 'post');

    if(r) location.reload();
     if(!r){if(ax.lastResponse.status == 422){this.errors = ax.lastResponse.data.errors;return;}}

  }
},
}
</script>

<style>

</style>