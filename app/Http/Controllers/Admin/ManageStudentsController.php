<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Student\Student;
// use App\ExcelImport\XlsxImport;
use Illuminate\Http\Request;
use App\CustomClasses\DataTableRes;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
// use Maatwebsite\Excel\Facades\Excel;

class ManageStudentsController extends Controller
{
    public function __construct()
    { 
        $this->middleware('authadm:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, DataTableRes $DataTable, Student $student)
    {
        return $DataTable->get_collections($request, $student);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['department_id' => 'required']);
        $insertData = [];
        function makeVnNumber($studentName) {
            return strtoupper(substr($studentName, 0, 2)) .rand(1001, 9999);
        }
        $now = Carbon::now();

        if($request->students) {
            $students = $request->students;
            foreach ($students as $i => $student) { 
                if($i > 0) {
                    $vn_number = makeVnNumber($student[2]);
                    $password = Hash::make($vn_number);
                    $row = [
                        'app_number'        => $student[1],
                        'fullname'          => $student[2],
                        'gender'            => $student[3],
                        'state_of_origin'   => $student[4],
                        'lga_of_origin'     => $student[5],
                        'email'             => $student[6],
                        'phone'             => $student[7],
                        'mode_of_entry'     => $student[8],
                        'first_choice'      => $student[9],
                        'second_choice'     => $student[10],
                        'o_level_1'         => $student[11],
                        'o_level_2'         => $student[12],
                        'department_id'     => $request->department_id,
                        'vn_number'         => $vn_number,
                        'password'          => $password,
                        'created_at'        => $now,
                        'updated_at'        => $now
                    ];
                    array_push($insertData, $row);
                } 
            }
                
            try {
                    Student::insert($insertData);
                    return 'Successfully uploaded ' .count($insertData) .' students';
            } catch (\Throwable $th) {
                return 'There\'s a duplicate or empty column in your file';
            }
        } else {
            $data = $this->validate($request, [
                'app_number'        => 'required',
                'fullname'          => 'required',
                'gender'            => 'required',
                'state_of_origin'   => 'required',
                'lga_of_origin'     => 'required',
                'email'             => 'required',
                'phone'             => 'required',
                'mode_of_entry'     => 'required',
                'first_choice'      => 'required',
                'second_choice'     => 'required',
                'o_level_1'         => 'required',
                'o_level_2'         => 'required',
                'department_id'     => 'required'
            ]);

            $vn_number = makeVnNumber($data['fullname']);
            $data['vn_number'] = $vn_number;
            $data['password'] = Hash::make($vn_number);
            $data['created_at'] = $now;
            $data['updated_at'] = $now;

            try {
                return Student::create($data);
            } catch (\Throwable $th) {
                return 'Invalid student form';
            }

        }
       
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $data = $this->validate($request, [
            'app_number'        => 'required',
            'fullname'          => 'required',
            'gender'            => 'required',
            'state_of_origin'   => 'required',
            'lga_of_origin'     => 'required',
            'email'             => 'required',
            'phone'             => 'required',
            'mode_of_entry'     => 'required',
            'first_choice'      => 'required',
            'second_choice'     => 'required',
            'o_level_1'         => 'required',
            'o_level_2'         => 'required',
            'department_id'     => 'required'
        ]);

        $student->update($data);
        return $student;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        $student->delete();
        return '';
    }
}
