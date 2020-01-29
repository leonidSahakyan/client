<div class="modal-header">
    <h5 class="modal-title">Edit Agent</h5>
    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
</div>
<div class="modal-body">
    <form class="save-agent" action="JavaScript:void(0);">
        <label class='error_container'></label>
        <input type="hidden" name="client_id" value='{{$client->id}}' />
{{--        <div class="form-group" style="margin-bottom: 0;">--}}
{{--            <label class="col-form-label">--}}
{{--                <h6>Type: {{ $client->type == 1 ? "Lander": "Lawyer" }}</h6>--}}
{{--            </label>--}}
{{--        </div>--}}
        <div class="form-group" style="margin-bottom: 0;">
            <label class="col-form-label">
                <h5>Referral Source</h5>
            </label>
        </div>
{{--        <div class="form-group">--}}
{{--            <label for="example-term-input" class="col-form-label">Term (Months in integer)</label>--}}
{{--            <input class="form-control" min="0" type="number" name="term" value='{{ $client ? $client->term : "" }}' id="example-term-input" placeholder="Term">--}}
{{--        </div>--}}
        <div class="form-group">
            <label for="example-name-input" class="col-form-label">Name</label>
            <input class="form-control" type="text" name="name" value="{{$agent->name}}" id="example-name-input" placeholder="Name">
        </div>
        <div class="form-group">
            <label for="example-email-input" class="col-form-label">Email</label>
            <input class="form-control" type="email" name="email" value="{{$agent->email}}" id="example-email-input" placeholder="name@example.com">
        </div>
        <div class="form-group">
            <label for="example-tel-input" class="col-form-label">Phone</label>
            <input class="form-control" type="tel" name="phone" value="{{$agent->phone}}" id="example-tel-input" placeholder="123-456-789">
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" id='saveAgentBtn' onclick="saveAgent();" class="btn btn-success">Save</button>
</div>
