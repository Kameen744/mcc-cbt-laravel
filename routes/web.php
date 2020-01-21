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
// --------Public Home page-----------
Route::get('/', 'HomeController@index');

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

Route::post('upload_question',
'Cbt\QuestionController@upload_question');
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

Route::get('department_exams/{department}', 'Cbt\ExamController@department_exams');
Route::get('exam_scores/{department}/{exam}', 'Cbt\ExamController@exam_scores');

// --------Exam / login -----------
Route::get('cbt', 'Cbt\CbtController@index')->name('exam');

Route::get('cbt/login', 'Cbt\CbtLoginController@showLoginForm')->name('exam.login.form');

Route::post('cbt/login', 'Cbt\CbtLoginController@login')->name('exam.login');

Route::get('cbt/logout', 'Cbt\CbtLoginController@logout')->name('exam.logout');

Route::get('get_exams/{department}', 'Cbt\CbtController@get_exams');
Route::get('get_course_questions/{student}/{exam}/{course}', 'Cbt\CbtController@get_course_questions');
Route::post('get_attempted', 'Cbt\CbtController@get_attempted');

Route::post('attempt', 'Cbt\CbtController@attempt');

// Route::get('cbt/exam', 
// 'Students\StudentController@examdashboard')->name('exam.dashboard');

// --------Students / Login -----------
Route::get('student', 
'Students\StudentController@index')->name('student.dashboard');

Route::get('student/login', 
'Students\StudentsLoginController@ShowLoginForm')->name('student.loginform');

Route::post('student/login', 
'Students\StudentsLoginController@login')->name('student.login');

Route::get('student/logout', 
'Students\StudentsLoginController@logout')->name('student.logout');



// -----------students Resource ---------------------
Route::get('get_students', 'Admin\ManageStudentsController@index');
Route::get('get_department_students/{department}', 
'Admin\ManageStudentsController@get_department_students');
Route::post('student', 'Admin\ManageStudentsController@store');
Route::put('student/{student}', 'Admin\ManageStudentsController@update');
Route::delete('student/{student}', 'Admin\ManageStudentsController@destroy');
// ------------ Library ------------- 

Route::get('library', 
'Library\HomeController@index')->name('lib.home');

Route::get('library/get_resources', 'Library\HomeController@get_resource');
Route::get('library/get_resources/by_type/{res_type}', 'Library\HomeController@get_resource_by_type');
Route::get('library/get_resources/by_search/{search_text}', 'Library\HomeController@get_resource_by_search');
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
