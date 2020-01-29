@extends('layouts.main')

@section('content')

<div class="main-content mortgages-settings">
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
                        <li><a href="">Home</a></li>
                        <li><span>Mortgages</span></li>
                    </ul>
                </div>
            </div>
            @include('userProfile')
        </div>
    </div>
    <!-- page title area end -->
    <div class="main-content-inner">
        <div class="row">
            <!-- Primary table start -->
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Mortgages settings</h4>
                        <form class="save-settings" action="JavaScript:void(0);">
                            <div>
                                <label class='error_container'></label>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- Mortgage -->
                                    <div class="form-group">
                                        <label for="mortgage_fee" class="col-form-label">Mortgage</label>
                                        <input class="form-control" type="number" name="mortgage_fee" value="{{ $fees['mortgage']['fee'] }}" id="mortgage_fee" placeholder="mortgage fee">
                                    </div>
                                    <!-- Broker -->
                                    <div class="form-group">
                                        <label for="broker_fee" class="col-form-label">Broker</label>
                                        <input class="form-control" type="number" name="broker_fee" value="{{ $fees['broker']['fee'] }}" id="broker_fee" placeholder="broker fee">
                                    </div>
                                    <!-- Lender -->
                                    <div class="form-group">
                                        <label for="lender_fee" class="col-form-label">Lender</label>
                                        <input class="form-control" type="number" name="lender_fee" value="{{ $fees['lender']['fee'] }}" id="lender_fee" placeholder="lender fee">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <!-- Admin -->
                                    <div class="form-group">
                                        <label for="admin_fee" class="col-form-label">Admin</label>
                                        <input class="form-control" type="number" name="admin_fee" value="{{ $fees['admin']['fee'] }}" id="admin_fee" placeholder="admin fee">
                                    </div>
                                    <!-- Lawyer -->
                                    <div class="form-group">
                                        <label for="lawyer_fee" class="col-form-label">Lawyer</label>
                                        <input class="form-control" type="number" name="lawyer_fee" value="{{ $fees['lawyer']['fee'] }}" id="lawyer_fee" placeholder="lawyer fee">
                                    </div>
                                    <!-- Appraisal -->
                                    <div class="form-group">
                                        <label for="appraisal_fee" class="col-form-label">Appraisal</label>
                                        <input class="form-control" type="number" name="appraisal_fee" value="{{ $fees['appraisal']['fee'] }}" id="appraisal_fee" placeholder="appraisal fee">
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-8">
                                    <div class="text-right" style="margin-left: auto;">
                                        <button type="button" id='saveSettingsBtn' onclick="saveSettings();" class="btn btn-success">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Primary table end -->

        </div>
    </div>
</div>

<script>
    function saveSettings(){
        var data = $('.save-settings').serialize();

        Loading.add($('#saveSettingsBtn'));
        $('.error_container').html('');
		$.ajax({
	        type: "GET",
	        url: "{{ route('save-settings') }}",
            data: data,
	        dataType: 'json',
	        success: function(response){
                Loading.remove($('#saveSettingsBtn'));
	            if(response.status === 0){
                    $('.error_container').html(response.errors);
	            }
	            if(response.status === 1){
                    //success
                    console.log(response)
	            }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                Loading.remove($('#saveSettingsBtn'));
            }
	    });
    }
</script>
@endsection
