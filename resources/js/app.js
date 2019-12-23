/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");
import "vue-loading-overlay/dist/vue-loading.css";
import {
    Form,
    HasError,
    AlertError
} from "vform";
import moment from "moment";
import VueProgressBar from "vue-progressbar";
import Swal from "sweetalert2";
import VueEditor from "vue2-editor";
import objectToFormData from "./objectodata";
import DataTable from "laravel-vue-datatable";

import Loading from "vue-loading-overlay";

// import pdf from 'vue-pdf';
// import { DataTable } from 'v-datatable-light'
// import Datatable from 'vue2-datatable-component'

window.Form = Form;
window.Swal = Swal;
window.objectToFormData = objectToFormData;

import VueRouter from "vue-router";

Vue.use(Loading);
// Layouts
import Settings from "./components/Settings.vue";
import NavbarTop from "./components/nav/NavbarTop.vue";
import DataButtonVue from "./components/tags/DataButton.vue";
import InputTag from "./components/tags/InputTag.vue";

// Admin
import Dashboard from "./components/admin/Dashboard.vue";
import NavbarSide from "./components/admin/NavbarSide.vue";
import StaffPermission from "./components/admin/StaffPermission.vue";

// Students
import StuDashbaord from "./components/students/Dashboard.vue";
import UploadStudents from "./components/students/UploadStudents.vue";
import StuSideNav from "./components/students/StuSideNav.vue";

// CBT
import Department from "./components/cbt/nav-pages/Department.vue";
import Courses from "./components/cbt/nav-pages/Courses.vue";
import SectionQuestions from "./components/cbt/nav-pages/SectionQuestions.vue";
import ExamQuestions from "./components/cbt/nav-pages/ExamQuestions.vue";
import CreateExam from "./components/cbt/nav-pages/CreateExam.vue";
import CreateStaff from "./components/cbt/nav-pages/CreateStaff.vue";
import ExamPage from "./components/cbt/ExamPage.vue";
import ExamInfo from "./components/cbt/ExamInfo.vue";
import Calculator from "./components/cbt/CalculatorComp.vue";
import ExamTimer from "./components/cbt/ExamTimer.vue";
import QuestionOptions from "./components/cbt/exam-elem/QuestOptions.vue";
import QuestionsNo from "./components/cbt/exam-elem/QuestionsNo.vue";
import ExamResult from "./components/cbt/ExamResult.vue";

// Library
import LibHome from "./components/library/LibHome.vue";
import LibDashboard from "./components/library/admin/Dashboard.vue";
import LibNavbarSide from "./components/library/admin/NavbarSide.vue";
import LibUploadNewbook from "./components/library/UploadNewbook.vue";
import Resources from "./components/library/Resources.vue";
import ResourceType from "./components/library/ResourceType.vue";
import ReadResource from "./components/library/Read.vue";
import Books from "./components/library/Books.vue";
// import Viewer from './components/library/Viewer.vue';

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

Vue.use(VueProgressBar, {
    color: "#0f442e",
    failedColor: "#810412",
    thickness: "8px"
});
Vue.use(DataTable);
Vue.use(VueEditor);
const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000
});
// Vue.use(Datatable);
Vue.filter("upText", function (text) {
    return text.charAt(0).toUpperCase() + text.slice(1);
});
Vue.filter("myDate", function (created) {
    return moment(created).format("MMMM Do YYYY");
});
Vue.filter("myTime", function (created) {
    return moment(created, "hhmma").format("h:m A");
});

window.Toast = Toast;
window.DataButtonVue = DataButtonVue;

const routes = [{
        path: "/departments",
        component: Department
    },
    {
        path: "/courses",
        component: Courses
    },
    {
        path: "/section-questions",
        component: SectionQuestions
    },
    {
        path: "/exam-questions",
        component: ExamQuestions
    },
    {
        path: "/create-exam",
        component: CreateExam
    },
    {
        path: "/exam-result",
        component: ExamResult
    },
    {
        path: "/create-staff",
        component: CreateStaff
    },
    {
        path: "/staff-permission",
        component: StaffPermission
    },
    {
        path: "/upload-students",
        component: UploadStudents
    },
    // library
    // {path: '/libadmin-dashbaord', component: LibDashboard},
    {
        path: "/upload-newbook",
        component: LibUploadNewbook
    },
    {
        path: "/resources",
        component: Resources
    },
    {
        path: "/resource-type",
        component: ResourceType
    }
];

const router = new VueRouter({
    routes
});
Vue.use(VueRouter);

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

// Vue.component('DataTable', DataTable);
// Vue.component('DataTableExample', DataTableExample);

// Vue.component('departments', Department);
// Vue.component('courses', Courses);
// Vue.component('section-questions', SectionQuestions);
// Vue.component('exam-questions', ExamQuestions);
// Vue.component('create-exam', CreateExam);
// Vue.component('create-staff', CreateStaff);
// Vue.component('staff-permission', StaffPermission);
// Vue.component('upload-students', UploadStudents);

Vue.component("navbar-side", NavbarSide);
Vue.component("navbar-top", NavbarTop);
Vue.component("admin-dashbaord", Dashboard);
Vue.component("settings", Settings);
Vue.component("input-tag", InputTag);
// Vue.component('pdf', pdf);

// Students components
Vue.component("student-dashbaord", StuDashbaord);
Vue.component("stu-side-nav", StuSideNav);

// CBT
Vue.component("exam-page", ExamPage);
Vue.component("exam-info", ExamInfo);
Vue.component("calculator", Calculator);
Vue.component("exam-timer", ExamTimer);
Vue.component("question-option", QuestionOptions);
Vue.component("question-no", QuestionsNo);
// Library
Vue.component("library-home", LibHome);
Vue.component("libadmin-dashbaord", LibDashboard);
Vue.component("libadmin-navbarside", LibNavbarSide);
Vue.component("read-resource", ReadResource);
Vue.component("books", Books);
// Vue.component('pdf-viewer', Viewer);

// Vue.component('upload-newbook', LibUploadNewbook);
// Vue.component('admin-dashbaord', require('./components/Dashboard.vue').default);
// Vue.component('departments', require('./components/nav-pages/Department.vue').default);

var app = new Vue({
    el: ".vue-app",
    router
});
