<script>
export default {
  data(){return{
    slot:{default: this.$createElement('loader-icon'),},
    lastResponse:{},
    jugeAxPages:false,
    lastResponsePages:false,
  }},
  methods:{
    jugeAxResponse(){
      return this.lastResponse;
    },
    async jugeAx(url,params = {},method = 'get',load = true){
      //Start loading
      let l; if(load){l = this.jugeAxLoading();}
      //Axios
      let r = false;
      switch (method) {
        case 'get':
          //Add page
          if(this.$route.query.page != undefined){
            this.jugeAxPages = this.$route.query.page;
          }
          if(this.jugeAxPages){
            params.page = this.jugeAxPages;
            params.limit = 100;
          }
          r = await axios.get(url, {params:params})
            .then((r) => {
              //Get pages
              this.lastResponsePages = false;
              if(r.data.current_page != undefined){
                let pages = JSON.parse(JSON.stringify(r.data));
                pages.data = null;
                this.lastResponsePages = pages;
              }

              //Get data
              let data = r.data;
              if(r.data.current_page != undefined){
                data = r.data.data;
              }

              return {e:0,r:data};
            })
            .catch((error) => {this.axiosCatch(error);return {e:1,r:error.response};});
          break;
        case 'put':
          r = await axios.put(url, params)
            .then((r) => {return {e:0,r:r.data};})
            .catch((error) => {this.axiosCatch(error);return {e:1,r:error.response};});
          break;
        case 'post':
          r = await axios.post(url, params)
            .then((r) => {return {e:0,r:r.data};})
            .catch((error) => {this.axiosCatch(error);return {e:1,r:error.response};});
          break;
        case 'delete':
          r = await axios.delete(url, {data:params})
            .then((r) => {return {e:0,r:r.data};})
            .catch((error) => {this.axiosCatch(error);return {e:1,r:error.response};});
          break;
        default:
          return false;
      }
      //Save response
      this.lastResponse = r.r;
      //Stop loading
      if(load) this.jugeAxStopLoading(l);
      //Return data
      return r.e ? false : r.r;
    },
    jugeAxLoading(){
      return this.$loading.show({},this.slot);
    },
    jugeAxStopLoading(l){
      l.hide();
    },
    axiosCatch(error){

      if(error.response.status == 422) return;      

      if(error.response.config.url != "/error"){
        this.saveError(error.response.data);
      }
      
      terror();
      console.log(error.response);
      
    },
    async saveError(error){
      let screen = await this.getScreen();

      this.jugeAx('/error',
        {
          'error':error,
          'screen':screen        
        },
        'put'
      );
      
    },
    async getScreen() {
      const el = $('#app')[0];
      const options = {type: 'dataURL'};
      return await this.$html2canvas(el, options);
    },    
  }    
}
</script>