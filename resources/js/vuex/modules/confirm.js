let confirm = {
  state:{
    toConfirm:{},
  },
  getters:{
    getToConfirm : (state) => {
      return state.toConfirm;
    },    
  },
  actions:{
    async fetchToConfirm({commit},id){
      let r = await ax.fetch('/to/confirm/orders',{id});
      commit('mToConfirm',r);
    },    
  },
  mutations:{
    mToConfirm: (state,data) => {return state.toConfirm = data;},
  }
};

export default confirm;