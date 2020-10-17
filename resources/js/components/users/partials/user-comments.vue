<template>
<div v-if="this.userId">
  <h5>Комментарии о клиенте</h5>
  <!-- Comments -->
  <div class="my-2">
    <!-- List -->
    <div v-for='(comment,i) in comments' :key='i' >      
      <div style="display: flex;justify-content: space-between;  font-size: 14pt;">
        <!-- Commentator -->
        <span>{{comment.commentator.name}} (id:{{comment.commentator.id}})</span>
        <span>
          <!-- Date -->
          {{comment.created_at}}
          <!-- Delete -->
          <span 
            v-if="isAdmin || comment.commentator.id == auth.id"             
            v-b-modal="'delete-customer-comment-'+comment.id"
            style="cursor:pointer" 
          >❌</span>
          <b-modal :id="'delete-customer-comment-'+comment.id" title="Удалить?" @ok="deleteComment(comment.id)">
            <p class="my-4">{{comment.comment}}</p>
          </b-modal>
        </span>
      </div>   
      <div>{{comment.comment}}</div>
      <hr>      
    </div>
    <!-- No Comments -->
    <div v-if="comments.length < 1">Нет комментариев</div>
  </div>
  <!-- Add comment -->
  <div>
    <button v-if="!add" @click="add=true" class="btn btn-primary btn-sm">Добавить комментарий</button>
    <div v-if="add">
      <textarea v-model="comment" rows="3" style="width:100%"></textarea>
      <button @click="addComment()" class="btn btn-success">Сохранить</button>
    </div>
  </div>
  

</div>  
</template>

<script>
export default {
props: ['user-id'],
data(){return{
  auth:false,
  comments:false,
  comment:'',
  add:false,
}},
computed:{
  isAdmin:function(){
    if(this.auth == undefined || this.auth.roles == undefined) return null;
    if(this.auth.roles[0] == undefined) return false;

    let isRole = false;

    $.each(this.auth.roles, (k, role) => {
      if(role.name == 'admin'){
        isRole = true;
        return true;
      } 
    });

    return isRole;
  }
},
watch: {
  userId: function(){
    if(this.userId) this.getComments();
  },
},
mounted(){
  this.getAuth();
},
methods:{  
  async getAuth(){
    let r = await this.jugeAx('/auth/user');
    this.auth = r;
  },
  async getComments(){
    let r = await ax.fetch('/user/comments',{user_id:this.userId});
    this.comments = r;
  },
  async addComment(){
    let r = await ax.fetch('/add/comment', {'user_id':this.userId,'comment':this.comment}, 'put');    
    if(!r) return false;
    this.add = false;
    this.comment = '';
    this.getComments();
  },
  async deleteComment(id){
    let r = await ax.fetch('/delete/comment', {id}, 'delete');    
    if(!r) return false;
    this.add = false;
    this.getComments();
  }
},
}
</script>

<style>

</style>