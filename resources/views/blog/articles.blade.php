@extends('blog.layouts.app')

@section('content')
  <main id="main">

    <section class="single-post-content">
      <div class="container">
        <div class="row">
          <div class="col-md-12 post-content" data-aos="fade-up">
            <!-- ======= Single Post Content ======= -->
            <div class="single-post">
              <div class="post-meta">
                <span class="date" id="category"></span> 
                <span class="mx-1">&bullet;</span> <span id="date"></span>
              </div>
              <h1 class="mb-5" id="title"></h1>
              <p id="content"></p>
            </div><!-- End Single Post Content -->
          </div>
        </div>
      </div>
    </section>
  </main><!-- End #main -->
@endsection

@section('script')
  <script>
    // get id from url segement
    var id = window.location.href.split('/').pop();
    // get data from api
    $.ajax({
      url: '{{ url('/api/v1/articles/') }}/' + id,
      type: 'GET',
      dataType: 'json',
      success: function (data) {
        // set data to html
        $('#title').html(data.title);
        // category
        $('#category').html(data.categories.name);
        $('#content').html(data.content);
        $('#author').html(data.author);
        // date format indonesia
        var date = new Date(data.created_at);
        var options = { year: 'numeric', month: 'long', day: 'numeric' };
        $('#date').html(date.toLocaleDateString('id-ID', options));
        //$('#date').html(data.created_at);
        $('#image').attr('src', 'http://localhost:8000/storage/' + data.image);
      }
    });
    
  </script>
@endsection