import jugeVuex from './../juge-vuex.js'

let product = new jugeVuex('product');

//Actions
product.actions.put = async ({commit},data)=>{
  //Refresh errors
  commit('mErrors',false);

  let r = await ax.fetch('/product',{data},'put');

  //Catch errors
  if(ax.lastResponse.status == 422){
    console.log(ax.lastResponse.data.errors);
    commit('mErrors',ax.lastResponse.data.errors);
    return;
  }

  return r;
  
};
product.actions.post = async ({commit},data)=>{
  //Refresh errors
  commit('mErrors',false);

  let r = await ax.fetch('/product',{data},'post');  
  // dispatch('fetchOne',state.id);



  console.log(ax);
  
};



export default product;