<template>
<div>
  <h3>Главное фото</h3>

  
  <b-button v-b-modal.user-main-photo-modal>Редактировать главное фото</b-button>

  <div class="new-main-photo my-2 d-flex">

    <!-- Current main photo -->
    <img :src="user.mainImage" style="width:75px; height:75px">

    <div class="m-3" v-if="cropper" style="align-self: center; color: limegreen; font-size:24pt">➤</div>

    <!-- New main photo -->
    <div id="prew-main" style="overflow: hidden; width:75px; height:75px"></div>
  </div>

  <button v-if="cropper" class="btn btn-success" @click="save()">Сохранить</button>

  <b-modal v-model="modalShow" size="lg" id="user-main-photo-modal" title="Редактирование главного фото" ok-only>

      <!-- Photo list -->
      <div class="photo-list row">
        <img v-for='(image,i) in user.images' @click="edit(image)" class="m-2 border" :key='i' :src="image" >
      </div>

      <div v-show="selected" class="row">
        
        <!-- Edit -->
        <div class="border" style="max-height: 400px; max-width:400px;">
          <img :src="'/users/images/source/1681_0.jpg'" id="photo-edit-place">
        </div>
        
        <!-- preview -->
        <div class="ml-3 border" id="prew-modal" style="overflow: hidden; width:200px; height:200px"></div>

      </div>

  </b-modal>

</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
export default {
  data(){return{    
    modalShow: false,
    cropper:false,
    selected:false,
  }},
  computed:{
    ...mapGetters({user:'user/getOne'}),    
  },
  methods:{
    edit(img){
      // this.selected = false;
      this.selected = true;

      if(this.cropper){
        this.cropper.destroy();
        this.cropper = false;
      } 

      //Create cropper
      if(!this.cropper){
        this.cropper = new Cropper(
            document.getElementById('photo-edit-place'), 
          {
            zoomOnTouch:false,
            zoomOnWheel:false,
            aspectRatio: 1,
            preview:[document.getElementById('prew-main'),document.getElementById('prew-modal')],
            crop(event) {
            },
          }
        );

      }

      if(this.cropper) this.cropper.replace(img);

    },
    async save(){
      //Get canvas
      let canvas = this.cropper.getCroppedCanvas();

      //Send
      canvas.toBlob(async (blob) => {
        const formData = new FormData();
        formData.append('file', blob);
        let r = await ax.fetch('/file/upload',formData,'post');

        if(!(typeof(r) == 'string' && r.length > 5)){
          terror();
        }
        
        r = await ax.fetch('/user/main/photo',{file:r,userId:this.user.id},'post');

        if(r) location.reload();
      });

    }
  },
}
</script>

<style scoped>

.photo-list img{
  max-height: 100px; 
  max-width: 100px;
  cursor:pointer;
}

</style>