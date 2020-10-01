<template>
<div>
  <!-- Head -->
  <span class="d-flex justify-content-between">          
    <h5>Клиент</h5>      
    <font-awesome-icon 
      v-if="id > 0"
      @click="edit = !edit"
      class="mr-3" 
      icon="edit" 
      color="#ff8d00"
      style="cursor:pointer"
    />
  </span>
  <!-- ID -->
  <div v-if="id > 0">
    <div><b><a :href='"/admin/user/"+id'>{{id}}</a> </b></div>
  </div>
  <!-- Info -->
  <div v-if="!edit">
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
  <!-- Edit -->
  <div v-if="edit">
    <b-form-group
      class="mb-0"
      label="Комментарий о клиенте"
      label-for="client-comment"
    >
      <!-- Comment -->
      <b-form-textarea
        id="client-comment"
        v-model="comment"
      ></b-form-textarea>
      <b-button @click="postComment({id,comment});edit=false;" class="mt-2" type="submit" variant="success">Сохранить</b-button>
    </b-form-group>
  </div>
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
props: ['id'],
data(){return{
  edit:false,
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
  doEdit(){
    console.log(222);
    
  }
},
}
</script>

<style>

</style>