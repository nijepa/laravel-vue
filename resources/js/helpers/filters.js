import moment from 'moment';
//import moment from "../app";

Vue.filter('upText', (text) => {
    return text.charAt(0).toUpperCase() + text.slice(1);
});

Vue.filter('customDate', (fromDate) => {
    return moment(fromDate).format("MMM Do YYYY");
});

Vue.filter('tableDate', (fromDate) => {
    return moment(fromDate).format("DD MMM YYYY");
});

Vue.filter('customTime', (fromDate) => {
    return moment(fromDate).format("HH:mm");
});

Vue.filter('dayMonthYear', (fromDate) => {
    return moment(fromDate).format("dddd, MMMM Do YYYY");
});

Vue.filter('msgTime', (fromDate) => {
    return moment(fromDate).format("HH:mm, ddd DD");
});
