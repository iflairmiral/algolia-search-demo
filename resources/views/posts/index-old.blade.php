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
                            <div class="col-md-7">
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
                             <div class="col-md-2">
                                <div class="form-group">
                                    <button class="btn btn-success" id="clear">Clear</button>
                                </div>
                                
                            </div>
                        </div>
                    </form>
                    <p id="demo"></p>
                    <div class="timer-display-id">
                        <h1>Timer </h1>
                        <p id="timer">00:00:00 </p>
                        <button id="start-timer" onclick="start()">Start </button>
                        <button id="stop-timer" onclick="stop()">Stop  </button>
                      </div>
                    @foreach ($posts as $post)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row" >
                                    <div class="col-md-8 text-start">
                                        <h5 class="card-title">{{ $post->title }}</h5>
                                        <p class="card-text">{{ $post->content }}</p>
                                    </div>
                                    <div class="col-md-4 ">
                                        <h6 class="card-title text-end">Category :  <span class="badge bg-info">{{ $post->category->name }}</span></h6>
                                        <h6 class="card-title text-end">Tags :
                                            <span class="card-text">
                                                @foreach ($post->tags as $tag)
                                                    {{ $tag->name }}{{ $loop->last ? '' : ', ' }}
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

                    {{-- {{ $posts->links() }} --}}
                     {{-- Display pagination links --}}
                    {{ $posts->appends(['titlesearch' => request('titlesearch'),'searchtype'=> request('searchtype')])->links() }}
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
          //document.forms["searchForm"].submit();
         //return true; 
       //alert('out'); 
       //timerCount();
     // start();
    });
    var algoliaSearch = document.getElementById('algoliaSearch');
    // Add a click event listener to the button
    algoliaSearch.addEventListener('click', function(event) {
        event.preventDefault();
       // alert("algolia");
        let x = document.forms["searchForm"]["titlesearch"].value;
        //alert(x);
        if (x == "") {
            alert("Seach value must be filled out");
            return false;
        }
        //alert('out');
        searchType.value = 'algolia';
     //   document.forms["searchForm"].submit();
          // return true; 
    });

// ==============================================
const ret = document.getElementById("timer");
const startBtn = document.querySelector("#start-timer");

let counter = 0;
let interval;

function stop() {
  clearInterval(interval);
  startBtn.disabled = false;

}

function convertSec(cnt) {
  let sec = cnt % 60;
  let min = Math.floor(cnt / 60);
  if (sec < 10) {
    if (min < 10) {
      return "0" + min + ":0" + sec;
    } else {
      return min + ":0" + sec;
    }
  } else if ((min < 10) && (sec >= 10)) {
    return "0" + min + ":" + sec;
  } else {
    return min + ":" + sec;
  }
}

function start() {
    alert("start called");
  
  startBtn.disabled = true;
  interval = setInterval(function() {
    console.log("caee");
    ret.innerHTML = convertSec(counter++); // timer start counting here...
  }, 1000);
}
 

//=============================
function timerCount(){
//alert('in timer function');
    // Set the date we're counting down to
    //var date = Date.now();
   // var countDownDate = new Date("00:00:00").getTime();
   var countDownDate = new Date("Jan 3, 2024 15:37:25").getTime();
  
    //var countDownDate = date.getTime();
    // Update the count down every 1 second
    var x = setInterval(function() {

    // Get today's date and time
    var now = new Date().getTime();

    // Find the distance between now and the count down date
    var distance = countDownDate - now;

    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Display the result in the element with id="demo"
    document.getElementById("demo").innerHTML = days + "d " + hours + "h "
    + minutes + "m " + seconds + "s ";

    // If the count down is finished, write some text
    if (distance < 0) {
        clearInterval(x);
        document.getElementById("demo").innerHTML = "EXPIRED";
    }
    }, 1000);
}

// ==============================================
// var clear = document.getElementById('clear');
//  // Add a click event listener to the button
//     clear.addEventListener('click', function(event) {
//         event.preventDefault();
//         alert("algolia");
//        window.location.href = '{{ route("posts.index")}}';
//           // return true; 
//     });
    // if (window.location.reload) {
    // // Modify the URL to remove all query parameters
    // const newUrl = window.location.href.split('?')[0];

    // // Replace the current URL in the browser history without triggering a page refresh
    // history.replaceState({}, document.title, newUrl);
    // }
    // window.addEventListener('load', function() {
    // // Display an alert message after the page has finished loading
    //     alert('Page has been reloaded!');
    //     window.location.href = '{{ route("posts.index")}};
    // });
</script>
@endsection

