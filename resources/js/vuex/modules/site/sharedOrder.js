import jugeVuex from './../../juge-vuex.js'
let sharedOrder = new jugeVuex('SharedOrder');

//State
sharedOrder.state.order = false;

//Getter
sharedOrder.getters.getOrder = (state) => {return state.order;};

//Actions
sharedOrder.actions.byAuth = async ({dispatch})=>{
    let r = await ax.fetch('/shared/order/auth');

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



export default sharedOrder;