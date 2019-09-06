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
Route::get('admin/navbars', 'AdminController@navbars');
Route::get('admin/navbargroup', 'AdminController@navbargroup');
Route::get('admin/login', 'Auth\AdminLoginController@ShowLoginForm')->name('admin.login');
Route::post('admin/login', 'Auth\AdminLoginController@login')->name('admin.login.attempt');
Route::get('admin/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

// departments

// Route::get('admin/department', 'DepartmentController@index');
// Route::post('admin/department', 'DepartmentController@store');
// Route::get('admin/department/{department}', 'DepartmentController@show');
// Route::get('admin/department/{department}/edit', 'DepartmentController@edit');
// Route::get('admin/department/')

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
Route::get('/', 'Auth\StudentsLoginController@ShowLoginForm')->name('student');
Route::get('student', 'StudentController@index')->name('student.dashboard');
Route::post('student/login', 'Auth\StudentsLoginController@login')->name('student.login');
Route::get('student/logout', 'Auth\StudentsLoginController@logout')->name('student.logout');


// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
