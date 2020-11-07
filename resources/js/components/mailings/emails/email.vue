<template>
<div>
  <gruzka-navbar></gruzka-navbar>
  <div class="container-fluid">

    <!-- Title -->
    <div class="d-flex mb-4">
      <h1 class="mr-3">Email</h1>
      <h1 class="mr-3" v-if="id">#{{id}}</h1>
    </div>
    <hr>

    <div class="row">
      <!-- Inputs -->
      <div class="col-6">
        <!-- Inputs -->
        <div>
          <div class="mb-3 form-inline">
            <div class="form-group">
              <label for="email-name" style="width:170px">Название Рассылки: </label>
              <input v-model="name" type="text" name="email-name" id="email-name" class="form-control" placeholder="" style="width:275px">
            </div>
          </div>
          <div class="mb-3 form-inline">
            <div class="form-group">
              <label for="email-subject" style="width:170px">Тема письма: </label>
              <input v-model="subject" type="text" name="email-subject" id="email-subject" class="form-control" placeholder="" style="width:275px">
            </div>
          </div>
        </div>
        <!-- Button -->
        <div v-if="loaded">
          <button v-on:click="saveDesign" style="margin-left:170px" class="btn btn-success">Сохранить</button>
        </div>
      </div>
      <!-- Test email -->
      <div v-if="id" class="col-6">
        <!-- Title -->
        <div>
          <h4>Тест письмо</h4>
        </div>
        <!-- Inputs -->
        <div class="mb-3 form-inline">
          <div class="form-group">
            <label for="email-email" style="width:100px">Email: </label>
            <input v-model="testEmailAddress" type="text" name="email-email" id="email-email" class="form-control" placeholder="" style="width:250px">
          </div>
        </div> 
        <!-- Button -->
        <button v-on:click="testMail" style="margin-left:100px" class="btn btn-info">Отправить тест email</button>       
      </div>
    </div>

    <hr>

    <div class="d-flex">
      <!-- Edit -->
      <div style="">
        <h2>Edit</h2>
        <!-- Loader -->
        <div v-if="!loaded" class="my-5" style="display: flex; justify-content: center; width: 600px;">
          <b-spinner label="Loading..." style="height: 400px; width: 400px;"></b-spinner>
        </div>

        <!-- Edit -->
        <div v-show="loaded">
          <EmailEditor 
            v-if="design"
            class="email-editor-container" 
            :minHeight="'600px'" 
            locale="ru" 
            ref="emailEditor" 
            v-on:load="editorLoaded" 
          />
        </div>
        
        <!-- Save -->
        <div v-if="loaded">
          <button v-on:click="saveDesign" class="btn btn-success">Сохранить</button>
        </div>
      </div>

      <!-- Preview -->
      <div v-if="id" class="ml-3" style="min-width:600px">
        <h2>Preview</h2>
        <iframe id="mail-preview" :src="'/mail/preview/'+id" frameborder="0" style="width: 700px; min-height: 2000px;"></iframe>
      </div>

    </div>
  </div>
</div>
</template>

