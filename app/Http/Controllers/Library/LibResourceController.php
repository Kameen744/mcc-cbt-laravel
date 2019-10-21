<?php

namespace App\Http\Controllers\Library;

use App\Cbt\Department;
use App\Library\LibResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LibResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Library\LibResource  $libResource
     * @return \Illuminate\Http\Response
     */
    public function show(LibResource $libResource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Library\LibResource  $libResource
     * @return \Illuminate\Http\Response
     */
    public function edit(LibResource $libResource)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Library\LibResource  $libResource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LibResource $libResource)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Library\LibResource  $libResource
     * @return \Illuminate\Http\Response
     */
    public function destroy(LibResource $libResource)
    {
        //
    }

    public function res_department()
    {
        return Department::all();
    }
}
