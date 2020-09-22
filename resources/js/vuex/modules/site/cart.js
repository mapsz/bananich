let cart = {
  namespaced: true,

  state: {  
    cart:false,
  },
  getters: {   
    getCart : (state) => {
      return state.cart;
    },
  },
  actions:{
    async fetch({commit}){
      let r = await ax.fetch('/json/cart',{},'get',false);
      commit('mCart',r); 
    },
    async editItem({dispatch},data){
      let r = await ax.fetch('/cart/edit/item',data,'post',false);
      dispatch('fetch');      
      return r;
    },
    async removeItem({dispatch},id){
      let r = await ax.fetch('/cart/remove/item',{id},'delete');
      dispatch('fetch');
    },    
    async cartReset({dispatch}){
      let r = await ax.fetch('/cart/reset',{},'delete');
      dispatch('fetch');
    }
  },  
  mutations:{
    mCart: (state,data) => {return state.cart = data;},
  },
};

export default cart;