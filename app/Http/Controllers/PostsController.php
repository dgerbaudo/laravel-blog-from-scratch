<?php

namespace App\Http\Controllers;

use App\Post;

class PostsController extends Controller
{

    function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {

        $posts = Post::latest()->filter(request(['month', 'year']))->get();

        $archives = Post::selectRaw('date_part(\'year\', created_at) as year, 
                            to_char(to_timestamp (date_part(\'month\',created_at)::text, \'MM\'), \'Month\') as month,
                            count(*) as published')
                        ->groupBy('year', 'month')
                        ->orderByRaw('min(created_at) desc')
                        ->get()
                        ->toArray();

        return view('posts.index', compact('posts', 'archives'));
    }

    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store()
    {

        $this->validate(request(), [
            'title' => 'required',
            'body' => 'required'
        ]);

//        $post = new Post;
//        $post->title = request('title');
//        $post->body = request('body');
//        $post->save();

//        Post::create([
//            'title' => request('title'),
//            'body' => request('body')
//        ]);

//        Post::create([
//            'title' => request('title'),
//            'body' => request('body'),
//            'user_id' => auth()->id()
//        ]);

        auth()->user()->publish(
            new Post(request(['title', 'body']))
        );

        return redirect('/');


    }

}
