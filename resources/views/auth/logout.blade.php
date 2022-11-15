@extends('layouts.app')

@section('script')
<script>
  // logout
  $(document).ready(function() {

    localStorage.removeItem('token');
    window.location.href = "{{ url('login') }}";
  });

</script>

@endsection
