let order = {
  state: {
    //Orders
    orders:[],
    ordersPages:false,
    orderFilters:{},

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
    async fetchOrders({commit,state}){
      //Fetch  
      let r = await ax.fetch('/json/orders/',state.orderFilters);

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
    async refreshOrderFilters({commit}){
      commit('mRefreshOrderFilters');      
    },
  },
  mutations:{
    mOrders: (state,data) => {return state.orders = data;},
    mOrdersPages: (state,pages) => {return state.ordersPages = pages;},
    mRefreshOrderFilters: (state) => {return state.orderFilters = {};},
  }
};

export default order;