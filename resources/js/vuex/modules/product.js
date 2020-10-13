import jugeVuex from './../juge-vuex.js'

let product = new jugeVuex('product');

//Actions
product.actions.put = async ({commit},data)=>{
  //Refresh errors
  commit('mErrors',false);

  let r = await ax.fetch('/product',{data},'put');

  //Catch errors
  if(ax.lastResponse.status == 422){
    commit('mErrors',ax.lastResponse.data.errors);
    return false;
  }

  return r;
  
};
product.actions.post = async ({commit},data)=>{
  //Refresh errors
  commit('mErrors',false);

  let r = await ax.fetch('/product',{data},'post');  

  //Catch errors  
  if(ax.lastResponse.status == 422){
    commit('mErrors',ax.lastResponse.data.errors);;
    return false;
  }

  return true;
  
};



export default product;