class jugeMoreAxios{

  constructor() {
    this.lastResponse = {};
  }

  async get(url,params = {},loader = true){this.fetch(url,params,'get',loader)};
  async post(url,params = {},loader = true){this.fetch(url,params,'get',loader)};
  async put(url,params = {},loader = true){this.fetch(url,params,'get',loader)};
  async delete(url,params = {},loader = true){this.fetch(url,params,'get',loader)};

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
      this.lastResponse = r.r;
      //Stop loading
      if(loader) load.stop(l);
      //Return data
      return r.e ? false : r.r;

  }

  async getFetch(url,params){
    
    //Get query string
    let queryString = this.getQueryString();

    //Add pages
    if(params.page == undefined){
      if(queryString.page != undefined){
        this.jugeAxPages = queryString.page;
      }
      if(this.jugeAxPages){
        params.page = this.jugeAxPages;
        params.limit = 100;
      }
    }

    let r;
    r = await axios.get(url, {params})
      .then((r) => {return {e:0,r:r.data};})
      .catch((error) => {this.catch(error);return {e:1,r:error.response};});

    return r;
  }

  catch(error){

    console.log('_______ERROR________');
    console.log(error.response);
    console.log('````````````````````');    

    // if(error.response.status == 422) return;      

    // if(error.response.config.url != "/error"){
    //   this.saveError(error.response.data);
    // }
    
    terror();
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