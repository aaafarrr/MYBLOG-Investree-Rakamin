{{-- LOGIN --}}
@extends('layouts.app')

@section('content')
<div class="container mb-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('Login') }}</div>

        <div class="card-body">
          <form>
            @csrf
            <!-- Email input -->
            <div class="form-outline mb-4">
              <input type="email" id="email" class="form-control" autocomplete="email" />
              <label class="form-label" for="email">Email address</label>
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
              <input type="password" id="password" class="form-control" autocomplete="current-password" />
              <label class="form-label" for="password">Password</label>
            </div>

            <!-- Submit button -->
            <button type="button" class="btn btn-primary btn-block mb-4">Sign in</button>

            <!-- Register buttons -->
            <div class="text-center">
              <p>Not a member? <a href="{{ url('register') }}">Register</a></p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')

<script>
  // check if the user is logged in
  if (localStorage.getItem('token')) {
    //check in api if true token
    axios.get("{{ url('api/v1/auth/me') }}", {
        headers: {
          'Authorization': 'Bearer ' + localStorage.getItem('token')
        }
      })
      .then(function(response) {
        // handle success
        //console.log(response);
        window.location.href = "{{ url('admin') }}";
      })
      .catch(function(error) {
        // handle error
        // remove token
        localStorage.removeItem('token');
        //console.log(error);
      })
      .then(function() {
        // always executed
      });
  }

</script>

<script>
  // Login
  $(document).ready(function() {
    $('.btn-primary').click(function() {
      var email = $('#email').val();

      var password = $('#password').val();
      var _token = $('input[name="_token"]').val();
      if (email == '' || password == '') {
        alert('Please fill in all the fields');
      } else {
        if (email.indexOf('@') == -1) {
          alert('Please enter a valid email address');
          return;
        }
        $.ajax({
          url: "{{ url('api/v1/auth/login') }}"
          , type: 'POST'
          , data: {
            email: email
            , password: password
          }
          , success: function(response) {
            //console.log(response);
            //get token save to local storage
            localStorage.setItem('token', response.token);
            //redirect to admin page
            window.location.href = "{{ url('admin') }}";
          },
          // if 401 response 
          error: function(response) {
            //console.log(response);
            alert(response.responseJSON.error);
          }
        });
      }
    });
  });

</script>

@endsection
