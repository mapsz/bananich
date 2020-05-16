let order = {
  state: {
    //Order
    order: {},
    //Orders
    orders:[],
    ordersPages:false,
    orderFilters:{},

  },
  getters: {
    getOrder : (state) => {
      return state.order;
    },
    getOrderItems : (state) => {
      return state.order.items;
    },
    getOrderStatus : (state) => {
      if(state.order.statuses != undefined){
        return state.order.statuses[0];
      }else{
        return false;
      }      
    },   
    getOrderConfirmType : (state) => {
      return state.order.confirm;      
    },        
    getOrders : (state) => {
      return state.orders;
    },
    getOrdersPages : (state) => {
      return state.ordersPages;
    },
  },
  actions:{
    async fetchOrder({commit,state},id = state.order.id){
      let r = await ax.fetch('/json/orders/',{id});
      commit('mOrder',r);
    },
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
    //Filters
    async setFilter({commit,state,dispatch},filter){
      let key = Object.keys(filter)[0];
      state.orderFilters[key] = filter[key];
      await commit('mOrdersPages',{current_page:1});
      dispatch('fetchOrders');      
    },
    async refreshOrderFilters({commit}){
      commit('mRefreshOrderFilters');      
    },
    //Status
    async putStatus({state,dispatch},id,orderId = state.order.id){
      let r = await ax.fetch('/order/status',{orderId,statusId:id},'put');
      if(!r) return false;
      dispatch('fetchOrder');
    },
    async setOrderReturned({dispatch},$id){
      dispatch('putStatus',100,$id);
    }
  },
  mutations:{
    mOrder: (state,order) => {state.order = order; return true;},
    mOrders: (state,orders) => {return state.orders = orders;},
    mOrdersPages: (state,pages) => {return state.ordersPages = pages;},
    mRefreshOrderFilters: (state) => {return state.orderFilters = {};},
  }
};

export default order;