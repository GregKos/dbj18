<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['posts'] = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('posts.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['categories'] = \App\Category::all();
        return view('posts.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:191',
            'subtitle' => 'max:191',
            'content' => 'required',
            'published' => 'required|integer|max:1',
            'published_at' => 'required_if:published,1|nullable|date',
            'filename' => 'nullable',
            'category_id.*' => 'integer'
        ]);
        $categories = $validatedData['category_id'];
        unset($validatedData['category_id']);
        $post = Post::create($validatedData)->categories()->attach($categories);

        return redirect()->route('posts.index')->with('success', 'Post Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Unused in current scope
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['post'] = Post::find($id);
        $data['categories'] = \App\Category::all();
        $data['selected_categories'] = $data['post']->categories->pluck('id')->toArray();
        return view('posts.edit', $data);
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
        $validatedData = $request->validate([
            'title' => 'required|max:191',
            'subtitle' => 'max:191',
            'content' => 'required',
            'published' => 'required|integer|max:1',
            'published_at' => 'required_if:published,1|nullable|date',
            'filename' => 'nullable',
            'category_id.*' => 'integer'
        ]);
        $categories = $validatedData['category_id'];
        unset($validatedData['category_id']);
        $post = Post::find($id);
        if($post->filename && (!$validatedData['filename'] || $validatedData['filename'] !== $post->filename)) Storage::delete('public/postfiles/'.$post->filename);
        $post->categories()->sync($categories);
        $post->update($validatedData);

        return redirect()->route('posts.index')->with('success', 'Post Edited!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = Post::destroy($id);
        return response()->json([
            'type' => ($result) ? 'success' : 'failure'
        ]);
    }

    /**
     * Toggle whether the post is published or unpublished.
     *
     * @param  int  $id
     * @param  int  $target_state
     * @return \Illuminate\Http\Response
     */
    public function togglePublished($id, $target_state)
    {
        $id = intval($id);
        if($id > 0) {
            if($target_state) {
                $result = Post::where('id', $id)->update(['published' => 1, 'published_at' => date('Y-m-d H:i:s')]);
            } else {
                $result = Post::where('id', $id)->update(['published' => 0, 'published_at' => null]);
            }
            if($result > 0) {
                return response()->json([
                    'type' => 'success',
                    'message' => 'Post Successfully ' . (($target_state) ? 'Published' : 'Unpublished') . '!'
                ]);
            } else {
                return response()->json([
                    'type' => 'success',
                    'message' => 'Error Toggling Status'
                ]);
            }
        } else {
            return response()->json([
                'type' => 'success',
                'message' => 'There was an error. Please try again.'
            ]);
        }
    }

    /**
     * Save a file and return its generated filename.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function handleUpload(Request $request)
    {
        if($request->hasFile('file') && $request->file('file')->isValid()) {
            $path = $request->file->store('public/postfiles');
            return response()->json([
                'type' => 'success',
                'message' => 'File Successfully Uploaded!',
                'path' => $path
            ]);
        } else {
            return response()->json([
                'type' => 'success',
                'message' => 'There was an error. Please try again.'
            ]);
        }
    }

    /**
     * Delete a file by filename.
     *
     * @param  String $filename
     * @return \Illuminate\Http\Response
     */
    public function deleteUpload($filename)
    {
        if(Storage::delete('public/postfiles/'.$filename)) {
            return response()->json([
                'type' => 'success',
                'message' => 'File Successfully Deleted!',
                'del' => 'yes'
            ]);
        } else {
            return response()->json([
                'type' => 'success',
                'message' => 'There was an error. Please try again.'
            ]);
        }
    }
}
