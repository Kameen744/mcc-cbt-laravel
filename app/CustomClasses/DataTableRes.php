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
        
        $query = $modal::eloquentQuery($column, $orderBy, $searchValue);

        $data = $query->paginate($length);
        return new DataTableCollectionResource($data);
    }

    // public function index(Request $request)
    // {   
    //     $length = $request->input('length');
    //     $sortBy = $request->input('column');
    //     $orderBy = $request->input('dir');
    //     $searchValue = $request->input('search');

    //      $query = $modal::eloquentQuery($column, $orderBy, $searchValue);
    //     $query = User::queryBuilderQuery($sortBy, $orderBy, $searchValue);

    //     $query 
    //         ->join('roles', 'roles.id', '=', 'users.role_id')
    //         ->select(
    //             'roles.name as role_name',
    //             'users.id',
    //             'users.cost',
    //             'users.name as user_name',
    //             'users.email'
    //         )
    //         ->orWhere('roles.name', "LIKE", "%$searchValue%");

    //     $data = $query->paginate($length);
        
    //     return new DataTableCollectionResource($data);
    // }
}