@extends('layouts.app')

@section('css')
<link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection

@section('content')
{{-- form CARD --}}
<div class="container">
  <div class="row">
    <div class="col-12">
      <div class="card mb-5">
        <div class="card-header">
          Add Categories
        </div>
        <div class="card-body">
          <form id="form-category" action="{{ url('api/v1/categories/') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="name">
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
          ALL CATEGORIES
        </div>
        <div class="card-body">
          <table id="categories" class="table table-striped" style="width:100%">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th>Name</th>
                <th>Adder</th>
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

{{-- MODAL EDIT AND DELETE CATEGORY BOOTSTRAP 5 --}}
<div class="modal fade" id="editCategory" tabindex="-1" aria-labelledby="editCategoryLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editCategoryLabel">Edit Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <form id="form-edit-category" action="{{ url('api/v1/categories/') }}" method="PUT" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name">
          </div>
          <button class="btn btn-primary">Submit</button>
          {{-- DELETE --}}
          <a id="delete-category" class="btn btn-danger">Delete</a>
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

<script>
  // get data from api
  $(document).ready(function() {
    $.getJSON("{{ url('/api/v1/categories') }}", function(returndata) {
      //console.log(returndata);
      $('#categories').DataTable({
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
            data: 'name'
            , title: 'Name'
          }
          , {
            data: 'user.name'
            , title: 'Adder'
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
          //action
          {
            data: 'id'
            , title: 'Action'
            , render: function(data) {
              return '<button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editCategory" data-id="' + data + '">Edit/Delete</button>';
            }
          },

        ]
      });
    });
  });
</script>

<script>
  // send post articles
  $(document).ready(function() {
    $('#form-category').submit(function(e) {
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
        }
        // send data and image to api
        , data: formData
        , contentType: false
        , success: function(response) {
          if (response) {
            $('#form-category')[0].reset();
            alert('Data Saved');
            // refresh page
            location.reload();
          }
        }
        , error: function(error) {
          //console.log(error);
          alert(error.responseJSON.error);
        },
      });
    });
  });
</script>

<script>
  //edit modal category
  $(document).ready(function() {
    $('#editCategory').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget)
      var id = button.data('id')
      var modal = $(this)
      $.ajax({
        url: "{{ url('api/v1/categories/') }}" + '/' + id
        , type: "GET"
        , dataType: "JSON"
        , headers: {
          'Authorization': 'Bearer ' + localStorage.getItem('token')
        }
        , success: function(response) {
          //console.log(response);
          modal.find('.modal-body #name').val(response.category.name);
          modal.find('.modal-body #form-edit-category').attr('action', "{{ url('api/v1/categories/') }}" + '/' + id);
        }
        , error: function(error) {
          alert("Nothing Data");
        },
      });
    });
  });
</script>

<script>
  // send put category
  $(document).ready(function() {
    $('#form-edit-category').submit(function(e) {
      e.preventDefault();
      var formData = new FormData(this);
      // formdata to json
      var object = {};
      formData.forEach(function(value, key) {
        object[key] = value;
      });
      var json = JSON.stringify(object);
      //console.log(json);
      
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
        }
        // send data and image to api
        , data: json
        //, contentType: false
        , contentType: 'application/json'
        , success: function(response) {
          if (response) {
            $('#form-edit-category')[0].reset();
            alert('Data Updated');
            // refresh page
            location.reload();
          }
        }
        , error: function(error) {
          //console.log(error);
          alert(error.responseJSON.error);
        },
      });
    });
  });
</script>

<script>
  // if a href delete clicked
  $(document).ready(function() {
    $('#delete-category').click(function() {
      var id = $('#form-edit-category').attr('action').split('/').pop();
      if (confirm("Are you sure you want to delete this? *the article was also deleted")) {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('value')
          }
        });
        $.ajax({
          url: "{{ url('/api/v1/categories') }}" + '/' + id
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
