let siteUser = {
  namespaced: true,
  state: {
    user:0,
  },
  getters: {
    get: (state) => {
      return state.user;
    },
    isAdmin: (state) => {
      if(state.user == undefined || state.user.roles == undefined) return null;
      if(state.user.roles[0] == undefined) return false;

      let isRoleAdmin = false;

      $.each(state.user.roles, (k, role) => {
        if(role.name == 'admin'){
          isRoleAdmin = true;
          return true;
        } 
      });

      return isRoleAdmin;
    },
  },
  actions:{
    async fetch({commit}){
      let r = await ax.fetch('/auth/user');
      commit('mUser',r); 
      return;
    },
    async edit({commit}, data){
      let r = await ax.fetch('/user', {data}, 'post');
      commit('mUser',r); 
      return;
    },
    async editAddress({commit}, data){
      let r = await ax.fetch('/user/address', {data}, 'post');
      commit('mUser',r); 
      return;
    },
  },  
  mutations:{
    mUser: (state,data) => {return state.user = data;},
  },  
};

export default siteUser;