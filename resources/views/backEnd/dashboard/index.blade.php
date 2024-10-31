@extends('backEnd.layouts.main')
@section('title', 'Dashboard - '.config('app.name'))
@section('content')
<div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>
</div>
<section class="section dashboard">
    <div class="row">
        <div class="col-md-12  text-center">
            <div class="card shadow">
                <div class="card-header">
                    <img src="{{asset('assets/img/sman1.jfif')}}" alt="" height="130">
                </div>
                <div class="card-body">
                    <div class="alert alert-info" role="alert">
                        <h4 class="alert-heading">Welcome {{Auth::user()->name}}</h4>
                        <p>Happy {{date('l')}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </section>
@endsection
