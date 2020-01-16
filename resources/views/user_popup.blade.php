<div class="modal-header">
    <h5 class="modal-title">{{ $user ? "Edit" : "Add" }} user</h5>
    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
</div>
<div class="modal-body">
    <form class="save-user" action="JavaScript:void(0);">
        <label class='error_container'></label>
        <input type="hidden" name="user_id" value='{{ $user ? $user->id : 0 }}' />
        <div class="form-group">
            <label for="example-name-input" class="col-form-label">Name</label>
            <input class="form-control" name="name" type="text" id="example-name-input" value='{{ $user ? $user->name : "" }}' placeholder="Name">
        </div>
        <div class="form-group">
            <label for="example-address-input" class="col-form-label">Address</label>
            <input class="form-control" name="address" type="text" id="example-address-input" value='{{ $user ? $user->address : "" }}' placeholder="Address">
        </div>

        <div class="form-group">
            <label for="example-tel-input" class="col-form-label">Phone</label>
            <input class="form-control" name="phone" type="tel" id="example-tel-input" value='{{ $user ? $user->phone : "" }}' placeholder="123-456-789">
        </div>

        <div class="form-group">
            <label for="example-email-input" class="col-form-label">Email</label>
            <input class="form-control" name="email" type="email" id="example-email-input" value='{{ $user ? $user->email : "" }}' placeholder="name@example.com">
        </div>

        <div class="form-group">
            <label for="example-password-input" class="col-form-label">Password</label>
            <input class="form-control" name="password" type="password" id="example-password-input" >
        </div>

        <div class="form-group">
            <label for="example-repassword-input" class="col-form-label">Re-password</label>
            <input class="form-control" name="password_confirmation" type="password" id="example-repassword-input" >
        </div>
    </form>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" id='saveUserBtn' onclick="saveUser();" class="btn btn-success">{{ $user ? "Save" : "Add" }}</button>
</div>