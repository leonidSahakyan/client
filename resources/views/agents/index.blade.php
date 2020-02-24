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
                            <li><span>Agents</span></li>
                        </ul>
                    </div>
                </div>
                @include('userProfile')
            </div>
        </div>
        <!-- page title area end -->
        <div class="main-content-inner">
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="dropdown col-12 mb-3">
                            <a href="{{ route('agents.create') }}"  class="btn btn-flat btn-success">Create Agent</a>
                            <button class="btn btn-flat btn-primary dropdown-toggle" type="button"
                                    id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                @if($type === 1)
                                    Agent
                                @elseif ($type === 2)
                                    Lender
                                @else
                                    Lawyer
                                @endif
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{ route('agents.index') }}?type=1">Agent</a>
                                <a class="dropdown-item" href="{{ route('agents.index') }}?type=2">Lender</a>
                                <a class="dropdown-item" href="{{ route('agents.index') }}?type=3">Lawyer</a>
                            </div>
                        </div>
                        <div class="single-table">
                            <div class="table-responsive">
                                <table class="table table-hover text-center">
                                    <thead class="text-uppercase">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($agents) > 0)
                                        @foreach($agents as $agent)
                                            <tr>
                                                <th scope="row">{{ $agent->id }}</th>
                                                <td>{{ $agent->name }}</td>
                                                <td>{{ $agent->phone }}</td>
                                                <td>{{ $agent->email }}</td>
                                                <td>
                                                    @if($agent->type === 1)
                                                        Agent
                                                    @elseif ($agent->type === 2)
                                                        Lender
                                                    @else
                                                        Lawyer
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Actions">
                                                        <a href="{{ route('agents.edit',['agent'=>$agent->id]) }}" class="btn btn-xs btn-primary">
                                                            <i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i>
                                                        </a>
                                                        <form action="{{ route('agents.destroy',['agent' => $agent->id]) }}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-xs btn-danger">
                                                                <i class="fa fa-trash-o fa-lg" aria-hidden="true"></i>
                                                            </button>
                                                        </form>
                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                    {!! $agents->render() !!}
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

