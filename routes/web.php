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

// admin routes

Route::get('admin', 'AdminController@index')->name('admin.dashboard');
Route::post('admin', 'AdminController@store');
Route::put('admin/{admin}', 'AdminController@update');
Route::delete('admin/{admin}', 'AdminController@destroy');
Route::get('get_admin/{admin}', 'AdminController@show');
Route::get('get_admins', 'AdminController@get_admins');
Route::post('add_permission/{admin}', 'AdminController@add_permission');
Route::delete('delete_permission/{admin}', 'AdminController@delete_permission');
Route::get('admin/navbars', 'AdminController@navbars');
Route::get('admin/permited_navbars/{admin}', 'AdminController@permited_navbars');
Route::get('admin/navbargroup', 'AdminController@navbargroup');
Route::get('admin/login', 'Auth\AdminLoginController@ShowLoginForm')->name('admin.login');
Route::post('admin/login', 'Auth\AdminLoginController@login')->name('admin.login.attempt');
Route::get('admin/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

// --------Departments-----------
Route::get('department/exam/{department}', 'DepartmentController@exam')->middleware('authadm:admin');;
Route::resource('department', 'DepartmentController', ['except' => ['edit', 'create']])->middleware('authadm:admin');;
// --------Courses-----------
Route::get('getcourse/{course}', 'CourseController@getcourse');
Route::get('coursequestions/{course}', 'CourseController@questions');
Route::resource('course', 'CourseController', ['except' => ['edit', 'create']]);
// --------sections-----------
Route::get('sectionquestions/{section}', 'CourseSectionController@questions');
Route::resource('section', 'CourseSectionController', ['except' => ['edit', 'create']]);
// --------questions-----------
Route::resource('question', 'QuestionController', ['except' => ['edit', 'create']])->middleware('authadm:admin');
// --------Exam-----------
Route::post('exam/coursesection', 'ExamController@coursesection');
Route::get('exam/deletesection/{section}', 'ExamController@deletesection');
Route::get('exam/sections/{exam}', 'ExamController@sections');
Route::get('exam/{exam}/{course}', 'ExamController@course');
Route::resource('exam', 'ExamController', ['except' => ['edit', 'create']]);

// --------Students-----------
Route::get('/', 'HomeController@index');
// Route::get('/', 'Auth\StudentsLoginController@ShowLoginForm')->name('student');
Route::get('student', 'StudentController@index')->name('student.dashboard');
Route::post('student/login', 'Auth\StudentsLoginController@login')->name('student.login');
Route::get('student/logout', 'Auth\StudentsLoginController@logout')->name('student.logout');

// ------------ Library ------------- 
Route::get('library', 'Library\HomeController@index')->name('lib.home');
Route::get('library/admin', 'Library\Admin\HomeController@index')->name('lib.admin.dashboard');
Route::get('library/admin/login', 'Library\Admin\LoginController@showLoginForm')->name('lib.admin.loginform');
Route::post('library/admin/login', 'Library\Admin\LoginController@login')->name('lib.admin.login');

// Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');
