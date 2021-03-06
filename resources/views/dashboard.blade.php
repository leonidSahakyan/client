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
                                <button type="button" class="btn btn-success getClient btn-sm"
                                        data-remote="{{ route('get-client') }}" data-toggle="modal"
                                        data-target="#exampleModalLong">Add Client
                                </button>
                                <select id="filter_by_agent" class="custom-select data_filter w-auto"
                                        style="width: auto">
                                    <option value="" selected>Filter By Agent</option>
                                    @foreach($agents as $agent)
                                        @if ($agent->type == 1)
                                            <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <select id="filter_by_lender" class="custom-select data_filter w-auto"
                                        style="width: auto">
                                    <option value="" selected>Filter By Lender</option>
                                    @foreach($agents as $agent)
                                        @if ($agent->type == 2)
                                            <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <select id="filter_by_lawyer" class="custom-select data_filter" style="width: auto">
                                    <option value="" selected>Filter By Lawyer</option>
                                    @foreach($agents as $agent)
                                        @if ($agent->type == 3)
                                            <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                        @endif
                                    @endforeach
                                </select>

                                <select id="filter_status" class="custom-select data_filter" style="width: auto">
                                    <option value="-1" selected="selected">Select status</option>
                                    <option value="1">Active</option>
                                    <option value="2">Completed</option>
                                    <option value="3">Cancelled</option>
                                </select>
                                <a href="{{ route('clients') }}" class="btn btn-info btn-sm resetFilter">Reset
                                    filter</a>
                            </div>

                            <h4 class="header-title">Clients list</h4>
                            <div class="data-tables datatable-primary">
                                <table id="dataTable" class="text-center" style="width: 100%;">
                                    <thead class="text-capitalize">
                                    <tr role="row">
                                        <th>Renewal Date</th>
                                        <th>IAD</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Rate</th>
                                        <th>Mortgage Amount</th>
                                        <th>Mortgage Balance</th>
                                        <th>Monthly Payment</th>
                                        <th>Actions</th>
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

    <section class="main-modal" id="main-modal-content" style="display: none;">
        <div class="main-modal-content">
            <div class="main-credit-modal-content">
                <button class="main-modal__close" href="#" onclick="closeModal()"><i class="fa fa-times"></i></button>
                <div class="main-modal__body" id="calculator-table">
                    <h3 class="main-moda-table__title">Payment Schedule
                        <form action="{{ route('export_calculator') }}" target="_blank" method="post">
                            <input type="hidden" id="table-content" name="content">
                            @csrf
                            <button type="button" class="printCalculator" onclick="printPDF(this)">
                                <i class="fa fa-print"></i>
                            </button>
                        </form>
                    </h3>
                    <div class="main-table-body">
                        <table>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Interest</th>
                                <th>Principal</th>
                                <th>Payment</th>
                                <th>Balance</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="main-table-body second-body">
                        <table>

                            <tbody id="table">
                            </tbody>
                        </table>
                    </div>
                    <div class="main-table-footer" style="margin-right: 8px;"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- basic modal end -->
    <script type="text/javascript">
        const _token = '<?php echo csrf_token(); ?>';

        function printPDF(This) {
            document.getElementById('table-content').value = document.querySelector('div#calculator-table').innerHTML;
            This.form.submit();
        }

        $(document).ready(function () {
            $('body').on('click', '.getClient', function () {
                var client_id = $(this).data('client_id') > 0 ? $(this).data('client_id') : false;
                $($(this).data("target") + ' .modal-content').load("{{ route('get-client') }}", {client_id: client_id});
            });

            $(document).on("click", ".agent-popup-trigger", function () {
                var id = $(this).data('id');
                $($(this).data("target") + ' .modal-content').load("{{ route('get-agent') }}", {id: id});
            });

            $("#exampleModalLong").on("hidden.bs.modal", function () {
                $(".modal-content").html("");
            });

            $("#agentPopup").on("hidden.bs.modal", function () {
                $(".modal-content").html("");
            });

            var table = $('#dataTable').DataTable({
                ajax: {
                    url: "{{ route('clients-data') }}",
                    type: 'GET',
                    "data": function (data) {
                        var ajaxParams = {};
                        data['sort_field'] = data.columns[data.order[0].column].name;
                        data['sort_dir'] = data.order[0].dir;
                        delete data.columns;
                        delete data.order;

                        data['filter_status'] = $('#filter_status').val();
                        data['agent_id'] = $('#filter_by_agent').val();
                        data['lender_id'] = $('#filter_by_lender').val();
                        data['lawyer_id'] = $('#filter_by_lawyer').val();

                        $.each(ajaxParams, function (key, value) {
                            data[key] = value;
                        });
                    },
                },
                _token: _token,
                responsive: true,
                serverSide: true,
                processing: false,
                columns: [
                    {"data": "renewal_date", "name": 'clients.renewal_date', "orderable": true,},
                    {"data": "iad", "name": 'clients.ida', "orderable": false},
                    {"data": "client_name", "name": 'agents.name', "orderable": false},
                    {"data": "phone", "name": 'clients.phone', "orderable": false},
                    {"data": "email", "name": 'clients.email', "orderable": false},
                    {"data": "rate", "name": 'clients.rate', "orderable": false},
                    {"data": "mortgage_amount", "name": 'clients.mortgage_amount', "orderable": false},
                    {
                        "data": "mortgage_amount", "orderable": false,
                        render: function (data, type, row) {

                            if (!row.mortgage_amount
                                ||
                                (!row.term  && row.payment_type === 1)
                                ||
                                (!row.amortization_period && row.payment_type === 2)){
                                return '';
                            }

                            let params = {
                                'amount': row.mortgage_amount ? Number(row.mortgage_amount.replace('$', '')) : null,
                                'rate': row.rate ? parseFloat(row.rate.replace('%', '')) : null,
                                'amortization_period': row.amortization_period,
                                'start_date': row.iad,
                                'payment_type': row.payment_type,
                                'term': row.term,
                            };

                            return monthlyPayment(params, false)?monthlyPayment(params, false):''
                        }
                    },
                    {
                        "data": "mortgage_amount", "orderable": false,
                        render: function (data, type, row) {
                            if (!row.mortgage_amount || (!row.term  && row.payment_type === 1) || (!row.amortization_period && row.payment_type === 2)){
                                return '';
                            }
                            let params = {
                                'amount': row.mortgage_amount ? Number(row.mortgage_amount.replace('$', '')) : null,
                                'rate': row.rate ? parseFloat(row.rate.replace('%', '')) : null,
                                'amortization_period': row.amortization_period,
                                'start_date': row.iad,
                                'payment_type': row.payment_type,
                                'term': row.term,
                            };
                            return monthlyPayment(params, true)?monthlyPayment(params, true):'';
                        }
                    },
                    {
                        "data": "id", "name": 'edit', "orderable": false, "sClass": "content-middel",
                        render: function (data, type, row, meta) {
                            let url = "{{ route('show-client',':id') }}",
                                deleteClient = "{{ route('client-destroy') }}",
                                exportWord = "{{ route('export_word',':id') }}";
                            url = url.replace(':id', row.id);
                            exportWord = exportWord.replace(':id', row.id);

                            return '<a href="javascript:;" class="btn getClient" title="Edit" data-toggle="modal" data-target="#exampleModalLong" data-client_id="' + row.id + '"><i class="fa fa-pencil"></i></a>'
                                +
                                '<a href="' + url + '" class="btn ml-3" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>'
                                +
                                '<a href="' + exportWord + '" class="btn ml-3" title="Print"><i class="fa fa-print" aria-hidden="true"></i></a>'
                                +
                                '<a href="' + deleteClient + "/" + row.id + '" class="btn ml-3" title="Remove"><i class="fa fa-trash-o" aria-hidden="true"></i></i></a>'
                                ;
                        }
                    },
                    {
                        "data": "status", "name": 'clients.status', "orderable": false,
                        render: function (data, type, row, meta) {

                            if (row.status === 1){
                                data =  'Active';
                            }else if (row.status === 2){
                                data =  'Completed';
                            }
                            else{
                                data =   'Cancelled'
                            }
                            return data;

                        }
                    },
                ],
                "lengthMenu": [
                    [10, 20, 50, 100, -1],
                    [10, 20, 50, 100, "All"] // change per page values here
                ],
            });

            // Filter onchange
            $(".data_filter").on('change', function () {
                table.ajax.reload();
            });

            $(document).on("change", "#select-agent", function () {
                var agent_id = $(this).val();
                if (agent_id == "-1") {
                    $('#agent_container').show();
                } else {
                    $('#agent_container').hide();
                }
            });

            $(document).on("change", "#custom_fee_switcher", function () {
                var customFee = $(this).prop('checked');
                if (customFee) {
                    $('.popup-main').removeClass('col-6').addClass('col-4');
                    $('.popup-secondary').removeClass('d-none').addClass('d-block');
                } else {
                    $('.popup-main').removeClass('col-4').addClass('col-6');
                    $('.popup-secondary').removeClass('d-block').addClass('d-none');
                }
            });

            $(document).on("change", "#select-lender", function () {
                var lender_id = $(this).val();
                if (lender_id == "-1") {
                    $('#lender_container_new').show();
                } else {
                    $('#lender_container_new').hide();
                }
            });

            $(document).on("change", "#select-lawyer", function () {
                var lawyer_id = $(this).val();
                if (lawyer_id == "-1") {
                    $('#lawyer_container_new').show();
                } else {
                    $('#lawyer_container_new').hide();
                }
            });

            $(document).on("change", ".change-status", function () {

                var clientId = $(this).data('id');
                var status = $(this).val();

                $.ajax({
                    type: "GET",
                    url: "{{ route('change-status') }}",
                    data: {clientId: clientId, status: status},
                    dataType: 'json',
                    success: function (response) {
                        $('#dataTable').DataTable().ajax.reload();
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {

                    }
                });
            });
            ////
        });

        function saveClient() {
            var data = $('.modal-body .save-client').serialize();

            Loading.add($('#saveClientBtn'));
            $('.error_container').html('');
            $.ajax({
                type: "GET",
                url: "{{ route('save-client') }}",
                data: data,
                dataType: 'json',
                success: function (response) {
                    Loading.remove($('#saveClientBtn'));
                    if (response.status === 0) {
                        $('.error_container').html(response.errors);
                        document.getElementById('exampleModalLong').scrollTo(0, 0);
                    }
                    if (response.status === 1) {
                        $('#dataTable').DataTable().ajax.reload();
                        $('#exampleModalLong').modal('toggle');
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    Loading.remove($('#saveClientBtn'));
                }
            });
        }

        function saveAgent() {
            var data = $('.modal-body .save-agent').serialize();

            Loading.add($('#saveAgentBtn'));
            $('.error_container').html('');
            $.ajax({
                type: "GET",
                url: "{{ route('save-agent') }}",
                data: data,
                dataType: 'json',
                success: function (response) {
                    Loading.remove($('#saveAgentBtn'));
                    if (response.status == 0) {
                        $('.error_container').html(response.errors);
                    }
                    if (response.status == 1) {
                        $('#dataTable').DataTable().ajax.reload();
                        $('#agentPopup').modal('toggle');
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    Loading.remove($('#saveAgentBtn'));
                }
            });
        }

    </script>
@endsection
