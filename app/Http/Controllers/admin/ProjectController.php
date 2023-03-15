<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Http\Request;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status_filter = $request->query('status_filter');
        $type_filter = $request->query('type_filter');

        $query = Project::orderBy('id');

        // if there is a status filter
        if ($status_filter) {
            $value = $status_filter === 'draft' ? 0 : 1;
            $query->where('is_published', $value);
        }

        // if there is a type filter
        if ($type_filter) {
            $query->where('type_id', $type_filter);
        }

        //get projects from db
        $projects = $query->paginate(10);
        //get types from db
        $types = Type::all();

        //return projects index with projects
        return view('admin.projects.index', compact('projects', 'types', 'status_filter', 'type_filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $project = new Project;
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.create', compact('project', 'types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Faker $faker)
    {
        // ! validation
        $request->validate(
            [
                'title' => 'required|string|unique:projects|max:40',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:png,jpeg,jpg',
                'repo_link' => 'nullable|url',
                'type' => 'nullable|exists:types,id',
                'technologies' => 'nullable|exists:technologies,id'
            ],
            [
                'title.required' => 'A title must be given',
                'title.string' => 'The title must be a text',
                'title.unique' => 'This title is already taken',
                'title.max' => 'Max length exceeded',
                'description.required' => 'A description must be given',
                'description.string' => 'The description must be a text',
                'image.image' => 'Please, give an image file',
                'image.mimes' => 'Only jpeg, jpg and png file supported',
                'repo_link.url' => 'Please, give a valid URL',
                'type' => 'This type is not valid',
                'technologies' => 'Technology/ies is not valid.'
            ]
        );

        // retrieve the input values
        $data = $request->all();

        // create a new project
        $project = new Project();

        // check if an image is given
        if (Arr::exists($data, 'image')) {
            // define a variable where the file is saved in a path storage/app/public/{} that return a correct URL
            $img_url = Storage::put('projects', $data['image']);
            // change the file given with the correct url
            $data['image'] = $img_url;
        }

        // fill new project with data from form
        $project->fill($data);

        // define publish or not
        $project->is_published = Arr::exists($data, 'is_published');

        // save new project on db
        $project->save();

        // if technologies are given, add to the proejct
        if (Arr::exists($data, 'technologies')) $project->technologies()->attach($data['technologies']);

        // redirect to its detail
        return to_route('admin.projects.show', $project->id)->with('message', "$project->title created succesfully.")->with('type', 'success');;
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();
        $project_technologies = $project->technologies->pluck('id')->toArray();
        return view('admin.projects.edit', compact('project', 'types', 'technologies', 'project_technologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        // ! validation
        $request->validate(
            [
                'title' => ['required', 'string', Rule::unique('projects')->ignore($project->id), 'max:40'],
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:png,jpeg,jpg',
                'repo_link' => 'nullable|url',
                'type' => 'nullable|exists:types,id',
                'technologies' => 'nullable|exists:technologies,id'
            ],
            [
                'title.required' => 'A title must be given',
                'title.string' => 'The title must be a text',
                'title.unique' => 'This title is already taken',
                'title.max' => 'Max length exceeded',
                'description.required' => 'A description must be given',
                'description.string' => 'The description must be a text',
                'image.image' => 'Please, give an image file',
                'image.mimes' => 'Only jpeg, jpg and png file supported',
                'repo_link.url' => 'Please, give a valid URL',
                'type' => 'This type is not valid',
                'technologies' => 'Technology/ies is not valid.'
            ]
        );

        $data = $request->all();

        // check if an image is given
        if (Arr::exists($data, 'image')) {
            // if exists an image, delete it to make space for the newest
            if ($project->image) Storage::delete($project->image);
            // define a variable where the file is saved in a path storage/app/public/{} that return a correct URL
            $img_url = Storage::put('projects', $data['image']);
            // change the file given with the correct url
            $data['image'] = $img_url;
        }

        // define publish or not
        $data['is_published'] = Arr::exists($data, 'is_published');

        $project->update($data);

        // if technologies are given, add to the proejct
        if (Arr::exists($data, 'technologies')) $project->technologies()->sync($data['technologies']);
        else $project->technologies()->detach();

        return to_route('admin.projects.show', $project->id)->with('message', "$project->title updated succesfully.")->with('type', 'warning');;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        // if exists an image, delete it to make space for the newest
        if ($project->image) Storage::delete($project->image);

        if (count($project->technologies)) $project->technologies()->detach();

        $project->delete();

        return to_route('admin.projects.index')->with('message', "$project->title deleted succesfully.")->with('type', 'danger');;
    }
}
