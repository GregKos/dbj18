<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class IndexController extends Controller
{
    /**
     * Display the index page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_posts = Post::select('created_at')->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-1 year')))->get();
        $counts = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($all_posts as $post) {
            $month = date('n', strtotime($post->created_at));
            $counts[($month - 1)] += 1;
        }
        $data['postdata'] = implode(', ', $counts);
        return view('index', $data);
    }
}
