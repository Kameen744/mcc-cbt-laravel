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

    public function get_resource($take = 15)
    {
        // $exc = null;

        // $types = LibResourceType::all();
        // for($i=0; $i<count($types); $i++) {
        //     $exc = $res->where('res_type_id', $types[$i])->take($take)
        //     ->union()
        // }
        
        
            // $book = LibResource::first();
            // $file = storage_path().'/app/public/library/Books/' .$book->res_files;
            // $handle = file_get_contents($file);
            // //  Pdf::getText();
            // $read = file_get_contents($file);
            // dd($handle);
            // dd(base_path());
        $resources = LibResource::paginate($take);
        $resources['resource_path'] = base_path();
        // dd($resources);
        return $resources;
        // $type1 = Model::whereType(1)->take($take);
        // $type2 = Model::whereType(2)->take($take);
        // $type3 = Model::whereType(3)->take($take);

        // $types = $type1->union($type2)->union($type3)->get();
        
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
