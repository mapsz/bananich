let category = {
  namespaced: true,

  state: {  
    allCategories:false,
    category:false,
    active:false,
  },
  getters: {   
    get : (state) => {
      return state.category;
    },
    getAll : (state) => {
      return state.allCategories;
    },
    getActive : (state) => {
      return state.active;
    },
  },
  actions:{
    async fetch({commit}){
      let r = await ax.fetch('/json/categories');
      commit('mCategory',r); 
      commit('mAllCategorie',r); 
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
    mAllCategorie: (state,data) => {return state.allCategories = data;},
    mActive: (state,data) => {return state.active = data;},
  },
};

export default category;