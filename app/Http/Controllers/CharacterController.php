<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Http\Requests\StoreCharacterRequest;
use App\Http\Requests\UpdateCharacterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class CharacterController extends Controller
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
    public function create(): \Inertia\Response
    {
        return Inertia::render('Character/Create', [
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCharacterRequest $request): \Illuminate\Http\RedirectResponse
    {
        $character = new Character();
        $character->name = $request->name;
        $character->class = $request->class;
        $character->user_id = Auth::user()->getAuthIdentifier();
        $character->save();

        return to_route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(Character $character)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Character $character)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCharacterRequest $request, Character $character)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Character $character)
    {
        //
    }
}
