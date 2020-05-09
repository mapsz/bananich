<template>
<div>
  <div class="product-images" style="position: relative">
    <!-- Input -->
    <div v-if="pEdit" @click="imagesModalOpen()" class="product-images-edit" style="min-height:100px">
      <span>Редактировать картинки...</span>  
    </div>
    <!-- View -->
    <div>
      <!-- Main Image -->
      <div class="product-main-image d-flex justify-content-center">
        <img v-if="images.length >= 1" :src="images[0]" alt="" style="max-height:200px">
        <img v-else src="/img/placeholder.png" alt="" style="max-height:200px">
      </div>
      <!-- More Images -->
      <div v-if="images.length > 1" class="mt-1 product-additional-images d-flex justify-content-around">
        <div v-for="(image, k) in additionalImages" :key="k" class="product-additional-image">
          <img :src="image" alt="">
        </div>
      </div>   
    </div> 
  </div>
  <!-- Input modal -->
  <div class="modal fade" id="product-images-edit-modal" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Картинки</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <file-upload 
            v-model="imagesUpload"    
          />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
        </div>
      </div>
    </div>
  </div>  
</div>
</template>

<script>
export default {
props: ['p-edit'],
model: {event: 'blur'},
data(){return{
  images:[
    // "data:image/png;base64, ",
    // "/img/sky.jpg",
    // "/img/cucumber.jpg",
    // "/img/sky.jpg",
    // "/img/cucumber.jpg",
  ],
  imagesUpload:[],
}},
watch: {
  imagesUpload: {
    handler: function (val, oldVal) {
      this.prevwiewImages();
      this.$emit('blur', this.imagesUpload);
    },
    deep: true
  }
},
mounted(){
  // /
},
computed:{
  additionalImages: function(){
    let out = JSON.parse(JSON.stringify(this.images));
    out.shift();    
    return out;
  }
},
methods:{
  imagesModalOpen(){
    $('#product-images-edit-modal').modal('show');
  },
  async prevwiewImages(){
    if(this.imagesUpload.length < 1){
      this.images = [];
      return;
    } 
    if(this.imagesUpload.findIndex(x => x == null) >= 0) return;
    
    let r = await this.jugeAx('/base64/preloaded/images',{
      images:this.imagesUpload,
    });   
    this.images = r;
  }
},
}
</script>

<style scoped>
  /* Edit */
  .product-images-edit{
    position: absolute; 
    width:100%;   
    height:100%;   
    z-index: 999;    
    cursor: pointer;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12pt;    
    text-decoration: underline; 
    border: 3px dashed black;   
  }
  .product-images-edit:hover{
    background-color: #69cc4c80;
    font-weight: 600;
  }  
  /* View */
  img{
    max-width:100%;
  }
  .product-main-image{
    border: 1px solid gray;
  }
  .product-additional-image img {
    max-height: 75px;
    max-width: 75px;
  }
  .product-additional-image {
    margin: 0px 5px;
    display: flex;
    align-items: center;    
    border: 1px solid gray;
  } 
</style>