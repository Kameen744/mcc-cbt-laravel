<?php

namespace App\Http\Controllers\Library;

use App\Cbt\Department;

use App\Library\LibResource;
use Illuminate\Http\Request;
use App\Library\LibResourceType;
use App\CustomClasses\DataTableRes;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\CustomClasses\Permited;

class LibResourceController extends Controller
{
    public function __construct() 
    {
        $this->middleware('authadm:admin');
    }

    public function abort_if_not_permited() 
    {
        abort_unless(Permited::check('Resources'), 403);
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, DataTableRes $DataTable, LibResource $LibRes)
    {
        $this->abort_if_not_permited();
        return $data = $DataTable->get_collections($request, $LibRes);
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
            'res_files' => 'required',
            'res_files.*' => 'mimes:jpg,png,jpeg,pdf',
            'res_title' => 'required',
            'res_subject'    => 'required',
            'res_author' => 'required',
            'res_department_id' => 'required',
            'res_type_id' => 'required'
        ]);

        $folder = LibResourceType::find($request->res_type_id)->res_type;
        
        $filename = preg_replace('/\s+/', '',  
                    substr($request->res_title, 0,7)) .rand(10001, 99999).'.';

        if($request->hasfile('res_files')) {
            foreach($request->file('res_files') as $file) {
                if($file->extension() === 'pdf') {

                    Storage::disk('library')->putFileAs($folder, 
                    $file, $filename .$file->extension());

                    $data['res_files'] = $filename .$file->extension();
                    
                } else {
                    
                    Storage::disk('library')->putFileAs($folder .'/cover', 
                    $file, $filename .$file->extension());

                    $data['res_cover'] = $filename .$file->extension();
                }
            }
        }

        return LibResource::create($data);        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Library\LibResource  $libResource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LibResource $resource)
    {
        $this->abort_if_not_permited();
        $data = $this->validate($request, [
            'res_title' => 'required',
            'res_subject'    => 'required',
            'res_author' => 'required',
            'res_department_id' => 'required',
            'res_type_id' => 'required'
        ]);

        if($request->res_type_id != $resource->res_type_id) {
            $oldFolder = LibResourceType::find($resource->res_type_id)->res_type;
            $newFolder = LibResourceType::find($request->res_type_id)->res_type;

            Storage::disk('library')->move($oldFolder.'/'.$resource->res_files, 
            $newFolder.'/'.$resource->res_files);

            Storage::disk('library')->move($oldFolder.'/' .'cover/'.$resource->res_cover, 
            $newFolder.'/' .'cover/'.$resource->res_cover);
        }
       
        $resource->update($data);
        return $resource;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Library\LibResource  $libResource
     * @return \Illuminate\Http\Response
     */
    public function destroy(LibResource $resource)
    {
        $this->abort_if_not_permited();
        $folder = LibResourceType::find($resource->res_type_id)->res_type;

        Storage::disk('library')->delete($folder.'/' .$resource->res_files);
        Storage::disk('library')->delete($folder.'/' .'cover/'.$resource->res_cover);
        $resource->delete();
        return [];
    }

    public function res_department()
    {
        return Department::all();
    }
}
