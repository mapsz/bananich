let order = {
  state: {
    //Order
    order: {},
    orders:[],
    //Pages
    ordersPages:false,
    //Filters
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
    async fetchOrder({commit},id){      
      let r = await ax.fetch('/json/orders/',{id});
      commit('mOrder',r);
    },
    async fetchOrders({commit, state}){    
      
    console.log(state.orderFilters);
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
    async setFilter({commit,state, dispatch},filter){
      let key = Object.keys(filter)[0];
      state.orderFilters[key] = filter[key];
      await commit('mOrdersPages',{current_page:1});
      dispatch('fetchOrders');
      
    }
  },
  mutations:{
    mOrder: (state,order) => {return state.order = order;},
    mOrders: (state,orders) => {return state.orders = orders;},
    mOrdersPages: (state,pages) => {return state.ordersPages = pages;},
  }
};





export default order;