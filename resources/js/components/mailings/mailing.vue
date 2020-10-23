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
        let text = {
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
        };

        this.$refs.emailEditor.editor.loadDesign(text);
        // this.$refs.emailEditor.editor.loadDesign();
      },
      saveDesign() {
        this.$refs.emailEditor.editor.saveDesign(
          (design) => {
            console.log('saveDesign', design);
            // let d = JSON.stringify(design)
            console.log(design);
            // console.log(JSON.parse(d) );

            ax.fetch('/admin/email',{id:false,name:'hi',design},'put')
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