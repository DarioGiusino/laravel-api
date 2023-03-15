<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TechnologyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //get technologies from db
        $technologies =  Technology::orderBy('label')->get();

        return view('admin.technologies.index', compact('technologies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $technology = new Technology;
        $technologies = Technology::all();
        return view('admin.technologies.create', compact('technology', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ! validation
        $request->validate(
            [
                'label' => 'unique:technologies|required|string',
                'color' => 'size:7|nullable'
            ],
            [
                'label.unique' => 'This label is already taken',
                'label.required' => 'A label must be given',
                'label.string' => 'The label must be a text',
                'color.size' => 'The color must be 7 character long'
            ]
        );

        // retrieve the input values
        $data = $request->all();

        // create a new technology
        $technology = new Technology();

        // fill new technology with data from form
        $technology->fill($data);

        // save new technology on db
        $technology->save();

        // redirect to index
        return to_route('admin.technologies.index')->with('message', "$technology->label created succesfully.")->with('type', 'success');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Technology $technology)
    {
        $technologies = Technology::all();
        return view('admin.technologies.edit', compact('technology', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Technology $technology)
    {
        // ! validation
        $request->validate(
            [
                'label' => [Rule::unique('technologies')->ignore($technology->id), 'required', 'string'],
                'color' => 'size:7|nullable'
            ],
            [
                'label.unique' => 'This label is already taken',
                'label.required' => 'A label must be given',
                'label.string' => 'The label must be a text',
                'color.size' => 'The color must be 7 character long'
            ]
        );

        // retrieve the input values
        $data = $request->all();

        // update new technology with data from form
        $technology->update($data);

        // redirect to index
        return to_route('admin.technologies.index')->with('message', "$technology->label updated succesfully.")->with('type', 'warning');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Technology $technology)
    {
        $technology->delete();

        return to_route('admin.technologies.index')->with('message', "$technology->label deleted succesfully.")->with('type', 'danger');;
    }

    /**
     * Update the technology color
     */
    public function patch(Request $request, Technology $technology)
    {
        $data = $request->all();

        $technology->update($data);

        return to_route('admin.technologies.index')->with('message', "$technology->label updated succesfully.")->with('type', 'warning');;
    }
}
