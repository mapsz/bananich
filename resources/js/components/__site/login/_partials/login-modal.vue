<template>
  <div id="enterPopup" class="overlay overlay-phone" :style="show ? '' : 'display:none;'">
    <div class="modal-sad modal-sad-phone">
      <!-- Close -->
      <div @click="close()" class="modal-sad-close">&times;</div>

      <login v-if="show" :p-show="pShowType" />


    </div>
  </div>
</template>

<script>
export default {
  props: ['p-show', 'p-show-type'],
  data(){return{
    show:this.pShow,
  }},
  watch: {
    pShow: function(){this.show = this.pShow;},
  },
  methods:{
    close(){
      this.show = false;
      this.$emit('close')
    }
  },
}
</script>

<style scoped>
@media (max-width: 580px){
  .modal-sad-phone {
    margin-top: 50px;
    position: fixed !important;
    top: 0px;
    overflow: scroll;
  }
}
</style>