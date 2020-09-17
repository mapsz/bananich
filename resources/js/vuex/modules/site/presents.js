let presents = {
  namespaced: true,

  state: {  
    settings:false,
    products:false,
    firstLoad:false,
  },
  getters: {   
    getSettings : (state) => {
      return state.settings;
    },  
    getProducts : (state) => {
      return state.products;
    },
  },
  actions:{
    async fetch({state,commit,dispatch}){
      if(state.mFirstLoad) return;
      dispatch('fetchSettings');
      dispatch('fetchProductss');
      commit('mFirstLoad',true); 
    },
    async fetchSettings({commit}){
      let r = await ax.fetch('/present/settings');
      commit('mSettings',r); 
    },
    async fetchProductss({commit}){
      let r = await ax.fetch('/product/present');
      commit('mProducts',r); 
    },
  },  
  mutations:{
    mSettings: (state,data) => {return state.settings = data;},
    mProducts: (state,data) => {return state.products = data;},
    mFirstLoad: (state,data) => {return state.firstLoad = data;},
  },
};

export default presents;