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
      let r = await ax.fetch('/json/cart',{},'get',false);

      let localCart = JSON.parse(localStorage.cart);

      //Save to local
      if(
          localCart.items == undefined  || 
          localCart.items.length < 1    ||
          r.items.length > 0
        ){
        localStorage.cart = JSON.stringify(r);
        commit('mCart',r); 
        return;
      } 

      //Set from local
      if(localCart.items.length > 0){
        
        let newCart = await ax.fetch('/cart/session',{'id':localCart.id,'session_id':localCart.session_id,'user_id':localCart.user_id},'post');

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

      // if(localStorage.cart == undefined || localStorage.cart == false || localStorage.cart == 'false'){
      //   localStorage.cart = JSON.stringify(r);
      //   return;
      // }

      // let localCart = JSON.parse(localStorage.cart) 

      // if(moment(localCart.updated_at).diff(r.updated_at) > 0 || (r.items.length < 1 && localCart.items.length > 0)){
      //   localCart.session_id = r.session_id;
      //   localCart.user_id = r.user_id;
      //   commit('mCart',localCart); 
      //   //Add items
      //   $.each( localCart.items, ( k, v ) => {
      //     dispatch('editItem',v);
      //   });
      // }else{
      //   localStorage.cart = JSON.stringify(r);
      // }
      

    },
    async editItem({commit,state,dispatch},data){
      data.cart_id = state.cart.id;
      let r = await ax.fetch('/cart/edit/item',data,'post',false);
      if(r){

        //Find cart
        let cart = JSON.parse(JSON.stringify(state.cart));
        let index = cart.items.findIndex(x => x.product_id == data.id);

        //Fetch if error
        if(index == -1){
          dispatch('fetch');
          return;
        }

        //Set new count
        cart.items[index].count = data.count;

        //Commit
        localStorage.cart = JSON.stringify(r);
        commit('mCart',cart); 
        dispatch('fetch');

        return true;
      }
      return false;
    },
    async removeItem({dispatch},id){
      let r = await ax.fetch('/cart/remove/item',{id},'delete');
      dispatch('fetch');
      return r;
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