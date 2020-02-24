@extends('layouts.main')

@section('content')

    <div class="main-content">
        <!-- header area start -->
        <div class="header-area">
            <div class="row align-items-center">
                <!-- nav and search button -->
                <div class="col-md-6 col-sm-8 clearfix">
                    <div class="nav-btn pull-left">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- header area end -->
        <!-- page title area start -->
        <div class="page-title-area">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="breadcrumbs-area clearfix">
                        <h4 class="page-title pull-left">Dashboard</h4>
                        <ul class="breadcrumbs pull-left">
                            <li><a href="{{ route('clients') }}">Home</a></li>
                            <li><a href="{{ route('agents.index') }}">Agents</a></li>
                            <li><span>Agent {{ $agent->name }}</span></li>
                        </ul>
                    </div>
                </div>
                @include('userProfile')
            </div>
        </div>
        <!-- page title area end -->
        <div class="main-content-inner">
            <div class="col-12 mt-5">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @if($errors)
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                            @endif
                        </ul>
                    </div>
                @endif
                @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                <div class="card">
                    <div class="card-header">
                        Edit {{ $agent->name }}
                    </div>
                    <div class="card-body">
                        <form action="{{ route('agents.update',['agent'=> $agent->id]) }}" method="post">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label for="name" class="label">Name</label>
                                <input type="text" id="name" name="name" class="form-control"
                                       value="{{ $agent->name }}">
                            </div>
                            <div class="form-group">
                                <label for="email" class="label">Email</label>
                                <input type="text" id="email" name="email" class="form-control"
                                       value="{{ $agent->email }}">
                            </div>
                            <div class="form-group">
                                <label for="phone" class="label">Phone</label>
                                <input type="text" id="phone" name="phone" class="form-control"
                                       value="{{ $agent->phone }}">
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Edit" class="btn btn-primary btn-sm">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
