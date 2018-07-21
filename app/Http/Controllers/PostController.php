<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $data['posts'] = DB::table('posts')->orderBy('created_at', 'desc')->paginate(10);
        return view('posts.index', $data);
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
        $result = DB::table('posts')->where('id', $id)->delete();
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
                $result = DB::table('posts')->where('id', $id)->update(['published' => 1, 'published_at' => date('Y-m-d H:i:s')]);
            } else {
                $result = DB::table('posts')->where('id', $id)->update(['published' => 0, 'published_at' => null]);
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
}
