import order from './modules/order'
import delivery from './modules/delivery'


let store = {  
  modules:{
    order,delivery
  }
};

export default store;


// let store = {
//   state: {
//       data: 10,
//   },
//   getters: {
//     allData : (state) => {
//       return state.data;
//     }
//   },
//   actions:{
//     async fetchData({commit}){
//       let r = await axios('/json/pay/methods');

//       commit('setData',r.data);
//     }
//   },
//   mutations:{
//     setData: (state,data) => {return state.data = data;},
//   }
// };