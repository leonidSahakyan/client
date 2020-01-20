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
                                <li><a href="">Home</a></li>
                                <li><span>Clients</span></li>
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
                                <div class="mb-3 d-flex justify-content-between">
                                    <button type="button" class="btn btn-success getClient" data-remote="{{ route('get-client') }}" data-toggle="modal" data-target="#exampleModalLong">Add Client</button>

                                    <select id="filter_status" class="custom-select" style="width: auto;">
                                        <option value="-1" selected="selected">Select status</option>
                                        <option value="1">Active</option>
                                        <option value="2">Completed</option>
                                        <option value="3">Cancelled</option>
                                    </select>
                                </div>

                                <h4 class="header-title">Clients list</h4>
                                <div class="data-tables datatable-primary">
                                    <table id="dataTable" class="text-center" style="width: 100%;">
                                        <thead class="text-capitalize">
                                            <tr role="row">
                                                <th>Renewal Date</th>
                                                <th>Closing date</th>
                                                <th>Name</th>
                                                <th>Address</th>
                                                <th>DOB</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th>Rate</th>
                                                <th>Fee</th>
                                                <th>Admin fee</th>
                                                <th>Mortgage amount</th>
                                                <th>Current mortgage</th>
                                                <th>Edit</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Primary table end -->
                </div>
            </div>
        </div>

<!-- basic modal start -->
<div class="modal fade" id="exampleModalLong">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

        </div>
    </div>
</div>
<!-- basic modal end -->
<!-- basic modal start -->
<div class="modal fade" id="agentPopup">
<div class="modal-dialog">
    <div class="modal-content">

    </div>
