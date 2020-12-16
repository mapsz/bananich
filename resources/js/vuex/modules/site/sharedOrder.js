import jugeVuex from './../../juge-vuex.js'
let sharedOrder = new jugeVuex('SharedOrder');

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



export default sharedOrder;