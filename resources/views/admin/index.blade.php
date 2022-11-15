@extends('layouts.app')

@section('css')
      <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="alert alert-primary" role="alert">
            WELCOME ADMIN!
          </div>
        </div>
      </div>
    </div>

    
@endsection

@section('script')
  @include('layouts.auth');
@endsection
