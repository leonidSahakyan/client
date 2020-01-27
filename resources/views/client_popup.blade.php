<div class="modal-header">
    <h5 class="modal-title">{{ $client ? "Edit" : "Add" }} client</h5>
    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
</div>
<div class="modal-body">
    <form class="save-client" action="JavaScript:void(0);" autocomplete="off">
        <label class='error_container'></label>
        <div class="s-sw-title custom-fee-swicher">
            <h5>Custom fee</h5>
            <div class="s-swtich">
                <input type="checkbox" name="custom_fee_switcher"
                       {{ $client && $client->custom_fee == 1 ? 'checked="checked"' : "" }} id="custom_fee_switcher">
                <label for="custom_fee_switcher">Toggle</label>
            </div>
        </div>
        <input type="hidden" name="client_id" value='{{ $client ? $client->id : 0 }}'/>
        <div class="row">
            <div class="{{ $client && $client->custom_fee == 1 ? 'col-4' : 'col-6' }} popup-main">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Personal information</legend>
                    <div class="form-group">
                        <label for="example-name-input" class="col-form-label">Name</label>
                        <input class="form-control" name="name" value="{{ $client ? $client->name : "" }}" type="text"
                               id="example-name-input" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="example-email-input" class="col-form-label">Email</label>
                        <input class="form-control" type="email" name="email"
                               value="{{ $client ? $client->email : "" }}"
                               id="example-email-input" placeholder="name@example.com">
                    </div>
                    <div class="form-group">
                        <label for="example-tel-input" class="col-form-label">Phone</label>
                        <input class="form-control" name="phone" value="{{ $client ? $client->phone : "" }}" type="tel"
                               id="example-tel-input" placeholder="123-456-789">
                    </div>
                    <div class="form-group">
                        <label for="mailing_address">Mailing address</label>
                        <input type="text" id="mailing_address" class="form-control" name="mailing_address" value="{{ $client? $client->mailing_address:"" }}">
                    </div>
                    <div class=" form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="sameMailingAddress" onchange=" setMailingAddress(this)">
                            <label class="form-check-label" for="sameMailingAddress">Same a Mailing Address</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="property_security" class="col-form-label">Property Security</label>
                        <input type="text" class="form-control" id="property_security" name="property_security" value="{{ $client? $client->property_security:"" }}">
                    </div>
                    <div class="form-group">
                        <label for="example-address-input" class="col-form-label">Address</label>
                        <input class="form-control" type="text" name="address"
                               value="{{ $client ? $client->address : "" }}"
                               id="example-address-input" placeholder="Address">
                    </div>
                    <div class="form-group">
                        <label for="example-date-input1" class="col-form-label">DOB</label>
                        <input class="form-control" name="dob" value="{{ $client ? $client->dob : "" }}" type="date"
                               id="example-date-input2">
                    </div>
                    <div class="form-group">
                        <label for="description">Legal description</label>
                        <textarea name="description" id="description" class="form-control"
                                  rows="5">{{ ($client && $client->description) ? $client->description :'' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="co_signor" class="col-form-label">Add co-signor</label>
                        <div class="select-2-content">
                            <select class="js-co_signor form-control" id="co_signor" multiple="multiple"
                                    name="co_signor[]">
                                @if( $client &&  $client->co_signor)
                                    @foreach(json_decode($client->co_signor,true) as $key => $val)
                                        <option value="{{ $val }}" selected="selected">{{ $val }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="legal_pid">Legal PID</label>
                        <input type="text" class="form-control" id="legal_pid" name="legal_pid" value="{{ $client ? $client->legal_pid:'' }}">
                    </div>
                </fieldset>
            </div>

            <div class="{{ $client && $client->custom_fee == 1 ? 'col-4' : 'col-6' }} popup-main">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Description</legend>
                    <div id="lender_container" class="d-block">
                        <div class="form-group">
                            <label class="col-form-label" for="select-lender">Lender</label>
                            <select class="custom-select form-control" name="lender_id" id="select-lender">
                                <option selected="selected" disabled="disabled">Select lender</option>
                                <option value="-1">Create New</option>
                                @foreach ($agents as $agent)
                                    @if ($agent->type != 2) @continue @endif
                                    <option
                                        {{ $client && $client->lender_id == $agent->id ? 'selected="selected"' : "" }} value="{{$agent->id}}">{{$agent->name}}
                                        ({{$agent->phone}})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div id="lender_container_new" class="main-form-content">
                            <div class="form-group">
                                <label for="example-lender-name-input" class="col-form-label">Name</label>
                                <input class="form-control" name="lender_name" type="text"
                                       id="example-lender-name-input"
                                       placeholder="Name">
                            </div>
                            <div class="form-group">
                                <label for="example-lender-email-input" class="col-form-label">Email</label>
                                <input class="form-control" type="email" name="lender_email"
                                       id="example-lender-email-input"
                                       placeholder="name@example.com">
                            </div>
                            <div class="form-group">
                                <label for="example-lender-tel-input" class="col-form-label">Phone</label>
                                <input class="form-control" type="tel" name="lender_phone" id="example-lender-tel-input"
                                       placeholder="123-456-789">
                            </div>
                        </div>
                    </div>
                    <div id="lawyer_container" class="d-block">
                        <div class="form-group">
                            <label for="select-lawyer" class="col-form-label">Lawyer</label>
                            <select  class="custom-select form-control" name="lawyer_id" id="select-lawyer">
                                <option selected="selected" disabled="disabled">Select lawyer</option>
                                <option value="-1">Create New</option>
                                @foreach ($agents as $agent)
                                    @if ($agent->type != 3) @continue @endif
                                    <option
                                        {{ $client && $client->lawyer_id == $agent->id ? 'selected="selected"' : "" }} value="{{$agent->id}}">{{$agent->name}}
                                        ({{$agent->phone}})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div id="lawyer_container_new" class="main-form-content">
                            <div class="form-group">
                                <label for="example-lawyer-name-input" class="col-form-label">Name</label>
                                <input class="form-control" name="lawyer_name" type="text"
                                       id="example-lawyer-name-input"
                                       placeholder="Name">
                            </div>
                            <div class="form-group">
                                <label for="example-lawyer-email-input" class="col-form-label">Email</label>
                                <input class="form-control" type="email" name="lawyer_email"
                                       id="example-lawyer-email-input"
                                       placeholder="name@example.com">
                            </div>
                            <div class="form-group">
                                <label for="example-lawyer-tel-input" class="col-form-label">Phone</label>
                                <input class="form-control" type="tel" name="lawyer_phone" id="example-lawyer-tel-input"
                                       placeholder="123-456-789">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Status</label>
                        <select name="status" class="custom-select form-control">
                            <option selected="selected" disabled="disabled">Select status</option>
                            <option
                                {{ ($client && $client->status == 1) || (!$client)  ? 'selected="selected"' : "" }} value="1">
                                Active
                            </option>
                            <option {{ $client && $client->status == 2 ? 'selected="selected"' : "" }} value="2">
                                Completed
                            </option>
                            <option {{ $client && $client->status == 3 ? 'selected="selected"' : "" }} value="3">
                                Cancelled
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="example-date-input" class="col-form-label">Closing date</label>
                        <input class="form-control" name="closing_date"
                               value="{{ $client ? $client->closing_date : "" }}"
                               type="date" id="example-date-input">
                    </div>
                    <div class="form-group">
                        <label for="term" class="col-form-label">Term</label>
                        <input class="form-control" min="0" type="number" name="term"
                               value='{{ $client ? $client->term : "" }}' id="term" placeholder="Term">
                    </div>
                    <div class="form-group">
                        <label for="select-agent" class="select-agent">Referral</label>
                        <select class="custom-select form-control" name="agent_id" id="select-agent">
                            <option selected="selected" disabled="disabled">Select agent</option>
                            <option value="-1">Create New</option>
                            @foreach ($agents as $agent)
                                @if ($agent->type != 1) @continue @endif
                                <option
                                    {{ $client && $client->agent_id == $agent->id ? 'selected="selected"' : "" }} value="{{$agent->id}}">{{$agent->name}}
                                    ({{$agent->phone}})
                                </option>
                            @endforeach
                        </select>

                    </div>
                    <div id="agent_container" class="main-form-content">
                        <div class="form-group">
                            <label for="example-agent-name-input" class="col-form-label">Name</label>
                            <input class="form-control" name="agent_name" type="text" id="example-agent-name-input"
                                   placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label for="example-agent-email-input" class="col-form-label">Email</label>
                            <input class="form-control" type="email" name="agent_email" id="example-agent-email-input"
                                   placeholder="name@example.com">
                        </div>
                        <div class="form-group">
                            <label for="example-agent-tel-input" class="col-form-label">Phone</label>
                            <input class="form-control" type="tel" name="agent_phone" id="example-agent-tel-input"
                                   placeholder="123-456-789">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="amount" class="col-form-label">Amount</label>
                        <input class="form-control" min="0" name="amount" value='{{ $client ? $client->amount : "" }}'
                               id="amount" placeholder="Amount">
                    </div>
                    <div class="form-group">
                        <label for="creditTime" class="col-form-label">Term  (Months in integer)</label>
                        <input class="form-control" min="0" type="number" name="credit_time"
                               value='{{ $client ? $client->credit_time : "" }}' id="creditTime" placeholder="Term">
                    </div>
                    <div class="form-group">
                        <label for="amortization">Amortization (Months in integer)</label>
                        <input type="number" name="" id="amortization" class="form-control" min="1">
                    </div>
                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="interestOnly" value="">
                            <label class="form-check-label" for="interestOnly">Interest Only</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="rate" class="col-form-label">Rate</label>
                        <input class="form-control" min="0" value="{{ $client ? $client->rate : "" }}" type="number"
                               name="rate" id="rate" placeholder="Rate">
                    </div>
                    <div class="form-group">
                        <label for="repaymentType" class="col-form-label">Repayment Type</label>
                        <select id="repaymentType" class="form-control">
                            <option value="1">Interest Only</option>
                            <option value="2">Amortization</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary btn-sm" onclick="openCalculatorModal()">
                            Calculate
                        </button>
                    </div>
                </fieldset>
            </div>

            <div class="col-4 {{ $client && $client->custom_fee == 1 ? '' : 'd-none' }} popup-secondary">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Fees/Cost of Credit</legend>
                    <div class="row">
                        <!-- Mortgage -->
                        <div class="form-group col">
                            <label for="mortgage_fee" class="col-form-label">iMortgage</label>
                            <input class="form-control" type="number" name="mortgage_fee"
                                   value="{{ $fees['mortgage']['fee'] }}" id="mortgage_fee" placeholder="mortgage fee">
                        </div>
                    </div>
                    <div class="row">
                        <!-- Broker -->
                        <div class="form-group col">
                            <label for="broker_fee" class="col-form-label">Broker</label>
                            <input class="form-control" type="number" name="broker_fee"
                                   value="{{ $fees['broker']['fee'] }}"
                                   id="broker_fee" placeholder="broker fee">
                        </div>
                    </div>
                    <div class="row">
                        <!-- Lender -->
                        <div class="form-group col">
                            <label for="lender_fee" class="col-form-label">Lender</label>
                            <input class="form-control" type="number" name="lender_fee"
                                   value="{{ $fees['lender']['fee'] }}"
                                   id="lender_fee" placeholder="lender fee">
                        </div>
                    </div>
                    <!------ ------>
                    <div class="row">
                        <!-- Admin -->
                        <div class="form-group col">
                            <label for="admin_fee" class="col-form-label">Admin</label>
                            <input class="form-control" type="number" name="admin_fee"
                                   value="{{ $fees['admin']['fee'] }}"
                                   id="admin_fee" placeholder="admin fee">
                        </div>
                    </div>
                    <div class="row">
                        <!-- Lawyer -->
                        <div class="form-group col">
                            <label for="lawyer_fee" class="col-form-label">Lawyer</label>
                            <input class="form-control" type="number" name="lawyer_fee"
                                   value="{{ $fees['lawyer']['fee'] }}"
                                   id="lawyer_fee" placeholder="lawyer fee">
                        </div>
                    </div>
                    <div class="row">
                        <!-- Appraisal -->
                        <div class="form-group col">
                            <label for="appraisal_fee" class="col-form-label">Appraisal</label>
                            <input class="form-control" type="number" name="appraisal_fee"
                                   value="{{ $fees['appraisal']['fee'] }}" id="appraisal_fee"
                                   placeholder="appraisal fee">
                        </div>
                    </div>
                    <!------ ------>
                </fieldset>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
    <button type="button" id='saveClientBtn' onclick="saveClient();"
            class="btn btn-success btn-sm">{{ $client ? "Save" : "Add" }}
    </button>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $(".js-co_signor").select2({
            tags: true,
            tokenSeparators: [',', ' ']
        })
    });
</script>

