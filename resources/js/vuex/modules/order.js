let order = {
  state: {
    order: {},
    orders:[],
    ordersPages:false,
  },
  getters: {
    getOrder : (state) => {
      return state.order;
    },
    getOrders : (state) => {
      return state.orders;
    },
    getOrdersPages : (state) => {
      return state.ordersPages;
    },
  },
  actions:{
    async fetchOrder({commit},id){      
      let r = await ax.fetch('/json/orders/',{id});
      commit('mOrder',r);
    },
    async fetchOrders({commit}){    
      //Fetch  
      let r = await ax.fetch('/json/orders/');

      // Get pages
      let pages = false;
      // console.log(r);
      if(r.current_page != undefined){
        pages = JSON.parse(JSON.stringify(r));
        pages.data = null;
      }

      //Get data
      let data = r;
      if(r.current_page != undefined){
        data = r.data;
      }

      //Mutate
      commit('mOrders',data);
      commit('mOrdersPages',pages);
    },
  },
  mutations:{
    mOrder: (state,order) => {return state.order = order;},
    mOrders: (state,orders) => {return state.orders = orders;},
    mOrdersPages: (state,pages) => {return state.ordersPages = pages;},
  }
};





export default order;