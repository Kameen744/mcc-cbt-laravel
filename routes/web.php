<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// CBT admin routes
Route::get('cbt/admin',                             
'Cbt\AdminController@index')->name('admin.dashboard');

Route::post('cbt/admin', 
'Cbt\AdminController@store');

Route::put('cbt/admin/{admin}', 
'Cbt\AdminController@update');

Route::delete('cbt/admin/{admin}', 
'Cbt\AdminController@destroy');

Route::get('cbt/get_admin/{admin}', 
'Cbt\AdminController@show');

Route::get('cbt/get_admins', 
'Cbt\AdminController@get_admins');

Route::post('cbt/add_permission/{admin}', 
'Cbt\AdminController@add_permission');

Route::delete('cbt/delete_permission/{admin}', 
'Cbt\AdminController@delete_permission');

Route::get('cbt/admin/navbars', 
'Cbt\AdminController@navbars');

Route::get('cbt/admin/permited_navbars/{admin}', 
'Cbt\AdminController@permited_navbars');

Route::get('cbt/admin/navbargroup', 
'Cbt\AdminController@navbargroup');

Route::get('cbt/admin/login', 
'Cbt\AdminLoginController@ShowLoginForm')->name('admin.login');

Route::post('cbt/admin/login', 
'Cbt\AdminLoginController@login')->name('admin.login.attempt');

Route::get('cbt/admin/logout', 
'Cbt\AdminLoginController@logout')->name('admin.logout');

// --------Departments-----------
Route::get('cbt/department/exam/{department}', 
'Cbt\DepartmentController@exam');

Route::resource('cbt/department', 
'Cbt\DepartmentController', ['except' => ['edit', 'create']]);
// --------Courses-----------
Route::get('cbt/getcourse/{course}', 
'Cbt\CourseController@getcourse');

Route::get('cbt/coursequestions/{course}', 
'Cbt\CourseController@questions');

Route::resource('cbt/course', 
'Cbt\CourseController', ['except' => ['edit', 'create']]);
// --------sections-----------
Route::get('cbt/sectionquestions/{section}', 
'Cbt\CourseSectionController@questions');

Route::resource('cbt/section', 
'Cbt\CourseSectionController', ['except' => ['edit', 'create']]);
// --------questions-----------
Route::resource('cbt/question', 
'Cbt\QuestionController', ['except' => ['edit', 'create']]);
// --------Exam-----------
Route::post('cbt/exam/coursesection', 
'Cbt\ExamController@coursesection');

Route::get('cbt/exam/deletesection/{section}', 
'Cbt\ExamController@deletesection');

Route::get('cbt/exam/sections/{exam}', 
'Cbt\ExamController@sections');

Route::get('cbt/exam/{exam}/{course}', 
'Cbt\ExamController@course');

Route::resource('cbt/exam', 
'Cbt\ExamController', ['except' => ['edit', 'create']]);

// --------Students-----------
Route::get('/', 'HomeController@index');
// Route::get('/', 'Auth\StudentsLoginController@ShowLoginForm')->name('student');
Route::get('cbt', 'Cbt\StudentsLoginController@login');

Route::get('student', 
'Cbt\StudentController@index')->name('student.dashboard');

Route::post('student/login', 
'Cbt\StudentsLoginController@login')->name('student.login');

Route::get('student/logout', 
'Cbt\StudentsLoginController@logout')->name('student.logout');

// ------------ Library ------------- 
Route::get('library', 
'Library\HomeController@index')->name('lib.home');

Route::get('library/admin', 
'Library\Admin\HomeController@index')->name('lib.admin.dashboard');

Route::get('library/admin/login', 
'Library\Admin\LoginController@showLoginForm')->name('lib.admin.loginform');

Route::post('library/admin/login', 
'Library\Admin\LoginController@login')->name('lib.admin.login');

Route::get('library/admin/logout', 
'Library\Admin\LoginController@logout')->name('lib.admin.logout');

Route::get('library/department', 
'Library\LibResourceController@res_department');

Route::resource('library/res_type', 
'Library\LibResourceTypeController', ['except' => ['edit', 'create', 'show']]);
// Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');
