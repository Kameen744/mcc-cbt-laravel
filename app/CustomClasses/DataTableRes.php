<?php

namespace App\CustomClasses;

use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class DataTableRes {
    
    public function get_collections($request, $modal)
    {
        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $orderBy = $request->input('dir', 'asc');
        $searchValue = $request->input('search');
        
        $query = $modal::dataTableQuery($column, $orderBy, $searchValue);
        
        $data = $query->paginate($length);
        return new DataTableCollectionResource($data);
    }
}