@extends('layouts.app')

@section('css')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">

{{-- summernote --}}


@endsection

@section('content')
{{-- form CARD --}}
<div class="container">
  <div class="row">
    <div class="col-12">
      <div class="card mb-5">
        <div class="card-header">
          Add Article
        </div>
        <div class="card-body">
          <form id="form-article" action="{{ url('api/v1/articles/') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="title" class="form-label">Title</label>
              <input type="text" class="form-control" id="title" name="title">
            </div>
            {{-- Image --}}
            <div class="mb-3">
              <label for="image" class="form-label">Image</label>
              <input type="file" class="form-control" id="image" name="image">
            </div>
            {{-- Content --}}
            <div class="mb-3">
              <label for="content" class="form-label">Content</label>
              <textarea class="form-control summernote" id="content" name="content" id="summernote" cols="30" rows="10"></textarea>
            </div>
            {{-- categories --}}
            {{-- get categories from api --}}
            <div class="mb-3">
              <label for="categories" class="form-label">Categories</label>
              <select class="form-select" aria-label="Default select example" name="categories_id" id="categories">
                <option selected>Open this select menu</option>
              </select>
            </div>

            <button class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-12">
      <div class="card mb-5">
        <div class="card-header">
          ALL ARTICLES
        </div>
        <div class="card-body">
          <table id="articles" class="table table-striped" style="width:100%">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th>Title</th>
                <th>Categories</th>
                <th>Image</th>
                <th>Writer</th>
                <th>Created</th>
                <th>Updates</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>


            </tbody>

          </table>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- MODAL EDIT BOOTSTRAP 5 --}}
<div class="modal fade" id="editArticle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Article</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body edit-article">
        <form id="form-edit-article" action="{{ url('api/v1/articles/') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('POST')
          {{-- id --}}
          <input type="hidden" name="id" id="id">
          <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title">
          </div>
          {{-- Image --}}
          <div class="mb-3">
            {{-- Image src --}}
            <img src="" alt="" id="image" class="img-fluid" width="100px" height="100px"><br>
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image-edit" name="image">
          </div>
          {{-- Content --}}
          <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control summernote summernote-modal" id="content" name="content" id="summernote-modal" cols="30" rows="10"></textarea>
          </div>
          {{-- categories --}}
          {{-- get categories from api --}}
          <div class="mb-3">
            <label for="categories" class="form-label">Categories</label>
            <select class="form-select" aria-label="Default select example" name="categories_id" id="categories">
              <option selected>Open this select menu</option>
            </select>
          </div>

          <button class="btn btn-primary" id="submit-article">Submit</button>
          {{-- delete --}}
          <a id="delete-article" class="btn btn-danger">Delete</a>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
@include('layouts.auth')
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

{{-- summernote --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-lite.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-lite.css" />

<script>
  $(document).ready(function() {
    $('.summernote').summernote({height: 200});
  });
</script>


<script>
  $(document).ready(function() {
    $.getJSON("{{ url('/api/v1/articles') }}", function(returndata) {
      //console.log(returndata);
      $('#articles').DataTable({
        data: returndata
        , columns: [
          // number iteration
          {
            data: null
            , render: function(data, type, row, meta) {
              return meta.row + meta.settings._iDisplayStart + 1;
            }
          }
          , {
            data: 'title'
            , title: 'Title'
          }
          , {
            data: 'categories.name'
            , title: 'Categories'
          },
          //{ data: 'content', title: 'Content' },
          // image
          {
            data: 'image'
            , title: 'Image'
            , render: function(data, type, row) {
              return '<img src="{{ asset('') }}' + data + '" width="100px" height="100px" />';
            }
          },
          //{ data: 'image', title: 'Image' },
          {
            data: 'user.name'
            , title: 'Writer'
          },
          // time indonesia
          {
            data: 'created_at'
            , title: 'Created'
            , render: function(data, type, row) {
              var date = new Date(data);
              var options = {
                weekday: 'long'
                , year: 'numeric'
                , month: 'long'
                , day: 'numeric'
              };
              return date.toLocaleDateString('id-ID', options);
            }
          }
          , {
            data: 'updated_at'
            , title: 'Updated'
            , render: function(data, type, row) {
              var date = new Date(data);
              var options = {
                weekday: 'long'
                , year: 'numeric'
                , month: 'long'
                , day: 'numeric'
              };
              return date.toLocaleDateString('id-ID', options);
            }
          },
          //{ data: 'created_at', title: 'Created' },
          //{ data: 'updated_at', title: 'Updated' },
          //action
          {
            data: 'id'
            , title: 'Action'
            , render: function(data) {
              return '<a href="/articles/' + data + '" class="btn btn-success mb-1">View</a> <br> <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editArticle" data-id="' + data + '">Edit/Delete</button>';
              //return '<a href="/admin/articles/' + data + '/" class="btn btn-success">View</a> <br> <a href="/admin/articles/' + data + '/edit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editArticle">Edit</a> <br> <a href="/admin/articles/' + data + '/delete" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteArticle">Delete</a>';
            }
          },

        ]
      });
    });
  });

</script>

{{-- get categories from api and show in select option id categories --}}
<script>
  $(document).ready(function() {
    $.ajax({
      url: "{{ url('/api/v1/categories') }}"
      , type: "GET"
      , dataType: "json"
      , success: function(data) {
        //console.log(data);
        var categories = data;
        var html = '';
        var html = '<option selected hidden disabled>Open this select menu</option>';
        for (var i = 0; i < categories.length; i++) {
          html += '<option value="' + categories[i].id + '">' + categories[i].name + '</option>';
        }
        $('#categories').html(html);
      }
    });
  });

</script>

<script>
  // send post articles
  $(document).ready(function() {
    $('#form-article').submit(function(e) {
      e.preventDefault();
      var formData = new FormData(this);

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
        }
      });
      $.ajax({
        url: $(this).attr("action")
        , type: $(this).attr("method")
        , dataType: "JSON"
        , accept: 'application/json'
        , cache: false
        , processData: false
        , headers: {
          'Authorization': 'Bearer ' + localStorage.getItem('token')
        },
        // send data and image to api
        data: formData
        , contentType: false,
        //data : $("#form-article").serialize(), 
        success: function(response) {
          if (response) {
            $('#form-article')[0].reset();
            alert('Data Saved');
            // refresh page
            location.reload();
          }
        }
        , error: function(error) {
          //console.log(error);
          alert(error.responseJSON.error);
        },
        //beforeSend: function(xhr, settings) { xhr.setRequestHeader('Authorization','Bearer ' + localStorage.getItem('token')); } 
      });
    });
  });
