<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //get types from db
        $types =  Type::orderBy('label')->get();

        return view('admin.types.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type = new Type;
        $types = Type::all();
        return view('admin.types.create', compact('type', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ! validation
        $request->validate(
            [
                'label' => 'unique:types|required|string',
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

        // create a new type
        $type = new Type();

        // fill new type with data from form
        $type->fill($data);

        // save new type on db
        $type->save();

        // redirect to index
        return to_route('admin.types.index')->with('message', "$type->label created succesfully.")->with('type', 'success');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $type)
    {
        $types = Type::all();
        return view('admin.types.edit', compact('type', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Type $type)
    {
        // ! validation
        $request->validate(
            [
                'label' => [Rule::unique('types')->ignore($type->id), 'required', 'string'],
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

        // update new type with data from form
        $type->update($data);

        // redirect to index
        return to_route('admin.types.index')->with('message', "$type->label updated succesfully.")->with('type', 'warning');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $type)
    {
        $type->delete();

        return to_route('admin.types.index')->with('message', "$type->title deleted succesfully.")->with('type', 'danger');;
    }

    /**
     * Update the type color
     */
    public function patch(Request $request, Type $type)
    {
        $data = $request->all();

        $type->update($data);

        return to_route('admin.types.index')->with('message', "$type->label updated succesfully.")->with('type', 'warning');;
    }
}
