<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    /**
     * Display a listing of the bar.
     *
     * @return \Illuminate\Http\Response
     */
    public function barList()
    {
        return view('admin.bar');
    }

    /**
     * Show the form for creating a bar.
     *
     * @return \Illuminate\Http\Response
     */
    public function createBar()
    {
        return view('admin.bar');
    }

    /**
     * Store a newly created bar in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeBar(Request $request)
    {
        //
    }

    /**
     * Display a listing of the bar.
     *
     * @return \Illuminate\Http\Response
     */
    public function clubList()
    {
        //
    }

    /**
     * Show the form for creating a bar.
     *
     * @return \Illuminate\Http\Response
     */
    public function createClub()
    {
        return view('admin.club');
    }

    /**
     * Store a newly created bar in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeClub(Request $request)
    {
        //
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
