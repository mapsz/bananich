let delivery = {
  state: {
    //Deliveries
    deliveries: [],
    //Delivery
    delivery:{},    
  },
  getters: {
    getDeliveries : (state) => {
      return state.deliveries;
    }
  },  
  mutations:{
    mDeliveries: (state,deliveries) => {return state.deliveries = deliveries;},
  },
  actions:{
    async fetchDeliveries({commit}){      

      let r = await ax.fetch('/json/deliveries/',{
        status:1,
      });
      commit('mDeliveries',r);
    },
  },
};

export default delivery;