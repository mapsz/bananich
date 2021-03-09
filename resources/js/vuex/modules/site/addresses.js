
let checkout = {
  namespaced: true,

  state: {  
  //   checkout:localStorage.checkout,
    addressesDb:null,
  },
  getters: {   
    get : (state,getters,rootState,rootGetters) => {
      let user = rootGetters['user/get'];

      if(user && user.addresses != undefined){
        return user.addresses;
      }
      
      if(state.addressesDb && state.addressesDb[0] != undefined){
        return state.addressesDb;
      }

      return false;
    },
  },
  actions:{
    async getAddressesBySession({commit}){
      let r = await ax.fetch('/session/addresses');
      if(!r) return;
      commit('mAddressesDb',r); 
      return;
    },
  },  
  mutations:{
    mAddressesDb: (state,data) => {return state.addressesDb = data;},
  },
};

export default checkout;