@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        {{-- <div class="col-md-8"> --}}
            <div class=""> {{--<div class="card"> --}}
                {{-- <div class="card-header">Posts</div> --}}

                <div class="card-body">
                     <h2 class="text-primary">Posts</h2>
                    <form method="GET" name="searchForm" id="searchForm" action="{{ route('posts.index') }}" >

                        <div class="row mb-5">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="text" name="titlesearch" class="form-control" placeholder="Enter Title For Search" value="{{ old('titlesearch') }}" autofocus>
                                    <input type="hidden" value=""  name="searchtype">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group text-end">
                                    <button class="btn btn-success" id="search">Search</button>
                                </div>
                            </div>
                            <div class="col-md-2 text-end">
                                <div class="form-group">
                                    <button class="btn btn-success" id="algoliaSearch">Algolia Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <p>Request took {{$elapsedTime}} ms to fetch <span class="text-danger">{{ $posts->count() }}</span> filtered records.</p>
                    <p id="demo"></p>
                    <div id="searchResults"> </div>
                    @foreach ($posts as $post)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row" >
                                    <div class="col-md-8 text-start">
                                        <h5 class="card-title">{{ $post->title }}</h5>
                                        <p class="card-text">{{ $post->content }}</p>
                                    </div>
                                    <div class="col-md-4 ">
                                        <h5 class="card-title text-end">Category :  <span class="badge bg-info">{{ $post->category->name }}</span></h5>
                                        <h6 class="card-title text-end">Tags :
                                            <span class="card-text">
                                                @foreach ($post->tags as $tag)
                                                <span class="badge bg-secondary">
                                                    {{ $tag->name }}
                                                    {{-- {{ $loop->last ? '' : ', ' }} --}}
                                                </span>
                                                @endforeach
                                            </span>
                                        </h6>
                                        <p class="card-text text-end">
                                            <small class="text-muted">Published by {{ $post->user->name }} on {{ \Carbon\Carbon::parse($post->publish_date)->format('d-m-Y') }}
                                                </small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{$posts->appends(['titlesearch' => request('titlesearch'),'searchtype'=> request('searchtype')])->links() }}
                </div>

            </div>
        {{-- </div> --}}
    </div>
</div>
<script>
     var searchType = document.querySelector('input[name="searchtype"]');
     var search = document.getElementById('search');
 
    // Add a click event listener to the button
    search.addEventListener('click', function(event) {
         event.preventDefault();
        let x = document.forms["searchForm"]["titlesearch"].value;
        if (x == "") {
            alert("Seach value must be filled out");
            return false;
        }
         searchType.value = 'normal';
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
          document.forms["searchForm"].submit();
         //return true; 
     // start();
    });
    var algoliaSearch = document.getElementById('algoliaSearch');
    // Add a click event listener to the button
    algoliaSearch.addEventListener('click', function(event) {
        event.preventDefault();
   
        let x = document.forms["searchForm"]["titlesearch"].value;
  
        if (x == "") {
            alert("Seach value must be filled out");
            return false;
        }
   
        searchType.value = 'algolia';
     
     document.forms["searchForm"].submit();
          // return true; 
    });


</script>
@endsection

