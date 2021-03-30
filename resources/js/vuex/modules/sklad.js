let sklad = {
  namespaced:true,
  state: {  
    data:null,
    logs:null,
    firstLoad:false,
  },
  getters:{    
    get : (state) => {return state.data;}, 
    getLogs : (state) => {return state.logs;},
  },
  actions:{
    async fetch({commit}){
      commit('mFirstLoad',true);
      let r = await ax.fetch('/sklad/get');  
      commit('mData',r);
    },
    async fetchLogs({commit}){
      let r = await ax.fetch('/sklad/get/logs');  
      commit('mLogs',r);
    },
    async firstFetch({state,dispatch}){
      if(state.firstLoad) return;
      dispatch('fetch');
      dispatch('fetchLogs');
      return;
    },
    //Start task
    async resetPc({commit}){
      let r = await ax.fetch('/sklad',{'name':'resetPc','priority':10},'put');
      return r;
    }
  },  
  mutations:{
    mData: (state,data) => {return state.data = data;},
    mLogs: (state,data) => {return state.logs = data;},
    mFirstLoad: (state,data) => {return state.firstLoad = data;},
  },  
};

export default sklad;