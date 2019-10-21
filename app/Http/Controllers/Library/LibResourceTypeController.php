<?php

namespace App\Http\Controllers\Library;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Library\LibResourceType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class LibResourceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $orderBy = $request->input('dir', 'asc');
        $searchValue = $request->input('search');
        
        $query = LibResourceType::dataTableQuery($column, $orderBy, $searchValue);
        $data = $query->paginate($length);
        
        return new DataTableCollectionResource($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $data = $this->validate($request, [
            'res_type' => 'required|string|unique:lib_resource_types,res_type|not_regex:~\W~'
        ]);
      
        $path = storage_path().'/app/public/library/' .$data['res_type'];
        if(!$check = File::isDirectory($path)) {
            File::makeDirectory($path, true, true) ? $data['path'] = $path : $data = [];
        }
        
        return LibResourceType::create($data);
       
        // $store = Storage::disk('library');
        // return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Library\LibResourceType  $libResourceType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LibResourceType $res_type)
    {
        $data = $this->validate($request, [
            'res_type' => 'required'
        ]);

        $path = storage_path().'/app/public/library/' .$data['res_type'];
        
        File::moveDirectory($res_type->path, $path) ? $data['path'] = $path : $data = [];

        $res_type->update($data);
        return $res_type;
    }
    // Storage::putFileAs('photos', new File('/path/to/photo'), 'photo.jpg');
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Library\LibResourceType  $libResourceType
     * @return \Illuminate\Http\Response
     */
    public function destroy(LibResourceType $res_type)
    {
        File::deleteDirectory($res_type->path);
        $res_type->delete();
        return $res_type;
    }

}