<script>
import { EmailEditor } from 'vue-email-editor'
import {mapGetters, mapActions} from 'vuex';
export default {
  components: {EmailEditor},
  data(){return{
    loaded:false,
    value:'',
    subject:'',
    name:'',
    testEmailAddress:'',
    id:false,
    design:false,
    defaultDesign:{
          "counters": {
            "u_column": 3,
            "u_row": 3,
            "u_content_text": 1
          },
          "body": {
            "rows": [
              {
                "cells": [
                  1
                ],
                "columns": [
                  {
                    "contents": [
                      {
                        "type": "text",
                        "values": {
                          "containerPadding": "0px",
                          "_meta": {
                            "htmlID": "u_content_text_1",
                            "htmlClassNames": "u_content_text"
                          },
                          "selectable": true,
                          "draggable": true,
                          "duplicatable": true,
                          "deletable": true,
                          "color": "#000000",
                          "textAlign": "left",
                          "lineHeight": "140%",
                          "linkStyle": {
                            "inherit": true,
                            "linkColor": "#0000ee",
                            "linkHoverColor": "#0000ee",
                            "linkUnderline": true,
                            "linkHoverUnderline": true
                          },
                          "hideDesktop": false,
                          "hideMobile": false,
                          "text": "<div style=\"width: 600px; height: 160px; margin: auto; background: #FBD610;\">\n<table>\n<tbody>\n<tr>\n<td width=\"50\">&nbsp;</td>\n<td width=\"450\">\n<div align=\"left\"><span style=\"font-size: 22px; line-height: 30.8px;\"><strong>Бананыч.</strong></span><br /><span style=\"font-size: 22px; line-height: 30.8px;\">Доставка полезного</span></div>\n</td>\n<td style=\"background: url(;\" align=\"right\" valign=\"middle\" width=\"160\" height=\"155\">&nbsp;</td>\n</tr>\n</tbody>\n</table>\n</div>"
                        }
                      }
                    ],
                    "values": {
                      "backgroundColor": "",
                      "padding": "0px",
                      "border": {},
                      "_meta": {
                        "htmlID": "u_column_1",
                        "htmlClassNames": "u_column"
                      }
                    }
                  }
                ],
                "values": {
                  "displayCondition": null,
                  "columns": false,
                  "backgroundColor": "",
                  "columnsBackgroundColor": "",
                  "backgroundImage": {
                    "url": "",
                    "fullWidth": true,
                    "repeat": false,
                    "center": true,
                    "cover": false
                  },
                  "padding": "0px",
                  "hideDesktop": false,
                  "hideMobile": false,
                  "noStackMobile": false,
                  "_meta": {
                    "htmlID": "u_row_1",
                    "htmlClassNames": "u_row"
                  },
                  "selectable": true,
                  "draggable": true,
                  "duplicatable": true,
                  "deletable": true
                }
              },
              {
                "cells": [
                  1
                ],
                "columns": [
                  {
                    "contents": [],
                    "values": {
                      "backgroundColor": "",
                      "padding": "0px",
                      "border": {},
                      "_meta": {
                        "htmlID": "u_column_2",
                        "htmlClassNames": "u_column"
                      }
                    }
                  }
                ],
                "values": {
                  "displayCondition": null,
                  "columns": false,
                  "backgroundColor": "",
                  "columnsBackgroundColor": "",
                  "backgroundImage": {
                    "url": "",
                    "fullWidth": true,
                    "repeat": false,
                    "center": true,
                    "cover": false
                  },
                  "padding": "0px",
                  "hideDesktop": false,
                  "hideMobile": false,
                  "noStackMobile": false,
                  "_meta": {
                    "htmlID": "u_row_2",
                    "htmlClassNames": "u_row"
                  },
                  "selectable": true,
                  "draggable": true,
                  "duplicatable": true,
                  "deletable": true
                }
              },
              {
                "cells": [
                  1
                ],
                "columns": [
                  {
                    "contents": [
                      {
                        "type": "text",
                        "values": {
                          "containerPadding": "0px",
                          "_meta": {
                            "htmlID": "u_content_text_1",
                            "htmlClassNames": "u_content_text"
                          },
                          "selectable": true,
                          "draggable": true,
                          "duplicatable": true,
                          "deletable": true,
                          "color": "#000000",
                          "textAlign": "left",
                          "lineHeight": "140%",
                          "linkStyle": {
                            "inherit": true,
                            "linkColor": "#0000ee",
                            "linkHoverColor": "#0000ee",
                            "linkUnderline": true,
                            "linkHoverUnderline": true
                          },
                          "hideDesktop": false,
                          "hideMobile": false,
                          "text": `<div style="box-sizing: border-box;width: 600px;margin: auto;border: 1px #fbd610 solid;border-top: 0px; padding: 10px;"> <table><tbody> <tr><td width="80" height="80" style=" background: url('https://bananich.ru/mail/logo.png'); background-repeat: no-repeat; background-position: center; " ></td><td width="250"> <p> <b> Пишите или звоните, <br>мы всегда рады общению! </b> </p><p> Ваш Бананыч </p></td><td width="150"> <span>📞 <a href="#" style="color:black"><b>87897897899</b></a></span> </td><td> <table> <tr> <td width="30" height="25"> <a width="46" height="25" href="https://instagram.com/bananich.ru" target="_blank" > <table><tr><td width="35" height="25" style=" background: url('http://bananich.ru/mail/insta.png'); background-repeat: no-repeat; "> </td></tr></table> </a> </td><td> <a width="20" height="25" href="https://vk.com/bananichru" target="_blank" > <table><tr><td width="35" height="25" style=" background: url('http://bananich.ru/mail/vk.png'); background-repeat: no-repeat; "> </td></tr></table> </a> </td></tr><tr> <td colspan="2"> <a href="https://bananich.ru" style="color:black">bananich.ru</a> </td></tr></table> </td></tr><tr > <td colspan="3" width="600" align="center"> <a href="https://bananich.ru/unsubscribe" style="color:black">Отписаться</a> </td></tr></tbody></table></div>`
                        }
                      }
                    ],
                    "values": {
                      "backgroundColor": "",
                      "padding": "0px",
                      "border": {},
                      "_meta": {
                        "htmlID": "u_column_3",
                        "htmlClassNames": "u_column"
                      }
                    }
                  }
                ],
                "values": {
                  "displayCondition": null,
                  "columns": false,
                  "backgroundColor": "",
                  "columnsBackgroundColor": "",
                  "backgroundImage": {
                    "url": "",
                    "fullWidth": true,
                    "repeat": false,
                    "center": true,
                    "cover": false
                  },
                  "padding": "0px",
                  "hideDesktop": false,
                  "hideMobile": false,
                  "noStackMobile": false,
                  "_meta": {
                    "htmlID": "u_row_3",
                    "htmlClassNames": "u_row"
                  },
                  "selectable": true,
                  "draggable": true,
                  "duplicatable": true,
                  "deletable": true
                }
              }
            ],
            "values": {
              "backgroundColor": "#fff",
              "backgroundImage": {
                "url": "",
                "fullWidth": true,
                "repeat": false,
                "center": true,
                "cover": false
              },
              "contentWidth": "600px",
              "fontFamily": {
                "label": "Arial",
                "value": "arial,helvetica,sans-serif"
              },
              "linkStyle": {
                "body": true,
                "linkColor": "#0000ee",
                "linkHoverColor": "#0000ee",
                "linkUnderline": true,
                "linkHoverUnderline": true
              },
              "_meta": {
                "htmlID": "u_body",
                "htmlClassNames": "u_body"
              }
            }
          },
          "schemaVersion": 5
    },
  }},
  computed:{
    ...mapGetters({email:'email/getOne'}),
  },
  watch: {
    email: {
      handler: function (val, oldVal) {
        if(this.email.name != undefined && this.email.name) this.name = this.email.name;
        if(this.email.subject != undefined && this.email.subject) this.subject = this.email.subject;
      },
      deep: true
    },
  },
  async mounted(){
    //Get
    if(this.$route.params.id > 0){
      this.id = this.$route.params.id;
    }

    if(!this.id){
      this.design = this.defaultDesign;
    }

    //Fetch product
    if(this.id){
      await this.fetch(this.id);
    }
    
    this.design = JSON.parse(this.email.design);

    //Iframe size
    let iframe = document.getElementById("mail-preview");
    iframe.onload = function(){
      iframe.style.height = iframe.contentWindow.document.body.scrollHeight + 'px';
    }

  },
  methods: {
      ...mapActions({
        'fetch':'email/fetchOne',
      }),
      async editorLoaded() {
        this.$refs.emailEditor.editor.loadDesign(this.design);
        this.loaded = true;
      },
      async saveDesign() {
        this.$refs.emailEditor.editor.saveDesign(
          (design) => {
            if(this.id){
              this.postEmail(design);
            }else{
              this.putEmail(design);
            }            
          }
        );
      },
      async putEmail(design){
        //Refresh Errors
        this.errors = [];
        //Fetch
        let r = await ax.fetch('/admin/email',{name:this.name, subject:this.subject, design},'put');
        //Catch errors
        if(!r){if(ax.lastResponse.status != undefined){if(ax.lastResponse.status == 422){this.showErrors(ax.lastResponse.data.errors)}}return;};
        //Move to edit
        location.href = "/admin/email/"+r;
      },
      async postEmail(design){
        //Refresh Errors
        this.errors = [];
        //Fetch
        let r = await ax.fetch('/admin/email',{name:this.name, subject:this.subject, design, id:this.id},'post');

        //Catch errors
        if(!r){if(ax.lastResponse.status != undefined){if(ax.lastResponse.status == 422){this.showErrors(ax.lastResponse.data.errors)}}return;};
        
        //Success
        Vue.toasted.show("ага 🐪",{type:'success',position:'bottom-right'});
        //Refresh iframe
        var iframe = document.getElementById('mail-preview');iframe.src = iframe.src;        
      },
      exportHtml() {
        this.$refs.emailEditor.editor.exportHtml(
          (data) => {
            console.log('exportHtml', data);
          }
        )
      },
      async testMail(){
        //Refresh Errors
        this.errors = [];
        //Fetch
        let r = await ax.fetch('/admin/test/mail',{email:this.testEmailAddress, id:this.id},'put');    
 
        //Catch errors
        if(!r){if(ax.lastResponse.status != undefined){if(ax.lastResponse.status == 422){this.showErrors(ax.lastResponse.data.errors)}}return;};
        
        //Success
        Vue.toasted.show("send 📩",{type:'success',position:'bottom-right'});
        
      },
      async showErrors(errors){
        $.each(errors,function( i, errorz ) {
          $.each(errorz,function( j, error ) {
            Vue.toasted.show(error,{type:'error',position:'bottom-right'});
          });
        });
      },
  }

}
</script>

<style>
.email-editor-container iframe{
  min-height: 600px !important;
}

</style>