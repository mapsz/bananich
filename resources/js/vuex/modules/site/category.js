let category = {
  namespaced: true,

  state: {  
    category:false,
  },
  getters: {   
    get : (state) => {
      return state.category;
    },
  },
  actions:{
    async fetch({commit}){
      let r = await ax.fetch('json/categories');
      commit('mcategory',r); 
    }
  },  
  mutations:{
    mcategory: (state,data) => {return state.category = data;},
  },
};

export default category;