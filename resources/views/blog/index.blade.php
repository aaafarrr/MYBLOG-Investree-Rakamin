@extends('blog.layouts.app')

@section('content')
  <main id="main">
    <section>
      <div class="container">
        <div class="row" id="article">  

        </div>
      </div>
    </section>
  </main><!-- End #main -->

@endsection

@section('script')
  <script>
    // get method page value 
    var page = window.location.href.split('?page=')[1];
    if (page == undefined) {
      page = 1;
    }
    console.log(page);
    // get all artcle from api api/v1/articles to view in index page
    $.ajax({
      url: '{{ URL('api/v1/articles/paginate/5') }}?page='+page,
      type: 'GET',
      dataType: 'json',
      success: function (data) {
        console.log(data);
        var article = data.data;
        var html = '';
        var pagination = '';
        for (var i = 0; i < article.length; i++) {
          html += '<div class="col-md-12" data-aos="fade-up">';
          html += '<h3 class="category-title"></h3>';
          html += '<div class="d-md-flex post-entry-2 half">';
          html += '<a href="{{ url('articles') }}/'+article[i].id+'" class="me-4 thumbnail">';
          html += '<img height="100px" width="500px" src="'+ article[i].image+'" alt="" class="img-fluid">';
          html += '</a>';
          html += '<div>';
          html += '<div class="post-meta"><span class="date" id="category-article">' + article[i].categories.name + '</span> <span class="mx-1">&bullet;</span> <span id="date-article">' + new Date(article[i].created_at).toLocaleDateString('id-ID') + '</span></div>';
          html += '<h3><a href="{{ url('articles') }}/'+article[i].id+'" id="link-article">' + article[i].title + '</a></h3>';
          // content maks 100 character
          // filter html tag
          var content = article[i].content.replace(/(<([^>]+)>)/ig, "");
          if (content.length > 100) {
            content = content.substring(0, 100) + '...';
          }
          //var content = article[i].content.substring(0, 100);
          html += '<p id="content-article">' + content + '...</p>';
          html += '<div class="d-flex align-items-center author">';
          html += '<div class="photo"><img id="img-article" src="assets/img/profile.png" alt="" class="img-fluid"></div>';
          html += '<div class="name">';
          html += '<h3 class="m-0 p-0" id="writer-article">' + article[i].user.name + '</h3>';
          html += '</div>';
          html += '</div>';
          html += '</div>';
          html += '</div>';
          html += '</div>';
        }

        // check if data is empty show alert
        if (article.length == 0) {
          html += '<div class="col-md-12" data-aos="fade-up">';
          html += '<h3 class="category-title"></h3>';
          html += '<div class="post-entry-2 half  text-center">';
          html += '<div class="alert alert-danger" role="alert">';
          html += 'Page Not Found!';
          html += '</div>';
          html += '</div>';
          html += '</div>';
        } else{
          // pagination from api
          pagination += '<div class="text-start py-4 text-center">';
          pagination += '<div class="custom-pagination">';
          // prev
          if (data.prev_page_url == null) {
            pagination += '<a href="#" class="prev">Prevous</a>';
          } else {
            // get id prev page
            var prev = data.prev_page_url.split('?page=')[1];
            pagination += '<a href="{{ url('') }}?page='+prev+'" class="prev">Prevous</a>';
          }
          // page
          for(var i = 1; i <= data.last_page; i++){
            // get current page
            if (data.current_page == i) {
              pagination += '<a href="{{ url('') }}?page='+i+'" class="active">'+i+'</a>';
            } else {
              pagination += '<a href="{{ url('') }}?page='+i+'">'+i+'</a>';
            }
          }
          // next 
          if (data.next_page_url == null) {
            pagination += '<a href="" class="next">Next</a>';
          } else {
            // get id next page
            var next_page = data.next_page_url.split('?page=')[1];
            pagination += '<a href="{{ url('') }}?page='+next_page+'" class="next">Next</a>';
          }
          pagination += '</div>';
          pagination += '</div>';
        }

        $('#article').html(html+pagination);
      }
    });
    
  </script>
@endsection
