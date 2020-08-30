import jugeVuex from './../juge-vuex.js'

let user = new jugeVuex('user');


//State
//
//Getters
//
//Actions
user.actions.postComment = async ({dispatch,state},data)=>{
  let r = await ax.fetch('/user/comment',data,'post');  
  dispatch('fetchOne',state.id);
};
//Mutations
//



export default user;