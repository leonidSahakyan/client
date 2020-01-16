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
            <!-- profile info & task notification -->
            <!-- <div class="col-md-6 col-sm-4 clearfix">
                <ul class="notification-area pull-right">
                    <li id="full-view"><i class="ti-fullscreen"></i></li>
                    <li id="full-view-exit"><i class="ti-zoom-out"></i></li>
                    <li class="dropdown">
                        <i class="ti-bell dropdown-toggle" data-toggle="dropdown">
                            <span>2</span>
                        </i>
                        <div class="dropdown-menu bell-notify-box notify-box">
                            <span class="notify-title">You have 3 new notifications <a href="#">view all</a></span>
                            <div class="nofity-list">
                                <a href="#" class="notify-item">
                                    <div class="notify-thumb"><i class="ti-key btn-danger"></i></div>
                                    <div class="notify-text">
                                        <p>You have Changed Your Password</p>
                                        <span>Just Now</span>
                                    </div>
                                </a>
                                <a href="#" class="notify-item">
                                    <div class="notify-thumb"><i class="ti-comments-smiley btn-info"></i></div>
                                    <div class="notify-text">
                                        <p>New Commetns On Post</p>
                                        <span>30 Seconds ago</span>
                                    </div>
                                </a>
                                <a href="#" class="notify-item">
                                    <div class="notify-thumb"><i class="ti-key btn-primary"></i></div>
                                    <div class="notify-text">
                                        <p>Some special like you</p>
                                        <span>Just Now</span>
                                    </div>
                                </a>
                                <a href="#" class="notify-item">
                                    <div class="notify-thumb"><i class="ti-comments-smiley btn-info"></i></div>
                                    <div class="notify-text">
                                        <p>New Commetns On Post</p>
                                        <span>30 Seconds ago</span>
                                    </div>
                                </a>
                                <a href="#" class="notify-item">
                                    <div class="notify-thumb"><i class="ti-key btn-primary"></i></div>
                                    <div class="notify-text">
                                        <p>Some special like you</p>
                                        <span>Just Now</span>
                                    </div>
                                </a>
                                <a href="#" class="notify-item">
                                    <div class="notify-thumb"><i class="ti-key btn-danger"></i></div>
                                    <div class="notify-text">
                                        <p>You have Changed Your Password</p>
                                        <span>Just Now</span>
                                    </div>
                                </a>
                                <a href="#" class="notify-item">
                                    <div class="notify-thumb"><i class="ti-key btn-danger"></i></div>
                                    <div class="notify-text">
                                        <p>You have Changed Your Password</p>
                                        <span>Just Now</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown">
                        <i class="fa fa-envelope-o dropdown-toggle" data-toggle="dropdown"><span>3</span></i>
                        <div class="dropdown-menu notify-box nt-enveloper-box">
                            <span class="notify-title">You have 3 new notifications <a href="#">view all</a></span>
                            <div class="nofity-list">
                                <a href="#" class="notify-item">
                                    <div class="notify-thumb">
                                        <img src="assets/images/author/author-img1.jpg" alt="image">
                                    </div>
                                    <div class="notify-text">
                                        <p>Aglae Mayer</p>
                                        <span class="msg">Hey I am waiting for you...</span>
                                        <span>3:15 PM</span>
                                    </div>
                                </a>
                                <a href="#" class="notify-item">
                                    <div class="notify-thumb">
                                        <img src="assets/images/author/author-img2.jpg" alt="image">
                                    </div>
                                    <div class="notify-text">
                                        <p>Aglae Mayer</p>
                                        <span class="msg">When you can connect with me...</span>
                                        <span>3:15 PM</span>
                                    </div>
                                </a>
                                <a href="#" class="notify-item">
                                    <div class="notify-thumb">
                                        <img src="assets/images/author/author-img3.jpg" alt="image">
                                    </div>
                                    <div class="notify-text">
                                        <p>Aglae Mayer</p>
                                        <span class="msg">I missed you so much...</span>
                                        <span>3:15 PM</span>
                                    </div>
                                </a>
                                <a href="#" class="notify-item">
                                    <div class="notify-thumb">
                                        <img src="assets/images/author/author-img4.jpg" alt="image">
                                    </div>
                                    <div class="notify-text">
                                        <p>Aglae Mayer</p>
                                        <span class="msg">Your product is completely Ready...</span>
                                        <span>3:15 PM</span>
                                    </div>
                                </a>
                                <a href="#" class="notify-item">
                                    <div class="notify-thumb">
                                        <img src="assets/images/author/author-img2.jpg" alt="image">
                                    </div>
                                    <div class="notify-text">
                                        <p>Aglae Mayer</p>
                                        <span class="msg">Hey I am waiting for you...</span>
                                        <span>3:15 PM</span>
                                    </div>
                                </a>
                                <a href="#" class="notify-item">
                                    <div class="notify-thumb">
                                        <img src="assets/images/author/author-img1.jpg" alt="image">
                                    </div>
                                    <div class="notify-text">
                                        <p>Aglae Mayer</p>
                                        <span class="msg">Hey I am waiting for you...</span>
                                        <span>3:15 PM</span>
                                    </div>
                                </a>
                                <a href="#" class="notify-item">
                                    <div class="notify-thumb">
                                        <img src="assets/images/author/author-img3.jpg" alt="image">
                                    </div>
                                    <div class="notify-text">
                                        <p>Aglae Mayer</p>
                                        <span class="msg">Hey I am waiting for you...</span>
                                        <span>3:15 PM</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="settings-btn">
                        <i class="ti-settings"></i>
                    </li>
                </ul>
            </div> -->
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
                        <li><span>Users</span></li>
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
                            <button type="button" class="btn btn-success" data-remote="{{ route('get-user') }}" data-toggle="modal" data-target="#exampleModalLong">Add user</button>
                        </div>
                        <h4 class="header-title">Users list</h4>

                        <div class="data-tables datatable-primary">
                            <table id="dataTable" class="text-center">
                                <thead class="text-capitalize">
                                    <tr>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Edit</th>
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
    <div class="modal-dialog">
        <div class="modal-content">
            
        </div>
    </div>
