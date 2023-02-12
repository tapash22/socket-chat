window.Vue = require('vue').default;
import moment from "moment";

Vue.filter('timeformate', function(arg){
  return  moment(arg).format('MMMM Do YYYY, h:mm:ss a');
})