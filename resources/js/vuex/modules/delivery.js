let delivery = {
  state: {
    //Deliveries
    deliverys: [],
    deliverysPages:false,
    //Delivery
    delivery:{},    
  },
  getters: {
    getDeliverys : (state) => {
      return state.deliverys;
    },
    getDeliverysPages : (state) => {
      return state.deliverysPages;
    },    
  },
  actions:{
    async fetchDeliverys({commit}){
      let r = await ax.fetch('/json/deliveries/',{status:1});
      
      console.log(r);
      

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
      commit('mDeliveries',data);
      commit('mDeliveriesPages',pages);

    },
    async putReturn({dispatch}, data){    
      let r = await ax.fetch('/return/item',{itemId:data.item.id,quantity:data.quantity},'put');
      dispatch('order/fetchOne');
    },
    async deleteReturn({dispatch}, id){
      let r = await ax.fetch('/return/item',{id},'delete');
      dispatch('order/fetchOne');
    },    
    async deleteDelivery({dispatch},id){
      let r = await ax.fetch('/delivery/',{id},'delete');
      dispatch('order/fetchOne');
    },
    async putDelivery(){
      //
    },
    
  },  
  mutations:{
    mDeliveries: (state,data) => {return state.deliverys = data;},
    mDeliveriesPages: (state,data) => {return state.deliverysPages = data;},
  },  
};

export default delivery;