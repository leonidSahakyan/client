@extends('layouts.main')

@section('content')
    <div class="main-content">
        <!-- header area start -->
        <div class="header-area">
            <div class="row align-items-center">
                <!-- nav and search button -->
                <div class="col-md-3 col-sm-8 clearfix">
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
                            <li><a href="">Home</a></li>
                            <li><a href="{{ route('clients') }}">Clients</a></li>
                            <li><span>Client -> {{$client->name}}</span></li>
                        </ul>
                    </div>
                </div>
                @include('userProfile')
            </div>
        </div>
        <div class="main-content-inner">
            {{--            @dump($client)--}}
            <div class="row">
                <div class="col-md-4 mt-5">
                    <div class="card ">
                        <div class="card-body">
                            <h4 class="header-title">Client information</h4>
                            <div class="single-table">
                                <div class="table-responsive">
                                    <table class="table table-striped text-center">
                                        <tbody>
                                        <tr>
                                            <th scope="row">Full name</th>
                                            <td>{{ $client->name }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Email</th>
                                            <td><a href="mailto: {{ $client->email }}">{{ $client->email }}</a></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Phone</th>
                                            <td>{{ $client->phone }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Mailing address</th>
                                            <td>{{ $client->mailing_address }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Property Security</th>
                                            <td>
                                                @foreach(unserialize($client->property_security) as $val)
                                                    {{ $val.'<br>'?$val:'' }}
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Address</th>
                                            <td>{{ $client->address }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">DOB</th>
                                            <td>{{ date('d.m.Y',strtotime($client->dob)) }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Add co-signor</th>
                                            <td>
                                                @if($client->co_signor){
                                                    @foreach(json_decode($client->co_signor) as $item)
                                                        {{ $item }}<br>
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Legal PID</th>
                                            <td>{{ $client->legal_pid }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mt-5">
                    <div class="card ">
                        <div class="card-body">
                            <h4 class="header-title">Description</h4>
                            <div class="single-table">
                                <div class="table-responsive">
                                    <table class="table table-striped text-center">
                                        <tbody>
                                        @if($lender)
                                            <tr>
                                                <th scope="row">Lender name</th>
                                                <td>{{ $lender->name }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Lender email</th>
                                                <td><a href="mailto: {{ $lender->email }}">{{ $lender->email }}</a></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Lender phone</th>
                                                <td>{{ $lender->phone }}</td>
                                            </tr>
                                        @endif
                                        @if($lawyer)
                                            <tr>
                                                <th scope="row">Lawyer name</th>
                                                <td>{{ $lawyer->name }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Lawyer email</th>
                                                <td><a href="mailto: {{ $lawyer->email }}">{{ $lawyer->email }}</a></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Lawyer phone</th>
                                                <td>{{ $lawyer->phone }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th scope="row">Status</th>
                                            <td>
                                                @if($client->staus ==1)
                                                    Active
                                                @elseif($client->status == 2)
                                                    Completed
                                                @else
                                                    Cancelled
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Closing date</th>
                                            <td>{{ $client->closing_date }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">IAD</th>
                                            <td>{{ $client->iad }}</td>
                                        </tr>
                                        @if($agent)
                                            <tr>
                                                <th scope="row">Referral name</th>
                                                <td>{{ $agent->name }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Referral email</th>
                                                <td><a href="mailto: {{ $agent->email }}">{{ $agent->email }}</a></td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Referral phone</th>
                                                <td>{{ $agent->phone }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th scope="row">Amount</th>
                                            <td>{{ $client->amount }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Term</th>
                                            <td>{{ $client->term }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Rate</th>
                                            <td>{{ $client->rate }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if($fee = unserialize($client->settings))
                    <div class="col-md-4 mt-5">
                        <div class="card ">
                            <div class="card-body">
                                <h4 class="header-title">Fees/Cost of Credit</h4>
                                <div class="single-table">
                                    <div class="table-responsive">
                                        <table class="table table-striped text-center">
                                            <tbody>
                                            <tr>
                                                <th scope="row">iMortgage</th>
                                                <td>${{ $fee['mortgage']['fee'] }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Broker</th>
                                                <td>${{ $fee['broker']['fee'] }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Lender</th>
                                                <td>${{ $fee['lender']['fee'] }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Admin</th>
                                                <td>${{ $fee['admin']['fee'] }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Lawyer</th>
                                                <td>${{ $fee['lawyer']['fee'] }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Appraisal</th>
                                                <td>${{ $fee['appraisal']['fee'] }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