</div>
<!-- basic modal end -->

<script>
    $( document ).ready(function() {

        $('body').on('click', '[data-toggle="modal"]', function(){
            var user_id = $(this).data('user_id') > 0 ? $(this).data('user_id') : false;
            $($(this).data("target")+' .modal-content').load($(this).data("remote"), {user_id:user_id});
        });

        $("#exampleModalLong").on("hidden.bs.modal", function(){
            $(".modal-content").html("");
        });
        
        var table = $('#dataTable').DataTable({
            ajax: {
                url: "{{ route('users-data') }}",
                type: 'GET',
                "data": function (data) {   
                    var ajaxParams = {};
                    data['sort_field'] = data.columns[data.order[0].column].name;
                    data['sort_dir'] =  data.order[0].dir;

                    delete data.columns;
                    delete data.order;
                    
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
                    { "data": "name", "name":'users.name', "orderable": true },
                    { "data": "phone", "name":'users.phone', "orderable": true },
                    { "data": "email", "name":'users.email', "orderable": true },
                    { "data": "id", "name":'edit', "orderable": false, "sClass": "content-middel", 
                        render: function ( data, type, row, meta) {
                        return '<a href="javascript:;" class="btn" data-remote="{{ route('get-user') }}" data-toggle="modal" data-target="#exampleModalLong" data-user_id="'+row.id+'"><i class="fa fa-pencil""></i></a>';
                    }},
            ],
            "lengthMenu": [
                [10, 20, 50, 100, -1],
                [10, 20, 50, 100, "All"] // change per page values here
            ],
        });

        $("#exampleModalLong").on("hidden.bs.modal", function(){
            $(".modal-content").html("");
        });
    });
    function saveUser(){
        var data = $('.modal-body .save-user').serialize();
        
        Loading.add($('#saveUserBtn'));
        $('.error_container').html('');
		$.ajax({
	        type: "GET",
	        url: "{{ route('save-user') }}",
            data: data,
	        dataType: 'json',
	        success: function(response){
                Loading.remove($('#saveUserBtn'));
	            if(response.status == 0){
                    $('.error_container').html(response.errors);
	            }
	            if(response.status == 1){
                    $('#dataTable').DataTable().ajax.reload();
                    $('#exampleModalLong').modal('toggle');
	            }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) { 
                Loading.remove($('#saveUserBtn'));
            } 
	    });
	}
</script>
@endsection
