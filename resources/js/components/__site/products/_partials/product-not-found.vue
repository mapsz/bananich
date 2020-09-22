<template>
  <div  class="d-flex justify-content-center mt-4">
    <!-- Button -->
    <button class="btn-yellow btn-thick"  data-toggle="modal" data-target="#no-found-modal">Здесь нет того, что я ищу</button>

    <!-- Modal -->
    <div class="modal fade" id="no-found-modal" tabindex="-1" role="dialog" aria-labelledby="no-found-modalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="no-found-modalLabel">Здесь нет того что я ищу</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              
          <div v-if="!thanks">
            Напишите, что вам хотелось бы видеть на нашем сайте:
            <div class="input-group">
              <textarea v-model="notFound" class="form-control" rows="5" aria-label="With textarea" width="100%"></textarea>
            </div>
          </div>
          <div v-else>
            Спасибо за обратную связь! мы внимательно читаем ваши пожелания и по возможности расширяем ассортимент!
          </div>
          
          
          </div>
          <div v-if="!thanks" class="modal-footer">
            <button @click="sendNotFound()" type="button" class="btn btn-primary">Отправить</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
export default {
data(){return{
  notFound:'',
  thanks:false,
}},
methods:{
  async sendNotFound(){

    if (!this.notFound.length > 0)return;

    let r = ax.fetch('/not/found',{'comment':this.notFound},'put');

    if(r) this.thanks = true;



  }
},
}
</script>

<style>

</style>