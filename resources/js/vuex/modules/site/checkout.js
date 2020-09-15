let checkout = {
  namespaced: true,

  state: {  
    checkout:localStorage.checkout,
  },
  getters: {   
    get : (state) => {
      if(isJson(state.checkout)) return JSON.parse(state.checkout);
      else return {}
    },
  },
  actions:{
    async setValue({state,commit},data){

      //Get old checkout
      let checkout = state.checkout;

      if(isJson(checkout)) checkout = JSON.parse(checkout);
      else checkout = {};

      //Set new value
      checkout[data.name] = data.value;

      //Json string
      checkout = JSON.stringify(checkout);

      //local
      localStorage.checkout = checkout;

      //Mutate
      commit('mCheckout',checkout); 
    }
  },  
  mutations:{
    mCheckout: (state,data) => {return state.checkout = data;},
  },
};

export default checkout;