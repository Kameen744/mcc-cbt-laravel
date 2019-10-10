/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import { Form, HasError, AlertError} from 'vform';
import moment from 'moment';
import VueProgressBar from 'vue-progressbar';
import Swal from 'sweetalert2';
import VueEditor from 'vue2-editor';
import objectToFormData from './objectodata';
// import { DataTable } from 'v-datatable-light'
// import Datatable from 'vue2-datatable-component'

window.Form = Form;
window.Swal = Swal;
window.objectToFormData = objectToFormData;
// import VueRouter from 'vue-router';
// Vue.use(VueRouter);

// components
import Dashboard from './components/Dashboard.vue';
import Settings from './components/Settings.vue';
import NavbarSide from './components/nav/NavbarSide.vue';
import NavbarTop from './components/nav/NavbarTop.vue';

// import DataTableExample from './components/nav/DataTableExample.vue';

import Department from './components/nav-pages/Department.vue';
import Courses from './components/nav-pages/Courses.vue';
import SectionQuestions from './components/nav-pages/SectionQuestions.vue';
import ExamQuestions from './components/nav-pages/ExamQuestions.vue';
import CreateExam from './components/nav-pages/CreateExam.vue';
import CreateStaff from './components/nav-pages/CreateStaff.vue';
import StaffPermission from './components/nav-pages/StaffPermission.vue';
import UploadStudents from './components/nav-pages/UploadStudents.vue';

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

Vue.use(VueProgressBar, {
    color: '#0f442e',
    failedColor: '#810412',
    thickness: '5px' 
});
Vue.use(VueEditor);
    const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
// Vue.use(Datatable);
Vue.filter('upText', function(text) {
    return text.charAt(0).toUpperCase() + text.slice(1);
});
Vue.filter('myDate', function(created) {
    return moment(created).format('MMMM Do YYYY');
});
Vue.filter('myTime', function(created) {
    return moment(created, 'hhmma').format('h:m A');
});

window.Toast = Toast;

// const routes = [
//     {path: '/departments', component: Department},
//     {path: '/courses', component: Courses},
//     {path: '/section-questions', component: SectionQuestions},
//     {path: '/exam-questions', component: ExamQuestions},
//     {path: '/create-exam', component: CreateExam},
//     {path: '/create-staff', component: CreateStaff},
//     {path: '/staff-permission', component: StaffPermission},
//     {path: '/upload-students', component: UploadStudents}
// ];

// const router = new VueRouter({
//     routes
// });

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// Vue.component('admin-dashbaord', Dashboard.default);

Vue.component('navbar-side', NavbarSide);
Vue.component('navbar-top', NavbarTop);

// Vue.component('DataTable', DataTable);
// Vue.component('DataTableExample', DataTableExample);

Vue.component('departments', Department);
Vue.component('courses', Courses);
Vue.component('section-questions', SectionQuestions);
Vue.component('exam-questions', ExamQuestions);
Vue.component('create-exam', CreateExam);
Vue.component('create-staff', CreateStaff);
Vue.component('staff-permission', StaffPermission);
Vue.component('upload-students', UploadStudents);
Vue.component('admin-dashbaord', Dashboard);
Vue.component('settings', Settings);
// Vue.component('admin-dashbaord', require('./components/Dashboard.vue').default);
// Vue.component('departments', require('./components/nav-pages/Department.vue').default);

var app = new Vue({
    el: '.vue-app',
    // router,
});
