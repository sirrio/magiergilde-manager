<?php

namespace App\Http\Controllers;

use App\Models\Downtime;
use App\Http\Requests\StoreDowntimeRequest;
use App\Http\Requests\UpdateDowntimeRequest;

class DowntimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDowntimeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Downtime $downtime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Downtime $downtime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDowntimeRequest $request, Downtime $downtime)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Downtime $downtime)
    {
        //
    }
}
