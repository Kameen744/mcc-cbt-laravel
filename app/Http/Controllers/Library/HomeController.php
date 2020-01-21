<?php

namespace App\Http\Controllers\Library;

use App\Library\LibResource;
use Illuminate\Http\Request;
use App\Library\LibResourceType;
use App\CustomClasses\DataTableRes;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
// use Spatie\PdfToText\Pdf;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('library.home');
    }

    // public function get_resource(Request $request, DataTableRes $DataTable, LibResource $LibRes)
    // {
    //     return $DataTable->get_collections($request, $LibRes);
    // }

    public function get_resource()
    {
        return LibResource::paginate();
    }

    public function get_resource_by_type(LibResourceType $res_type)
    {
        return $res_type->lib_res()->paginate();   
    }

    public function get_resource_by_search($search_text) 
    {
        // res_title, res_author, res_subject
       return LibResource::where('res_title', 'like', '%' .$search_text .'%') 
            -> orWhere('res_author', 'like', '%' .$search_text .'%')
            -> orWhere('res_subject', 'like', '%' .$search_text .'%')
            -> paginate();
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
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
