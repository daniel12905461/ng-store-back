<?php

namespace App\Http\Controllers;

use App\Models\PlanInternet;
use App\Http\Requests\StorePlan_internetRequest;
use App\Http\Requests\UpdatePlan_internetRequest;

class PlanInternetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $objs = PlanInternet::get();

        return response()->json(['ok' => true, 'data' => $objs], 200);
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
    public function store(StorePlan_internetRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan_internet $plan_internet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan_internet $plan_internet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlan_internetRequest $request, Plan_internet $plan_internet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan_internet $plan_internet)
    {
        //
    }
}
