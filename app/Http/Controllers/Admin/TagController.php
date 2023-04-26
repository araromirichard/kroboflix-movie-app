<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Str;
use Inertia\Inertia;

class TagController extends Controller
{
    public function index()
    {
        $perPage = FacadesRequest::input('perPage') ?: 5;
        return Inertia::render('Tags/Index', [
            'tags' => Tag::query()
                ->when(FacadesRequest::input('search'), function ($query, $search) {
                    $query->where('tag_name', 'like', "%{$search}%");
                })->paginate($perPage)
                ->withQueryString(),
            'filters' => FacadesRequest::only('search', 'perPage')
        ]);
    }


    public function create()
    {
        return Inertia::render('Tags/Create', [
            'edit' => false,
            'Tags' => (object)[]
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tagName' => 'required|max:255'
        ]);

        Tag::create([
            'tag_name' => $validated['tagName'],
            'slug' => Str::slug($validated['tagName']),
        ]);

        return Redirect::route('admin.tags.index')->with('flash.banner', 'Tag Created Successfully!');
    }

    public function edit(Tag $tag)
    {
        return Inertia::render('Tags/Create', [
            'edit' => true,
            'tag' => $tag,
        ]);
    }

    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate([
            'tagName' => 'required|max:255'
        ]);

        $tag->update([
            'tag_name' => $validated['tagName'],
            'slug' => Str::slug($validated['tagName']),
        ]);

        return Redirect::route('admin.tags.index')->with('flash.banner', 'Tag Updated Successfully!');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();

        return Redirect::route('admin.tags.index')->with('flash.banner', 'Tag Deleted Successfully!')->with('flash.bannerStyle', 'danger');
    }
}
