let siteUser = {
  namespaced: true,
  state: {
    user:0,
  },
  getters: {
    get: (state) => {
      return state.user;
    },
  },
  actions:{
    async fetch({commit}){
      let r = await ax.fetch('/auth/user');
      commit('mUser',r); 
      return;
    },
    async edit({commit}){
      let r = await ax.fetch('/auth/user');
      commit('mUser',r); 
      return;
    },
  },  
  mutations:{
    mUser: (state,data) => {return state.user = data;},
  },  
};

export default siteUser;