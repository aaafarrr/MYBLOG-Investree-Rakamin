{{-- LOGIN --}}
@extends('layouts.app')

@section('content')
<div class="container mb-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('Register') }}</div>

        <div class="card-body">
          <form>
            @csrf
            {{-- Name --}}
            <div class="form-outline mb-4">
              <input type="text" id="name" class="form-control" />
              <label class="form-label" for="name">Name</label>
            </div>

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
            <button type="button" class="btn btn-primary btn-block mb-4">Register</button>

            <!-- Register buttons -->
            <div class="text-center">
              <p>Already a member? <a href="{{ url('login') }}">Login</a></p>
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
  // Register
  $('.btn-primary').click(function() {
    // get data
    var name = $('#name').val();
    var email = $('#email').val();
    var password = $('#password').val();

    // check if empty
    if (name == '' || email == '' || password == '') {
      alert('Please fill all fields');
      return;
    }
    if (email.indexOf('@') == -1) {
      alert('Please enter a valid email address');
      return;
    }

    // send data to api with ajax jquery
    $.ajax({
      url: "{{ url('api/v1/auth/register') }}",
      type: "POST",
      data: {
        name: name,
        email: email,
        password: password
      },
      success: function(response) {
        //console.log(response);
        // save token in local storage
        localStorage.setItem('token', response.token);
        // redirect to admin
        window.location.href = "{{ url('admin') }}";
      },
      error: function(error) {
        console.log(error);
        alert(error.responseJSON.message);
      }
    });
  });
</script>

@endsection
