class jugeMoreAxios{

  constructor(url) {
    this.url = url;
    this.activeLoaders = [];
  }

  async fetch(url,params = {},method = 'get',loader = true){
      //Start loading
      let l; if(loader){l = load.start();}
      //Axios
      let r = false;
      switch (method) {
        case 'get':
          r = await this.getFetch(url, params);
          break;
        case 'put':
          r = await axios.put(url, params)
            .then((r) => {return {e:0,r:r.data};})
            .catch((error) => {this.catch(error);return {e:1,r:error.response};});
          break;
        case 'post':
          r = await axios.post(url, params)
            .then((r) => {return {e:0,r:r.data};})
            .catch((error) => {this.catch(error);return {e:1,r:error.response};});
          break;
        case 'delete':
          r = await axios.delete(url, {data:params})
            .then((r) => {return {e:0,r:r.data};})
            .catch((error) => {this.catch(error);return {e:1,r:error.response};});
          break;
        default:
          return false;
      }
      
      //Save response
      // this.lastResponse = r.r;
      //Stop loading
      if(loader) load.stop(l);
      //Return data
      return r.e ? false : r.r;

  }

  async getFetch(url,params){
    //Get query string
    let queryString = this.getQueryString();

    //Add pages
    if(queryString.page != undefined){
      this.jugeAxPages = queryString.page;
    }
    if(this.jugeAxPages){
      params.page = this.jugeAxPages;
      params.limit = 100;
    }
    let r;
    r = await axios.get(url, {params})
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
      .catch((error) => {this.catch(error);return {e:1,r:error.response};});

    return r;
  }

  catch(){

    console.log('error');
    

    // if(error.response.status == 422) return;      

    // if(error.response.config.url != "/error"){
    //   this.saveError(error.response.data);
    // }
    
    // terror();
    // console.log(error.response);    
  }

  getQueryString(){
    return decodeURI(window.location.search)
      .replace('?', '')
      .split('&')
      .map(param => param.split('='))
      .reduce((values, [ key, value ]) => {
        values[ key ] = value
        return values
      }, {})    
  }

}

export default jugeMoreAxios;