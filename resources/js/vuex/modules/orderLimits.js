let orderLimits = {
  namespaced: true,

  state: {  
    calendar:false,
    settings:false,
    availableDays:false,
  },
  getters: {   
    getCalendar : (state) => {
      return state.calendar;
    },
    getSettings : (state) => {
      return state.settings;
    }, 
    getAvailableDays : (state) => {
      return state.availableDays;
    }, 
  },
  actions:{
    async fetchCalendar({commit}){
      let r = await ax.fetch('/orders/calendar');
      commit('mCalendar',r); 
    },
    async fetchSettings({commit}){
      let r = await ax.fetch('/order/limit/settings');
      commit('mSettings',r); 
    },
    async fetchAvailableDays({commit},polygons = false){
      //Set type
      let type = false;
      if(isX) type = 'x';
      //Fetch
      let r = await ax.fetch('/order/available/days',{type,polygons});
      commit('mAvailableDays',r); 
    },
  },  
  mutations:{
    mCalendar: (state,data) => {return state.calendar = data;},
    mSettings: (state,data) => {return state.settings = data;},
    mAvailableDays: (state,data) => {return state.availableDays = data;},
  },
};

export default orderLimits;