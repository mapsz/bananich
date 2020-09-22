let cart = {
  namespaced: true,

  state: {  
    cart:false,
    localCart:localStorage.cart,
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


      if(localStorage.cart == undefined || localStorage.cart == false || localStorage.cart == 'false'){
        localStorage.cart = JSON.stringify(r);
        return;
      }

      let localCart = JSON.parse(localStorage.cart) 

      if(moment(localCart.updated_at).diff(r.updated_at) > 0 || (r.items.length < 1 && localCart.items.length > 0)){
        localCart.session_id = r.session_id;
        localCart.user_id = r.user_id;
        commit('mCart',localCart); 
      }else{
        localStorage.cart = JSON.stringify(r);
      }
      

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
      localStorage.cart = false;
      dispatch('fetch');
    }
  },  
  mutations:{
    mCart: (state,data) => {return state.cart = data;},
  },
};

export default cart;