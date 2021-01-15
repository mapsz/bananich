import jugeVuex from './../../juge-vuex.js'
let sharedOrder = new jugeVuex('SharedOrder');

//State
sharedOrder.state.order = false;
sharedOrder.state.myOrder = false;
sharedOrder.state.inviteOrder = false;

//Getter
sharedOrder.getters.getOrder = (state) => {return state.order;};
sharedOrder.getters.getMyOrder = (state) => {return state.myOrder;};
sharedOrder.getters.getInviteOrder = (state) => {return state.inviteOrder;};
sharedOrder.getters.getInviteLink = (state) => {
  if(state.inviteOrder == undefined || !state.inviteOrder || state.inviteOrder.length == 0 || state.inviteOrder.link == undefined) return false
  return state.inviteOrder.link;
};

//Actions
sharedOrder.actions.byAuth = async ({commit})=>{
    let r = await ax.fetch('/shared/order/auth');

    commit('mMyOrder',r);
    return r;
};
sharedOrder.actions.fetchInviteOrder = async ({commit})=>{

  if(!window.Cookies.get('x_invite')){
    commit('mInviteOrder',false);
    return false;
  }

  let r = await await ax.fetch('/juge', {'link':window.Cookies.get('x_invite'), 'single':true, 'model':'SharedOrder', 'actual':true, 'noHandle':true});

  commit('mInviteOrder',r);
  return r;
};
sharedOrder.actions.update = async ({state,dispatch})=>{
    let r = await ax.fetch('/shared/order/update?id=' + state.rows[0].id);
    dispatch('fetchData');
    return;
};
sharedOrder.actions.fetchOrder = async ({commit}, link)=>{
    let r = await ax.fetch('/shared/order/order',{'link':link});
    commit('mOrder',r);
    return;
};
sharedOrder.actions.handle = async ({commit}, link)=>{
    await ax.fetch('/shared/order/handle');
    return;
};

//Mutations
sharedOrder.mutations.mOrder = (state,d) => {return state.order = d;};
sharedOrder.mutations.mMyOrder = (state,d) => {return state.myOrder = d;};
sharedOrder.mutations.mInviteOrder = (state,d) => {return state.inviteOrder = d;};



export default sharedOrder;