</script>

<script>
  // edit modal article
  $(document).ready(function() {
    $('#editArticle').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget)
      var id = button.data('id')
      var modal = $(this)
      $.ajax({
        url: "{{ url('/api/v1/articles') }}" + '/' + id
        , type: "GET"
        , dataType: "JSON"
        , success: function(data) {
          //console.log(data);
          modal.find('.modal-body #id').val(data.id);
          modal.find('.modal-body #title').val(data.title);
          //modal.find('.modal-body #content').val(data.content);
          // chang into summernote
          $(".summernote-modal").summernote("code", data.content);
          // get all categories and selected
          $.ajax({
            url: "{{ url('/api/v1/categories') }}"
            , type: "GET"
            , dataType: "json"
            , accept: 'application/json'
            , success: function(categories) {
              //console.log(categories);
              var html = '';
              var html = '<option selected hidden disabled>Open this select menu</option>';
              for (var i = 0; i < categories.length; i++) {
                if (categories[i].id == data.categories_id) {
                  html += '<option value="' + categories[i].id + '" selected>' + categories[i].name + '</option>';
                }
                else {
                  html += '<option value="' + categories[i].id + '">' + categories[i].name + '</option>';
                }
              }
              $('.modal-body #categories').html(html);
            }
          });

          // image src
          modal.find('.modal-body #image').attr('src', "{{ url('') }}" + '/' + data.image);
        }
        , error: function() {
          alert("Nothing Data");
        }
      });
    });
  });
</script>

<script>
  // update article
  $(document).ready(function() {
    $('#form-edit-article').submit(function(e) {
      e.preventDefault();
      var formData = new FormData(this);
      //append image in this
      //formData.append('image', $('#image-edit')[0].files[0]);
      //formData = JSON.stringify(Object.fromEntries(formData));
      //formData = formData.serialize();
      //console.log(formData);
      var id = $('#id').val();
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
        }
      });
      $.ajax({
        url: "{{ url('/api/v1/articles') }}" + '/' + id
        , type: "POST"
        , accept: 'application/json'
        , dataType: "JSON"
        , data: formData
        //, contentType: 'application/json'
        //, contentType: "multipart/form-data"
        , contentType: false
        , processData: false
        , cache: false
        , headers: {
          'Authorization': 'Bearer ' + localStorage.getItem('token')
        }
        , success: function(data) {
          $('#form-edit-article')[0].reset();
          $('#editArticle').modal('hide');
          alert('Data Updated');
          // refresh page
          location.reload();
        }
        , error: function(error) {
          alert(error.responseJSON.error);
        }
      });
    });
  });
</script>
<script>
  // if a href delete clicked
  $(document).ready(function() {
    $('#delete-article').click(function() {
      var id = $('#id').val();
      if (confirm("Are you sure you want to delete this?")) {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
          }
        });
        $.ajax({
          url: "{{ url('/api/v1/articles') }}" + '/' + id
          , type: "DELETE"
          , dataType: "JSON"
          , headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('token')
          }
          , success: function(data) {
            alert("Data Deleted");
            // refresh page
            location.reload();
          }
          , error: function(error) {
            alert(error.responseJSON.error);
          }
        });
      }
      else {
        return false;
      }
    });
  });
</script>

@endsection
