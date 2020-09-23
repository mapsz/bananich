<template>
<div>

  <!-- Chechboxes -->
  <div style="color: gray;">
    <div class="form-checkbox" style="margin-bottom: 0px;">
      <checkout-input v-model="offer" :name="'aggreOffer'" :type="'checkbox'" :checked='true' />
      <label for="aggreOffer">Согласен на </label>
      <span :id="'offer-rules'" style="cursor:pointer;color:black;position:absolute;padding-left: 5px;">
        договор оферты
      </span>
    </div>

    <div class="form-checkbox" style="margin-bottom: 0px;">
      <checkout-input v-model="personal" :name="'aggrePersonal'" :type="'checkbox'" :checked='true' />
      <label for="aggrePersonal">Согласен на обработку персональных данных</label>
    </div>

    <div class="form-checkbox" style="margin-bottom: 0px;">
      <checkout-input v-model="spams" :name="'aggreSpams'" :type="'checkbox'" :checked='true' />
      <label for="aggreSpams">Согласен получать полезные сообщения на мейл</label>
    </div>
  </div>

  <!-- Offer rules -->
  <div id="offer-modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">      
        <div class="modal-header">
          <h5 class="modal-title">Договор оферты</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Modal body text goes here.</p>
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
  data(){return{
    offer:1,
    personal:1,
    spams:1,
    rows:[
      {
        'name'      : 'personal',
        'caption'   : 'Согласен на обработку персональных данных',
      },
      {
        'name'      : 'spams',
        'caption'   : 'Согласен получать полезные сообщения на мейл',
      },
    ]
  }},
  mounted(){
    //modal toggle
    $('#offer-rules').on('click', () => {$('#offer-modal').modal('toggle');});

    $('#offer-modal').on('show.bs.modal', function (e) {
      console.log('show');
      $('.checkout-checkout').css('position','inherit');
    })

  },
}
</script>

<style>

</style>