<script>
  // check if the user is logged in
  if (localStorage.getItem('token')) {
    //check in api if true token
    axios.get("{{ url('api/v1/auth/me') }}", {
        headers: {
          'Accept': 'application/json',
          'Authorization': 'Bearer ' + localStorage.getItem('token')
        }
      })
      .then(function(response) {
        // handle success
        // console.log(response);
        //window.location.href = "{{ url('admin') }}";
      })
      .catch(function(error) {
        // handle error
        // console.log(error);
        alert('Please login first');
        window.location.href = "{{ url('login') }}";
      })
      .then(function() {
        // always executed
      });
  } else {
    alert('Please login first!');
    window.location.href = "{{ url('login') }}";
  }
</script>
