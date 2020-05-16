class jugeVuex {
  constructor(modelName) {
    //Params
    this.modelName = modelName;

    //Vuex
    this.namespaced = true;
    this.state = {
      //Sigle
      row:[],
      //Multi
      rows:[],
      pages:[],
    }
    this.getters = {
      get: (state) => {return state.rows;},
    }
    this.actions = {
      async fetch({commit}){
        //Fetch  
        let r = await ax.fetch('/json/report');

        // Get pages
        let pages = false;
        if(r.current_page != undefined){
          pages = JSON.parse(JSON.stringify(r));
          pages.data = null;
        }

        //Get data
        let data = r;
        if(r.current_page != undefined){
          data = r.data;
        }

        commit('mRows',data);
      }        
    }   
    this.mutations = {
      mRows: (state,d) => {return state.rows = d;},
    }    
  }


}

export default jugeVuex;