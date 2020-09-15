let delivery = {
  namespaced:true,
  state: {
    settings: [], 
  },
  getters: {
    get : (state) => {
      return state.settings;
    },
    beautyGet  : (state) => {
      let out = {};
      $.each(state.settings , ( k, v ) => {
        out[v.name] = v.value;
      });
      return out;
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