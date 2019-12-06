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
Route::get('admin',                             
'Admin\AdminController@index')->name('admin.dashboard');

Route::post('admin', 
'Admin\AdminController@store');

Route::put('admin/{admin}', 
'Admin\AdminController@update');

Route::delete('admin/{admin}', 
'Admin\AdminController@destroy');

Route::get('get_admin/{admin}', 
'Admin\AdminController@show');

Route::get('get_admins', 
'Admin\AdminController@get_admins');

Route::post('add_permission/{admin}', 
'Admin\AdminController@add_permission');

Route::delete('delete_permission/{admin}', 
'Admin\AdminController@delete_permission');

Route::get('admin/navbars', 
'Admin\AdminController@navbars');

Route::get('admin/permited_navbars/{admin}', 
'Admin\AdminController@permited_navbars');

Route::get('admin/navbargroup', 
'Admin\AdminController@navbargroup');

Route::get('admin/login', 
'Admin\AdminLoginController@ShowLoginForm')->name('admin.login');

Route::post('admin/login', 
'Admin\AdminLoginController@login')->name('admin.login.attempt');

Route::get('admin/logout', 
'Admin\AdminLoginController@logout')->name('admin.logout');

// --------Departments-----------
Route::get('department/exam/{department}', 
'Cbt\DepartmentController@exam');

Route::resource('department', 
'Cbt\DepartmentController', ['except' => ['edit', 'create']]);
// --------Courses-----------
Route::get('getcourse/{course}', 
'Cbt\CourseController@getcourse');

Route::get('coursequestions/{course}', 
'Cbt\CourseController@questions');

Route::resource('course', 
'Cbt\CourseController', ['except' => ['edit', 'create']]);
// --------sections-----------
Route::get('sectionquestions/{section}', 
'Cbt\CourseSectionController@questions');

Route::resource('section', 
'Cbt\CourseSectionController', ['except' => ['edit', 'create']]);
// --------questions-----------
Route::resource('question', 
'Cbt\QuestionController', ['except' => ['edit', 'create']]);
// --------Exam-----------
Route::post('exam/course_section', 
'Cbt\ExamController@course_section');

Route::post('exam_set_dept/{exam}/{department}', 
'Cbt\ExamController@exam_department');

Route::get('exam/del_exam_section/{section}', 
'Cbt\ExamController@del_exam_section');

Route::get('exam/del_exam_department/{exam}/{department}', 
'Cbt\ExamController@del_exam_department');

Route::get('exam/sections/{exam}', 
'Cbt\ExamController@sections');

Route::get('exam/departments/{exam}', 
'Cbt\ExamController@departments');

Route::get('exam/{exam}/{course}', 
'Cbt\ExamController@course');

Route::resource('exam', 
'Cbt\ExamController', ['except' => ['edit', 'create']]);
// --------Students-----------
Route::get('/', 'HomeController@index');
// Route::get('/', 'Auth\StudentsLoginController@ShowLoginForm')->name('student');

Route::get('cbt', 'Students\StudentsLoginController@ShowLoginForm');
Route::get('student', 
'Students\StudentsLoginController@ShowLoginForm')->name('student.loginform');

Route::post('student/login', 
'Students\StudentsLoginController@login')->name('student.login');

Route::get('student/logout', 
'Students\StudentsLoginController@logout')->name('student.logout');

// -----------students Resource ---------------------
Route::get('student/dashboard', 
'Students\StudentController@index')->name('student.dashboard');

Route::get('get_students', 'Admin\ManageStudentsController@index');
Route::post('student', 'Admin\ManageStudentsController@store');
Route::put('student/{student}', 'Admin\ManageStudentsController@update');
Route::delete('student/{student}', 'Admin\ManageStudentsController@destroy');
// ------------ Library ------------- 
Route::get('library', 
'Library\HomeController@index')->name('lib.home');

Route::get('library/get_resources', 'Library\HomeController@get_resource');

// Route::get('library/admin', 
// 'Library\Admin\HomeController@index')->name('lib.admin.dashboard');

// Route::get('library/admin/login', 
// 'Library\Admin\LoginController@showLoginForm')->name('lib.admin.loginform');

// Route::post('library/admin/login', 
// 'Library\Admin\LoginController@login')->name('lib.admin.login');

// Route::get('library/admin/logout', 
// 'Library\Admin\LoginController@logout')->name('lib.admin.logout');

Route::get('library/departments', 
'Library\LibResourceController@res_department');

Route::resource('library/res_type', 
'Library\LibResourceTypeController', ['except' => ['edit', 'create', 'show']]);

Route::get('library/res_type_all', 'Library\LibResourceTypeController@get_all');
Route::get('library/res_count/{res_type}', 'Library\LibResourceTypeController@count_all');

Route::resource('library/resource', 
'Library\LibResourceController', ['except' => ['edit', 'create', 'show']]);
// Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');
