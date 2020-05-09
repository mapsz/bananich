let order = {
  state: {
    order: {},
    orders:[],
  },
  getters: {
    getOrder : (state) => {
      return state.order;
    }
  },
  actions:{
    async fetchOrder({commit},id){      
      let r = await ax.fetch('/json/orders/',{id});
      commit('getOrder',r);
    },
    async fetchOrders({commit},id){      
      let r = await ax.fetch('/json/orders/');
      commit('getOrder',r);
    },
  },
  mutations:{
    getOrder: (state,order) => {return state.order = order;},
  }
};





export default order;