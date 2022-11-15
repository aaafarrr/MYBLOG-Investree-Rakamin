<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>MY BLOG</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
  <nav class="navbar navbar-expand-lg bg-light mb-5">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">MY BLOG</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link {{ (request()->is('admin')) ? 'active' : '' }}" aria-current="page" href="{{ url('admin') }}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ (request()->is('article')) ? 'active' : '' }}" href="{{ url('article') }}">Article</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ (request()->is('category')) ? 'active' : '' }}" href="{{ url('category') }}">Category</a>
          </li>
        </ul>
        <div class="d-flex" role="search">
          <a class="btn btn-outline-success" href="{{ url('login') }}">Login</a>
        </div>
      </div>
    </div>
  </nav>

  @yield('content')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

  <script>
    // navbar if login
    if (localStorage.getItem('token')) {
      //check in api if true token
      axios.get("{{ url('api/v1/auth/me') }}", {
          headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('token')
          }
        })
        .then(function(response) {
          // handle success
          // console.log(response);
          $('.nav-item').show();
          $('.nav-item.disabled').hide();

          $('.d-flex').html(`
          <a class="btn btn-outline-success" href="{{ url('logout') }}">Logout</a>
        `);
        })
        .catch(function(error) {
          // handle error
          // console.log(error);
          // remove token
          localStorage.removeItem('token');
        })
        .then(function() {
          // always executed
        });
    }else{
      $('.nav-item').hide();
      $('.nav-item.disabled').show();
    }
  </script>

  @yield('script')

</body>
</html>
