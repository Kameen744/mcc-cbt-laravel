<?php

namespace App\Http\Controllers\Library;

use App\Library\LibResource;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Library\LibResourceType;
use App\CustomClasses\DataTableRes;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\CustomClasses\Permited;

class LibResourceTypeController extends Controller
{
    public function __construct() 
    {
        $this->middleware('authadm:admin')->except('index');
    }

    public function abort_if_not_permited() 
    {
        abort_unless(Permited::check('Resource Type'), 403);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, DataTableRes $DataTable, LibResourceType $Res)
    {
        return $DataTable->get_collections($request, $Res);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $this->abort_if_not_permited();
        $data = $this->validate($request, [
            'res_type' => 'required|string|unique:lib_resource_types,res_type|not_regex:~\W~'
        ]);
        
        $folder = 'library/' .$data['res_type'];
        $path = storage_path().'/app/public/' .$folder;

        if(!File::isDirectory($path)) {
            File::makeDirectory($path, true, true);
        } else {
            return 'Folder already exist. Use edit to modify it.';
        }

        $data['path'] = $folder;
        return LibResourceType::create($data);
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
        $this->abort_if_not_permited();
        $data = $this->validate($request, [
            'res_type' => 'required'
        ]);

        $folder = 'library/' .$data['res_type'];
        $path = storage_path().'/app/public/' .$folder;

        if(File::moveDirectory(storage_path().'/app/public/'.$res_type->path, $path)) {
            $data['path'] = $folder;
        } else {
            return 'The folder does not exist';
        }
        
        $res_type->update($data);
        return $res_type;
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Library\LibResourceType  $libResourceType
     * @return \Illuminate\Http\Response
     */
    public function destroy(LibResourceType $res_type)
    {
        $this->abort_if_not_permited();
        File::deleteDirectory(storage_path().'/app/public/' .$res_type->path);
        $res_type->delete();
        return $res_type;
    }

    public function get_all() 
    {
       return LibResourceType::all();
    }

    public function count_all(LibResourceType $res_type)
    {
        return $res_type->lib_res()->count();
    }
}
