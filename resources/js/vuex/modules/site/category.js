let category = {
  namespaced: true,

  state: {  
    category:false,
    active:false,
  },
  getters: {   
    get : (state) => {
      return state.category;
    },
    getActive : (state) => {
      return state.active;
    },
  },
  actions:{
    async fetch({commit}){
      let r = await ax.fetch('/json/categories');
      commit('mCategory',r); 
    },
    async setActive({commit},set){
      commit('mActive',set); 
    },
    async setCategories({commit},categories){
      commit('mCategory',categories); 
    }
  },  
  mutations:{
    mCategory: (state,data) => {return state.category = data;},
    mActive: (state,data) => {return state.active = data;},
  },
};

export default category;