</div>
</div>
<!-- basic modal end -->
<script>
    $( document ).ready(function() {
        $('body').on('click', '.getClient', function(){
            var client_id = $(this).data('client_id') > 0 ? $(this).data('client_id') : false;
            $($(this).data("target")+' .modal-content').load("{{ route('get-client') }}", {client_id:client_id});
        });

        $( document ).on( "click", ".agent-popup-trigger", function() {
            var id = $(this).data('id');
            $($(this).data("target")+' .modal-content').load("{{ route('get-agent') }}", {id:id});
        });

        $("#exampleModalLong").on("hidden.bs.modal", function(){
            $(".modal-content").html("");
        });

        $("#agentPopup").on("hidden.bs.modal", function(){
            $(".modal-content").html("");
        });

        var table = $('#dataTable').DataTable({
            ajax: {
                url: "{{ route('clients-data') }}",
                type: 'GET',
                "data": function (data) {
                    var ajaxParams = {};
                    data['sort_field'] = data.columns[data.order[0].column].name;
                    data['sort_dir'] =  data.order[0].dir;

                    delete data.columns;
                    delete data.order;

                    data['filter_status'] = $('#filter_status').val();

                    $.each(ajaxParams, function (key, value) {
                        data[key] = value;
                    });
                },
            },
            _token: '<?php echo csrf_token(); ?>',
            responsive: true,
            serverSide: true,
            processing: false,
            columns: [
                    { "data": "renewal_date", "name":'clients.renewal_date', "orderable": true,
                        render: function ( data, type, row, meta) {
                        if(row.renewal_date && row.renewal_date != "0000-00-00"){
                            return row.renewal_date;
                        }else{
                            return '- - -';
                        }
                    }},
                    { "data": "closing_date", "name":'clients.closing_date', "orderable": true },
                    { "data": "agent_name", "name":'agents.name', "orderable": true },
                    { "data": "address", "name":'clients.address', "orderable": true },
                    { "data": "dob", "name":'clients.dob', "orderable": true },
                    { "data": "phone", "name":'clients.phone', "orderable": true },
                    { "data": "email", "name":'clients.email', "orderable": true },
                    { "data": "rate", "name":'clients.rate', "orderable": true },
                    { "data": "fee", "name":'clients.fee', "orderable": true },
                    { "data": "admin_fee", "name":'clients.admin_fee', "orderable": true },
                    { "data": "mortgage_amount", "name":'clients.mortgage_amount', "orderable": true },
                    { "data": "current_mortgage", "name":'clients.current_mortgage', "orderable": true },
                    { "data": "id", "name":'edit', "orderable": false, "sClass": "content-middel",
                        render: function ( data, type, row, meta) {
                        return '<a href="javascript:;" class="btn getClient" data-toggle="modal" data-target="#exampleModalLong" data-client_id="'+row.id+'"><i class="fa fa-pencil""></i></a>';
                    }},
                    { "data": "status", "name":'clients.status', "orderable": true,
                        render: function ( data, type, row, meta) {
                        var html = '<select data-id="'+row.id+'" class="custom-select change-status">';

                        var active = '';

                        if(row.status == 1)active = "selected='selected'";
                        html += "<option value='1' "+active+" >Active</option>";

                        active = '';
                        if(row.status == 2)active = "selected='selected'";
                        html += "<option value='2' "+active+" >Completed</option>";

                        html += '</select>';

                        return html;
                    }},
            ],
            "lengthMenu": [
                [10, 20, 50, 100, -1],
                [10, 20, 50, 100, "All"] // change per page values here
            ],
        });

        // Filter onchange
        $("#filter_status").on('change', function() {
            table.ajax.reload();
        });

        $( document ).on( "change", "#select-agent", function() {
            var agent_id = $(this).val();
            if(agent_id == "-1"){
                $('#agent_container').show();
            }else{
                $('#agent_container').hide();
            }
        });

        $( document ).on( "change", "#custom_fee_switcher", function() {
            var customFee = $(this).prop('checked');
            if(customFee){
                $('.popup-main').removeClass('col-6').addClass('col-4');
                $('.popup-secondary').removeClass('d-none').addClass('d-block');
            }else{
                $('.popup-main').removeClass('col-4').addClass('col-6');
                $('.popup-secondary').removeClass('d-block').addClass('d-none');
            }
        });

        $( document ).on( "change", "#select-type", function() {
            var type = $(this).val();
            if(type == 0){
                $('#lender_container').hide();
                $('#lawyer_container').hide();
            }else if(type == 1){
                $('#lender_container').show();
                $('#lawyer_container').hide();
            }else if(type == 2){
                $('#lawyer_container').show();
                $('#lender_container').hide();
            }
        });

        $( document ).on( "change", "#select-lender", function() {
            var lender_id = $(this).val();
            if(lender_id == "-1"){
                $('#lender_container_new').show();
            }else{
                $('#lender_container_new').hide();
            }
        });

        $( document ).on( "change", "#select-lawyer", function() {
            var lawyer_id = $(this).val();
            if(lawyer_id == "-1"){
                $('#lawyer_container_new').show();
            }else{
                $('#lawyer_container_new').hide();
            }
        });

        $( document ).on( "change", ".change-status", function() {

            var clientId = $(this).data('id');
            var status = $(this).val();

            $.ajax({
                type: "GET",
                url: "{{ route('change-status') }}",
                data: {clientId:clientId,status:status},
                dataType: 'json',
                success: function(response){
                    $('#dataTable').DataTable().ajax.reload();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {

                }
            });
        });
        ////
    });

    function saveClient(){
        var data = $('.modal-body .save-client').serialize();

        Loading.add($('#saveClientBtn'));
        $('.error_container').html('');
		$.ajax({
	        type: "GET",
	        url: "{{ route('save-client') }}",
            data: data,
	        dataType: 'json',
	        success: function(response){
                Loading.remove($('#saveClientBtn'));
	            if(response.status == 0){
                    $('.error_container').html(response.errors);
	            }
	            if(response.status == 1){
                    $('#dataTable').DataTable().ajax.reload();
                    $('#exampleModalLong').modal('toggle');
	            }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                Loading.remove($('#saveClientBtn'));
            }
	    });
    }

    function saveAgent(){
        var data = $('.modal-body .save-agent').serialize();

        Loading.add($('#saveAgentBtn'));
        $('.error_container').html('');
		$.ajax({
	        type: "GET",
	        url: "{{ route('save-agent') }}",
            data: data,
	        dataType: 'json',
	        success: function(response){
                Loading.remove($('#saveAgentBtn'));
	            if(response.status == 0){
                    $('.error_container').html(response.errors);
	            }
	            if(response.status == 1){
                    $('#dataTable').DataTable().ajax.reload();
                    $('#agentPopup').modal('toggle');
	            }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                Loading.remove($('#saveAgentBtn'));
            }
	    });
	}
</script>
@endsection
