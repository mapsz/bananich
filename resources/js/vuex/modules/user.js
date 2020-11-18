import jugeVuex from './../juge-vuex.js'

let user = new jugeVuex('user');


{//State
  user.state.auth = false;
}
{//Getters
  user.getters.getAuth = (state) => {return state.auth}
  user.getters.isAdmin = (state) => {
    if(state.auth == undefined || state.auth.roles == undefined) return null;
    if(state.auth.roles[0] == undefined) return false;

    let isRoleAdmin = false;

    $.each(state.auth.roles, (k, role) => {
      if(role.name == 'admin'){
        isRoleAdmin = true;
        return true;
      } 
    });

    return isRoleAdmin;
  }
}
{//Actions
  user.actions.postComment = async ({dispatch,state},data)=>{
    let r = await ax.fetch('/user/comment',data,'post');  
    dispatch('fetchOne',state.id);
  };
  user.actions.fetchAuth = async ({commit}) => {
    let r = await ax.fetch('/auth/user');
    commit('mAuth',r); 
    return;
  };
}
{//Mutations
  user.mutations.mAuth = async (state,d) => {return state.auth = d;};
}



export default user;