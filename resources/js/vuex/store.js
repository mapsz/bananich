import order from './modules/order'
import delivery from './modules/delivery'
import confirm from './modules/confirm'
import report from './modules/report'
import writeoff from './modules/writeoff'

let store = {  
  modules:{
    order,delivery,confirm,report,writeoff
  }
};

export default store;
