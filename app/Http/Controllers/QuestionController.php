<?php

namespace App\Http\Controllers;

use App\Course;
use App\Question;
use Illuminate\Http\Request;
use App\Imports\QuestionImport;
use Maatwebsite\Excel\Facades\Excel;

class QuestionController extends Controller
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
    public function index()
    {
        //
    }

    private function validateData($request)
    {
        $data = $this->validate($request, [
            'course_id' => 'required',
            'section_id' => 'required',
            'question' => 'required',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'answer' => 'required'
        ]);

        return $data;
    }

    public function store(Request $request)
    {
        if($request->file('file')){
            $data = Excel::toArray(new QuestionImport, $request->file('file'));
            return $data;
        } else {
            
            $data = $this::validateData($request);

            Question::create($data);

            return Course::find($request->course_id)->questions;
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(question $question)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, question $question)
    {
        $data = $this::validateData($request);
        $question->update($data);
        return Course::find($request->course_id)->questions;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(question $question)
    {
        $question->delete();
        return Course::find($question->course_id)->questions;
    }
}
