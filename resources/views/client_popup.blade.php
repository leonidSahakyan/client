<div class="modal-header">
    <h5 class="modal-title">{{ $client ? "Edit" : "Add" }} client</h5>
    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
</div>
<div class="modal-body">
    <form class="save-client" action="JavaScript:void(0);" autocomplete="off">
        <label class='error_container'></label>
        {{--       <div class="s-sw-title custom-fee-swicher">
                   <h5>Custom fee</h5>
                   <div class="s-swtich">
                       <input type="checkbox" name="custom_fee_switcher"
                              {{ $client && $client->custom_fee == 1 ? 'checked="checked"' : "" }} id="custom_fee_switcher">
                       <label for="custom_fee_switcher">Toggle</label>
                   </div>
               </div>--}}
        <input type="hidden" name="client_id" value='{{ $client ? $client->id : 0 }}'/>
        <div class="row">
            <div class="col-4 popup-main">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Personal information</legend>
                    <div class="form-group">
                        <label for="example-name-input" class="col-form-label">Full name</label>
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
                        <input type="text" id="mailing_address" class="form-control" name="mailing_address"
                               value="{{ $client? $client->mailing_address:"" }}">
                    </div>
                    <div class=" form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="sameMailingAddress"
                                   onchange=" setMailingAddress(this)">
                            <label class="form-check-label" for="sameMailingAddress">Same a Mailing Address</label>
                        </div>
                    </div>
                    @for($i=0; $i <=2; $i++)
                        <div class="form-group">
                            <label for="property_security_{{$i+1}}" class="col-form-label">Property Security {{$i+1}}</label>
                            <input type="text" class="form-control" id="property_security_{{$i+1}}"
                                   name="property_security[]"
                                   @if($client && isset(unserialize($client->property_security)[$i]))
                                   value="{{ isset(unserialize($client->property_security)[$i]['property_security'])?unserialize($client->property_security)[$i]['property_security']:'' }}"
                                    @endif
                            />
                        </div>
                        <div class="form-group">
                            <label for="legal_pid_{{$i+1}}">Legal PID {{$i+1}}</label>
                            <input type="text" class="form-control" id="legal_pid_{{$i+1}}" name="legal_pid[]"
                                   @if($client && isset(unserialize($client->property_security)[$i]))
                                   value="{{ isset(unserialize($client->property_security)[$i]['legal_pid'])?unserialize($client->property_security)[$i]['legal_pid']:'' }}"
                                @endif
                            >
                        </div>
                    @endfor
                    <div class="form-group">
                        <label for="dob" class="col-form-label">DOB</label>
                        <input class="form-control" name="dob" value="{{ $client ? $client->dob : "" }}" type="date"
                               id="dob">
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
                </fieldset>
            </div>

            <div class="col-4 popup-main">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Description</legend>
                    <div id="lender_container" class="d-block">
                        <div class="form-group">
                            <label class="col-form-label" for="select-lender">Lender</label>
                            <select class="custom-select form-control" name="lender_id" id="select-lender">
                                <option selected="selected" disabled="disabled">Select lender</option>
                                <option value="-1">Create New</option>
                                @foreach ($agents as $agent)
                                    @if ($agent->type == 2)
                                        <option
                                            {{ $client && $client->lender_id == $agent->id ? 'selected="selected"' : "" }} value="{{$agent->id}}">{{$agent->name}}
                                            ({{$agent->phone}})
                                        </option>
                                    @endif
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
                    <div class="form-group">
                        <label for="select-agent" class="select-agent">Referral</label>
                        <select class="custom-select form-control" name="agent_id" id="select-agent">
                            <option selected="selected" disabled="disabled">Select agent</option>
                            <option value="-1">Create New</option>
                            @foreach ($agents as $agent)
                                @if ($agent->type == 1)
                                    <option
                                        {{ $client && $client->agent_id == $agent->id ? 'selected="selected"' : "" }} value="{{$agent->id}}">{{$agent->name}}
                                        ({{$agent->phone}})
                                    </option>
                                @endif
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
                    <div id="lawyer_container" class="d-block">
                        <div class="form-group">
                            <label for="select-lawyer" class="col-form-label">Lawyer</label>
                            <select class="custom-select form-control" name="lawyer_id" id="select-lawyer">
                                <option selected="selected" disabled="disabled">Select lawyer</option>
                                <option value="-1">Create New</option>
                                @foreach ($agents as $agent)
                                    @if ($agent->type == 3)
                                        <option
                                            {{ $client && $client->lawyer_id == $agent->id ? 'selected="selected"' : "" }} value="{{$agent->id}}">{{$agent->name}}
                                            ({{$agent->phone}})
                                        </option>
                                    @endif
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
                        <label for="iad" class="col-form-label">IAD</label>
                        <input type="date" name="iad" id="iad" class="form-control"
                               value="{{ $client ? $client->iad : "" }}">
                    </div>
                    <div class="form-group">
                        <label for="start_date" class="col-form-label">Start date</label>

                        <input type="date" class="form-control" min="0" name="start_date"
                               value='{{ $client ? $client->start_date : "" }}'
                               id="start_date" placeholder="Start Date">
                    </div>
                    <div class="form-group">
                        <label for="amount" class="col-form-label">Loan Amount</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">$</div>
                            </div>
                            <input class="form-control" min="0" name="amount"
                                   oninput="this.value = formatNumber(this.value)"
                                   value='{{ $client ? number_format((int)$client->amount,0, ' ', ' ') : "" }}'
                                   id="amount" placeholder="Amount">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="term" class="col-form-label">Term</label>
                        <input class="form-control" min="0" type="number" name="term"
                               value='{{ $client ? $client->term : "" }}' id="term" placeholder="Term">
                    </div>
                    <div class="form-group">
                        <label for="amortization_period" class="col-form-label">Amortization period</label>
                        <div class="input-group">
                            <input type="number"
                                   id="amortization_period"
                                   class="form-control"
                                   min="0"
                                   name="amortization_period"
                                   value="{{ $client ? $client->amortization_period :'' }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="payment_method" class="col-form-label">Payment method</label>
                            <input type="number"
                                   class="form-control"
                                   id="payment_method"
                                   name="payment_method"
                                   min="0"
                                   value="{{ $client? $client->payment_method:'12' }}"
                            >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="rate" class="col-form-label">Interest Rate</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">%</div>
                            </div>
                            <input type="number"
                                   step="0.01"
                                   min="0"
                                   name="rate"
                                   id="rate"
                                   class="form-control"
                                   value="{{ $client ? $client->rate : "" }}"
                                   placeholder="Rate"
                            >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="interestOnly"
                                   name="payment_type" {{ ($client && $client->payment_type==1)?'checked':''  }}>
                            <label class="form-check-label" for="interestOnly">Interest Only</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary btn-sm" onclick="openCalculatorModal()">
                            Calculate
                        </button>
                    </div>
                </fieldset>
            </div>

            <div class="col-4  popup-secondary">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Fees/Cost of Credit</legend>
                    <div class="row">
                        <!-- Mortgage -->
                        <div class="form-group col">
                            <label for="mortgage_fee" class="col-form-label">iMortgage</label>
                            <input class="form-control" type="number" name="mortgage_fee" min="0"
                                   value="{{ $fees ? $fees['mortgage']['fee']: '' }}" id="mortgage_fee"
                                   placeholder="mortgage fee">
                        </div>
                    </div>
                    <div class="row">
                        <!-- Broker -->
                        <div class="form-group col">
                            <label for="broker_fee" class="col-form-label">Broker</label>
                            <input class="form-control" type="number" name="broker_fee" min="0"
                                   value="{{ $fees ? $fees['broker']['fee'] : '' }}"
                                   id="broker_fee" placeholder="broker fee">
                        </div>
                    </div>
                    <div class="row">
                        <!-- Lender -->
                        <div class="form-group col">
                            <label for="lender_fee" class="col-form-label">Lender</label>
                            <input class="form-control" type="number" name="lender_fee"
                                   value="{{ $fees ? $fees['lender']['fee']: '' }}" min="0"
                                   id="lender_fee" placeholder="lender fee">
                        </div>
                    </div>
                    <!------ ------>
                    <div class="row">
                        <!-- Admin -->
                        <div class="form-group col">
                            <label for="admin_fee" class="col-form-label">Admin</label>
                            <input class="form-control" type="number" name="admin_fee"
                                   value="{{ $fees ? $fees['admin']['fee'] : '' }}" min="0"
                                   id="admin_fee" placeholder="admin fee">
                        </div>
                    </div>
{{--                    <div class="row">--}}
{{--                        <!-- Lawyer -->--}}
{{--                        <div class="form-group col">--}}
{{--                            <label for="lawyer_fee" class="col-form-label">Lawyer</label>--}}
{{--                            <input class="form-control" type="number" name="lawyer_fee"--}}
{{--                                   value="{{ $fees ? $fees['lawyer']['fee'] : '' }}" min="0"--}}
{{--                                   id="lawyer_fee" placeholder="lawyer fee">--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="row">
                        <!-- Lawyer -->
                        <div class="form-group col">
                            <label for="estimated_fee" class="col-form-label">Estimated Legal Fee</label>
                            <input class="form-control" type="number" name="estimated_fee"
                                   value="{{ $fees && isset($fees['estimated'])? $fees['estimated']['fee'] : '' }}" min="0"
                                   id="estimated_fee" placeholder="Estimated Legal Fee">
                        </div>
                    </div>
                    <div class="row">
                        <!-- Appraisal -->
                        <div class="form-group col">
                            <label for="appraisal_fee" class="col-form-label">Appraisal</label>
                            <input class="form-control" type="number" name="appraisal_fee" min="0"
                                   value="{{ $fees ? $fees['appraisal']['fee'] : '' }}" id="appraisal_fee"
                                   placeholder="appraisal fee">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="payment_method" class="col-form-label">Payment method</label>
                            <input class="form-control" type="number" name="payment_method" min="0"
                                   value="{{ $client? $client->payment_method:'12' }}" id="payment_method">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="eod" class="col-form-label">Estimated Other Deductions</label>
                            <input
                                type="number"
                                name="eod"
                                id="eod"
                                class="form-control"
                                value="{{ $client? $client->eod:'12' }}"
                            >
                        </div>
                    </div>

                    <!------ ------>
                </fieldset>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    {{--    <a href="{{ route('export_word') }}" class="btn btn-info btn-sm">Export Word</a>--}}
    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
    @if($client)
        <a href="{{ route('show-client',['id'=>$client->id]) }}" class="btn btn-info btn-sm">Show</a>
    @endif
    <button type="button" id='saveClientBtn' onclick="saveClient();"
            class="btn btn-success btn-sm">{{ $client ? "Save" : "Add" }}
    </button>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $(".js-co_signor").select2({
            tags: true,
        });
    });
</script>

