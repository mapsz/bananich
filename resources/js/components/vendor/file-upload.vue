<template>
  <div>
 
    <file-pond
      name="file"
      ref="pond"
      label-idle="Drop files here..."
      :allow-multiple="false"
      :accepted-file-types="vFileType"
      :server="server"
      :files="myFiles"
      allowReorder="true"
      @init="handleFilePondInit"
      @warning="fpWarning"
      @processfile="fpFileUploaded"
      @removefile="fpFileUploaded"
      @reorderfiles="fpFileUploaded"
    />
 
  </div>
</template>
 
<script>
// Import Vue FilePond
import vueFilePond from 'vue-filepond'; 
// Import FilePond styles
import 'filepond/dist/filepond.min.css';  
// Import image preview plugin styles
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css'; 
// Import image preview and file type validation plugins
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview'; 
// Create component
const FilePond = vueFilePond(FilePondPluginFileValidateType, FilePondPluginImagePreview);

export default {
  props:['max-file-size','max-file-count','file-type'],
  model: {
    event: 'blur'
  },
  data: function() {
    return { 
      server: {
        url: '/file/upload',
        process: {
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          }       
        }
      },
      myFiles: [],
      vFileType:"*",
    };
  },
  mounted(){
    
    //Set file type
    if(this.fileType == undefined){
      this.vFileType = "*";
    }else{
      this.vFileType = this.fileType;
    }

    
  },
  methods: {
    handleFilePondInit: function() {
      console.log('FilePond has initialized');
      // FilePond instance methods are available on `this.$refs.pond`
    },
    fpWarning(payload){
      console.log(payload); // @@@
    },
    fpFileUploaded(){
      let getFiles = this.$refs.pond.getFiles();
      let encFiles = [];
      $.each( getFiles, ( key, value ) => {
        encFiles.push(value.serverId);
      });
      this.$emit('blur', encFiles);
    }
  },
  components: {
    FilePond
  }
};
</script>

<style>

</style>