import jugeVuex from './../juge-vuex.js'

let order = new jugeVuex('order');


//State
order.state.toConfirm = {};
//Getters
order.getters.getToConfirm = (state) => {return state.toConfirm;},
//Actions
order.actions.putStatus = async ({dispatch,state},statusId)=>{
  let r = await ax.fetch('/order/status',{statusId,orderId:state.id},'put');  
  dispatch('fetchOne',state.id);
};
order.actions.fetchToConfirm = async ({state,commit})=>{
  let r = await ax.fetch('/to/confirm/orders',{id:state.id});  
  commit('mToConfirm',r);
};
order.actions.setReturned = async ({dispatch})=>{
  dispatch('putStatus',100);
};
//Mutations
order.mutations.mToConfirm = async (state,d) => {return state.toConfirm = d;},


console.log(order);

export default order;