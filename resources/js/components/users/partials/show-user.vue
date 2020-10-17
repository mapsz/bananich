<template>
<div>
  <!-- Head -->
  <span class="d-flex justify-content-between">          
    <h5>Клиент</h5>     
  </span>
  <!-- ID -->
  <div v-if="id > 0">
    <div><b><a :href='"/admin/user/"+id'>{{id}}</a> </b></div>
  </div>
  <!-- Info -->
  <div>
    <span v-if="id == 0">(Гость)</span>
    <span v-else> 
      <div>{{user.name}} <span v-if="user.surname">{{user.surname}}</span></div>
      <div>{{user.phone}}</div>
      <div>{{user.email}}</div>
      <div>{{user.created_at}}</div>
      <div v-if="user.referal">Реферал: {{user.referal}}</div>

      <div v-if="user.comment">
        О клиенте: 
        <div>
          {{user.comment.comment}}
        </div>
      </div>
    </span>
  </div>
  <!-- Comments -->
  <user-comments :user-id="user.id" class="my-2" />
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
props: ['id'],
data(){return{
  comment:"",
}},
computed:{
  ...mapGetters({user:'user/getOne'}),
},
watch: {
  id: function(){
    console.log(this.id);
    if(this.id){
      this.getUser(this.id);
    }
  },
},
mounted(){
  //
},
methods:{
  ...mapActions({getUser:'user/fetchOne',postComment:'user/postComment'}),
},
}
</script>

<style>

</style>