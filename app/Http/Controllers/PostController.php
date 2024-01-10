<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {   
        $posts = Post::with(['user','category','tags'])->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function search(Request $request) {

        if ($request->ajax()) {
            if($request->has('titlesearch')){
                 if($request->has('searchtype'))
                 {

                     if($request->get('searchtype') == 'normal') 
                     {
                         $searchTerm = $request->get('titlesearch');
                        //  $posts = Post::with(['user', 'category', 'tags'])
                        //              ->when($searchTerm, function ($query) use ($searchTerm) {
                        //                  $query->where('title', 'like', '%' . $searchTerm . '%')
                        //                      ->orWhere('content', 'like', '%' . $searchTerm . '%');
                        //                  })
                        //                  ->paginate(1000);
                        $posts = Post::when($searchTerm, function ($query) use ($searchTerm) {
                            $query->where('title', 'like', '%' . $searchTerm . '%')
                                  ->orWhere('content', 'like', '%' . $searchTerm . '%');
                        })
                        ->paginate(1000);
                        return $posts;
                        // dd($posts);
                        //  return response()->json([
                        //     'posts' => $posts
                        // ]);
                     }
                     if($request->get('searchtype') == 'algolia'){
                         $searchData = $request->titlesearch;
                         $posts = Post::search($searchData)->paginate(1000);
                         /* echo "<pre>";
                         print_r($posts);
                         exit; */
                         return $posts;
                        //  return response()->json([
                        //     'posts' => $posts
                        // ]);
                     }
                 }
             }else{
                 $posts = Post::with(['user','category','tags'])->paginate(10);
                 return $posts;
                //  return response()->json([
                //     'posts' => $posts
                // ]);
             }
         }
    }

    // public function search(Request $request)
    // {
    //     $elapsedTime=0;
    //     $start = microtime(true);
    //     $returnSearchdata = $request->get('titlesearch');
    //     if($request->has('titlesearch')){
    //         if($request->has('searchtype'))
    //         {
    //             if($request->get('searchtype') == 'normal') 
    //             {
    //                 $searchTerm = $request->get('titlesearch');
    //                 $posts = Post::with(['user', 'category', 'tags'])
    //                             ->when($searchTerm, function ($query) use ($searchTerm) {
    //                                 $query->where('title', 'like', '%' . $searchTerm . '%')
    //                                     ->orWhere('content', 'like', '%' . $searchTerm . '%');
    //                                 })
    //                                 ->paginate(1000);
    //             }
    //             if($request->get('searchtype') == 'algolia'){
    //                 $searchData = $request->titlesearch;
    //                 $posts = Post::search($searchData)->paginate(1000);
    //                 /* echo "<pre>";
    //                 print_r($posts);
    //                 exit; */
    //             }
    //         }
    //     }else{
    //         $posts = Post::with(['user','category','tags'])->paginate(10);
    //     }
    //     $end = microtime(true);
    //     $elapsedTime = ($end - $start); //seconds
    //   //  dd($elapsedTime);
    //   //  return view('posts.index', compact('posts','elapsedTime'));
    //   return response()->json([
    //     'posts' => $posts
    //  ]);
    // }

    public function indexOld(Request $request)
    {
      // dd($request);
      $elapsedTime=0;
      $executionTime=0;
      $start = microtime(true);
        $returnSearchdata = $request->get('titlesearch');
        if($request->has('titlesearch')){
            if($request->has('searchtype'))
            {
                if($request->get('searchtype') == 'normal') 
                {
                    $searchTerm = $request->get('titlesearch');
                    $posts = Post::with(['user', 'category', 'tags'])
                                ->when($searchTerm, function ($query) use ($searchTerm) {
                                    // if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $searchTerm)) {
                                    //     $searchTerm = \Carbon\Carbon::createFromFormat('d-m-Y', $searchTerm)->format('Y-m-d');
                                    // }
                                    // Add conditions for the manual search
                                    $query->where('title', 'like', '%' . $searchTerm . '%')
                                        ->orWhere('content', 'like', '%' . $searchTerm . '%')
                                        ->orWhere('publish_date', 'like', '%' . $searchTerm . '%');
                                        // ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                                        //     $userQuery->where('name', 'like', '%' . $searchTerm . '%');
                                        // })
                                        // ->orWhereHas('category', function ($categoryQuery) use ($searchTerm) {
                                        //     $categoryQuery->where('name', 'like', '%' . $searchTerm . '%');
                                        // })
                                        // ->orWhereHas('tags', function ($tagQuery) use ($searchTerm) {
                                        //     $tagQuery->where('name', 'like', '%' . $searchTerm . '%');
                                        // });
                                    })
                                    ->paginate(500);
                }
                if($request->get('searchtype') == 'algolia'){
                    $searchData = $request->titlesearch;
                    // if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $request->titlesearch)) {
                    //     $searchData = \Carbon\Carbon::createFromFormat('d-m-Y', $request->titlesearch)->format('Y-m-d');
                    // }
                    $posts = Post::search($searchData)->paginate(500);
                    
                    // $posts = Post::search($request->titlesearch)->latest()->paginate(10);
                            // echo "<pre>";
                            // print_r($searchResults);
                            // exit;
                    // Load relationships for each result
                    //$posts = $searchResults->load('user', 'category', 'tags');
                    
                }
            }
        }else{
            $posts = Post::with(['user','category','tags'])->paginate(500);
        }

        $end = microtime(true);
        //$elapsedTime = ($end - $start) * 1000; //misconds
        $elapsedTime = ($end - $start); //seconds
        //return view('posts.index', compact('posts','returnSearchdata'));
         return view('posts.index', compact('posts','elapsedTime','executionTime'));

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
