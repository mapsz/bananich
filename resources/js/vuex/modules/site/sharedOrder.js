import jugeVuex from './../../juge-vuex.js'
let sharedOrder = new jugeVuex('SharedOrder');

//State
sharedOrder.state.order = false;
sharedOrder.state.myOrder = false;

//Getter
sharedOrder.getters.getOrder = (state) => {return state.order;};
sharedOrder.getters.getMyOrder = (state) => {return state.myOrder;};

//Actions
sharedOrder.actions.byAuth = async ({commit})=>{
    let r = await ax.fetch('/shared/order/auth');

    commit('mMyOrder',r);
    return r;
    // dispatch('fetchData');
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



export default sharedOrder;