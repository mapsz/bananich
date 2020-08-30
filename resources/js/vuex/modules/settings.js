let delivery = {
  namespaced:true,
  state: {
    settings: [], 
  },
  getters: {
    get : (state) => {
      return state.settings;
    },  
  },
  actions:{
    async fetch({commit}){
      let r = await ax.fetch('/json/settings');
      commit('mData',r);

    },
    
  },  
  mutations:{
    mData: (state,data) => {return state.settings = data;},
  },  
};

export default delivery;