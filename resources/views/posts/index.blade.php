@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        {{-- <div class="col-md-8"> --}}
            <div class=""> {{--<div class="card"> --}}
                {{-- <div class="card-header">Posts</div> --}}

                <div class="card-body">
                     <h2 class="text-primary">Posts</h2>
                     {{-- action="{{ route('posts.index') }}" --}}
                    <form name="searchForm" id="searchForm">

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
                    {{-- <p>Request took {{$elapsedTime}} sec to fetch <span class="text-danger">{{ $posts->count() }}</span> filtered records.</p> --}}
                    <p id="demo"></p>
                    <div id="searchResults"> </div>
                    <div id="defaultData"> 
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

            </div>
        {{-- </div> --}}
    </div>
</div>
{{-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
 <script type="text/javascript">
    $(document).on('click','#search',function(e) {
        e.preventDefault();
        
        var titlesearch = $("input[name=titlesearch]").val();
        var searchtype ='normal';
        console.log(titlesearch);
        console.log(searchtype);

        ajaxCall(titlesearch,searchtype);
    });

    $(document).on('click','#algoliaSearch',function(e) {
        e.preventDefault();
       
        var titlesearch = $("input[name=titlesearch]").val();
        var searchtype ='algolia';
        console.log(titlesearch);
        console.log(searchtype);
        ajaxCall(titlesearch,searchtype);
    });
   function ajaxCall(titlesearch,searchtype){

        $.ajax({
            url:"{{ route('posts.search') }}",
            type:"POST",
            data:{
                "_token": $('meta[name="csrf-token"]').attr('content'),
                'titlesearch':titlesearch,
                'searchtype':searchtype
            },
            success:function (data) {
                $("#defaultData").css("display", "none");
                $("#searchResults").empty();
                console.log(data);
                console.log(data.data);
                //var pagination = data.pagination;
                records = data.data;
                var htmlContent='';
                        $.each(records, function(index, record) {
                            htmlContent += '<div class="card mb-3">' +
                            '<div class="card-body">' +
                            '<div class="row">' +
                            '<div class="col-md-8 text-start">' +
                            '<h5 class="card-title">' + record.title + '</h5>' +
                            '<p class="card-text">' + record.content + '</p>' +
                            '</div>' +
                            '<div class="col-md-4">' +
                            '<h5 class="card-title text-end">Category: <span class="badge bg-info">' + record.category_id + '</span></h5>' +
                            '<h6 class="card-title text-end">Tags: ' +
                            '<span class="card-text"> ';
                                //$.each(record.tags, function (tagIndex, tag) {
                                    htmlContent += '<span class="badge bg-secondary">' + '123' + '</span> ';
                               // });

                            htmlContent += '</span></h6>' +
                            '<p class="card-text text-end">' +
                            '<small class="text-muted">Published by ' + record.user_id + ' on ' + record.publish_date + '</small>' +
                            '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                        });

                   
                        console.log(htmlContent);
                         // Append the HTML content to #defaultData
                        $('#searchResults').append(htmlContent);

                        console.log("Current Page: " + data.current_page);
                        console.log("Total Pages: " + data.total);
            },
            error: function (xhr, status, error) {
            console.error(xhr.responseText);
            // Handle the error response here
        }
        })
   }
</script>
{{-- ----------------bellow old --}}
<script>
</script>
@endsection

