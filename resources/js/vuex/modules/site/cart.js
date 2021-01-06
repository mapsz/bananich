import { isXMLDoc } from "jquery";

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
    async fetch({commit,dispatch}){
      //Set type
      let type = 1;
      if(isX) type = 'x';

      //Get server Cart
      let serverCart = await ax.fetch('/json/cart',{type},'get',false);

      //Get local Cart
      let localCart = false;      
      try {
        localCart = JSON.parse(localStorage.cart);
      }catch(e){}

      //Set From Local
      if(
        localCart &&
        (localCart.id != serverCart.id) && 
        localCart.items != undefined &&
        localCart.items.length > 0 &&
        localCart.type == serverCart.type
      ){
        serverCart = await ax.fetch('/cart/from/local',{'cart_id':localCart.id},'put',false);
      }

      //Save cart
      localStorage.cart = JSON.stringify(serverCart);
      commit('mCart',serverCart); 

      return;

      //Save to local
      if(
          localCart.items == undefined  || 
          localCart.items.length < 1    ||
          serverCart.items.length > 0
        ){
        localStorage.cart = JSON.stringify(serverCart);
        commit('mCart',serverCart); 
        return;
      } 

    
      //Set from local
      if(localCart.items.length > 0){        

        let newCart = await ax.fetch('/cart/session',{
          'id':localCart.id,
          'session_id':localCart.session_id,
          'user_id':localCart.user_id
        },'post');

        if(newCart){
          localStorage.cart = JSON.stringify(newCart);
          commit('mCart',newCart); 
          return;
        }

      }

      //Save to local
      localStorage.cart = JSON.stringify(r);
      commit('mCart',r); 
      return;
      

    },
    async editItem({commit,state,dispatch},data){
      data.cart_id = state.cart.id;
      let r = await ax.fetch('/cart/edit/item',data,'post',false);
      if(r){
        // //Find cart
        // let cart = JSON.parse(JSON.stringify(state.cart));
        // let index = cart.items.findIndex(x => x.product_id == data.id);

        // //Fetch if error
        // if(index == -1){
        //   dispatch('fetch');
        //   return;
        // }

        // //Set new count
        // cart.items[index].count = data.count;

        //Commit
        dispatch('fetch');

        return true;
      }
      return false;
    },
    async removeItem({dispatch},id){
      //Set type
      let type = false;
      if(isX) type = 'x';
      //Getch
      let r = await ax.fetch('/cart/remove/item',{id,type},'delete');
      dispatch('fetch');
      return r;
    },    
    async cartReset({dispatch},){
      let r = await ax.fetch('/cart/reset',{},'delete');
      localStorage.cart = false;
      dispatch('fetch');
    },
    async editContainer({commit},id){
      let r = await ax.fetch('/cart/container',{id},'post',false);
      commit('mCart',r);
      return r;
    },
    async removeContainer({commit}){
      let r = await ax.fetch('/cart/container',{},'delete',false);
      commit('mCart',r); 
      return r;
    }, 
  },  
  mutations:{
    mCart: (state,data) => {return state.cart = data;},
  },
};

export default cart;