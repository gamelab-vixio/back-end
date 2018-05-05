@extends('layout')

@section('title', 'Dashboard')

@section('content')

	<div class="col-sm-6 col-lg-3">
      <div class="card text-white bg-flat-color-1">
          <div class="card-body pb-0">
              <h5 class="text-white text-center">User Count</h5>
              <br/>
              <h3 class="mb-0 text-center">
                  <span class="count">329932932</span>
              </h3>
              <br/>    
          </div>
      </div>
  </div>

  <div class="col-sm-6 col-lg-3">
      <div class="card text-white bg-flat-color-3">
          <div class="card-body pb-0">
              <h5 class="text-white text-center">Story Count</h5>
              <br/>
              <h3 class="mb-0 text-center">
                  <span class="count">29392392</span>
              </h3>
              <br/>    
          </div>
      </div>
  </div>

@endsection