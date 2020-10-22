<template>
<div>
  <gruzka-navbar></gruzka-navbar>
  <div class="container-fluid">
    <!-- <h1>Добавить рассылку</h1> -->

    <div class="container">
      <div id="bar">
        <h1>Vue Email Editor (Demo)</h1>
 
        <button v-on:click="saveDesign">Save Design</button>
        <button v-on:click="exportHtml">Export HTML</button>
      </div>
 
      <EmailEditor class="email-editor-container" :minHeight="'600px'" locale="ru" ref="emailEditor" v-on:load="editorLoaded" />
    </div>


  </div>
</div>
</template>

<script>
import { EmailEditor } from 'vue-email-editor'
export default {
  components: {EmailEditor},
  data(){return{
    value:'',
  }},
  methods: {
      editorLoaded() {
        this.$refs.emailEditor.editor.loadDesign();
      },
      saveDesign() {
        this.$refs.emailEditor.editor.saveDesign(
          (design) => {
            console.log('saveDesign', design);
          }
        )
      },
      exportHtml() {
        this.$refs.emailEditor.editor.exportHtml(
          (data) => {
            console.log('exportHtml', data);
          }
        )
      }
  }

}
</script>

<style>
.email-editor-container iframe{
  min-height: 600px !important;
}

</style>