<p style="margin-bottom: 2in;"><strong>{{ date('F j, Y') }}</strong></p>
<table style="border-collapse:collapse; border:none; width: 100%">
    <tbody>
    <tr>
        <td style="vertical-align:top; width:1000.0pt; font-size:11pt; font-family:Calibri,sans-serif">
            <p><strong>  {{ $client->name }}</strong></p>
            <p><strong>  {{ $client->mailing_address }}</strong></p>
        </td>
        <td style="width:400.0pt">
            <p style="text-align: right"><strong><span style="font-size:22.0pt"><span
                            style="color:#538135">iMortgage </span></span></strong><strong><span
                        style="font-size:22.0pt">Canada</span></strong></p>
            <p style="text-align: right; margin-top: 3in"><strong><span
                        style="font-size:16.0pt">   Private Lending Made Easy</span></strong></p>
        </td>
    </tr>
    </tbody>
</table>
<p style="margin-bottom: 3in; margin-top: 2in">
    <span style="font-size:11pt; font-family:Calibri,sans-serif">
        <strong>Congratulations you are <span style="color:red">APPROVED!</span></strong>
    </span>
</p>
<p style="margin-bottom: 3in;">
    <span style="font-size:11pt; font-family:Calibri,sans-serif">We are please to arrange a Second mortgage for $ <strong>{{ number_format((int)$client->amount) }}</strong> per terms and conditions below:
    </span>
</p>

<p><strong>Borrower(s): {{ $client->name }}
    @if($client->co_signor)
        @foreach(json_decode($client->co_signor) as $item)
            {{ $item }}
        @endforeach
    @endif
    </strong>
</p>
<table border="0" style="width: 100%; font-weight: bold">
    @if(count($property_security) > 0)
        @foreach($property_security as $item => $val)
            @if(isset($val['property_security']))
            <tr>
                <td>
                    <strong>Property Security {{ $item+1 }}:</strong>
                </td>
                <td>
                    <strong>{{ $val['property_security'] }}</strong>
                </td>
                <td>
                    <strong>Legal PID {{ $item+1 }}:</strong>
                </td>
                <td>
                    <strong>{{ $val['legal_pid'] }}</strong>
                </td>
            </tr>
            @endif
        @endforeach
    @endif
    <tr>
        <td>
            <strong>Interest Rate:</strong>
        </td>
        <td>
            <strong>{{ $client->rate }}</strong> % compounded monthly
        </td>
        <td>
            <strong>Amortization Period:</strong>
        </td>
        <td>
            <strong>{{ ($client->payment_type === 2)?'Amortization':'Interest only' }}</strong>
        </td>
    </tr>
    <tr rowspan="3">
        <td>
            <strong>Monthly Payment:</strong>
        </td>
        <td>
            <span>$ <strong>{{ $monthlyPayment }}</strong></span>
        </td>
        <td><strong>Pre-paid {{ $client->payment_method }} months</strong></td>
    </tr>
    <tr>
        <td><strong>Mortgage Term:</strong></td>
        <td><strong>{{ ($client->payment_type===1)?$client->term:$client->amortization_period }}</strong> months</td>
        <td><strong>Estimated Funding Date:</strong></td>
        <td><strong>{{ date('F j, Y', strtotime($client->start_date)) }} </strong></td>
    </tr>
    <tr>
        <td><strong>Administration Fee:</strong></td>
        <td>$ <strong>{{ $settings['admin'] }}</strong></td>
        <td><strong>Lender Fee:</strong></td>
        <td>$ <strong>{{ $settings['lender'] }}</strong></td>
    </tr>
    <tr>
        <td><strong>Broker Fee:</strong></td>
        <td>$ <strong>{{ $settings['broker'] }}</strong></td>
        <td><strong>iMortgage Canada Fee:</strong></td>
        <td>$ <strong>{{ $settings['mortgage'] }}</strong></td>
    </tr>
</table>
<p style="margin-top: 1in; margin-bottom: 2in"><span style="font-size:12pt"><span style="font-family:Calibri,sans-serif">Conditions:</span></span></p>

<ol style="font-size: 11pt; font-family:Calibri,sans-serif; margin-top: 0in; margin-bottom: 0in">
    <li><p>Pre-paid {{ $client->payment_method }} months, $18,900 hold back. </p></li>
    <li><p>Removal of interalia charge on title from Nov 2019 </p></li>
    <li><p><strong>Prepayment Penalty: 1.5%</strong> month interest penalty, fully closed for 6 months. </p></li>
    <li><p>Subject to satisfactory report of title, prior charges not to exceed $1,320,000 and in good standing National Bank </p></li>
    <li><p>All legal and insurance binder fees, title insurance costs and disbursements are the sole responsibility of
           the borrower(s), plus mortgage discharge fee of $75. Assignment of rents to be registered on title. </p></li>
    <li><p>Late payments, including NSF or other returned cheques will result in a $150.00 administration charge. </p></li>
    <li><p>Suitable insurance protection against fire and other perils must be maintained with the lender shown as 2nd loss payable.
           Property taxes paid up to date. </p></li>
    <li><p>Legal retainer of $500 payable to designated iMortgage Canada Solicitor in trust upon acceptance of this offer. </p></li>
    <li><p>The lender reserves the right to withdraw this approval, or to modify the terms as required, if any material facts appear
           which have previously not been disclosed. </p></li>
    <li><p>This offer is open for acceptance until 5 p.m. Monday April 6, 2020 </p></li>
</ol>
<p style="margin-top: 3in; margin-bottom: 15in"><span style="font-size:11pt; font-family:Calibri,sans-serif">Sincerely</span></p>
<p style="margin-bottom: 2in"><span style="font-size:11pt; font-family:Calibri,sans-serif">iMortgage Canada</span></p>
<p style="margin-bottom: 2in"><span style="font-size:11pt; font-family:Calibri,sans-serif">Per: Peter Pasula</span></p>
<p style="margin-bottom: 2in"><span style="font-size:9pt; text-decoration: underline; font-weight: bold">Further Terms and Consent</span></p>
<p style="font-size:9pt;">I hereby formally authorize the Lender, iMortgage Canada,
their agents and lawyers to make enquiries as to
status of mortgages, property taxes,
fire insurance, credit bureaus and
if applicable, liens, judgements,
strata and Canada Revenue Agency Information, in relation to the
property indicated above and I/we authorize and direct such parties
to provide the same by fax or email if so requested. This authorization
is for the purpose of arranging and administering the mortgage and is effective
for the duration of the mortgage. We/I acknowledge that the name of the lender may
change or may not yet be determined and we/I hereby authorize and direct the Lenders
lawyer or iMortgage Canada to insert or amend the name and address of a lender as designated
by iMortgage Canada, in all mortgage documents and ancillary documents and on any preauthorized
payment or post-dated cheques, and confirm all documents shall be read and construed as with the nam
e of the lender, and may be relied upon by the lender.</p>
