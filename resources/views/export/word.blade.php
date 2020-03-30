<p><strong>{{ date('F j, Y') }}</strong></p>
<table style="border-collapse:collapse; border:none; width: 100%">
    <tbody>
    <tr>
        <td style="vertical-align:top; width:1000.0pt; font-size:11pt; font-family:Calibri,sans-serif">
            <strong>  {{ $client->name }}</strong> <br/>
            <strong>  {{ $client->address }}</strong> <br/>
           @foreach(unserialize($client->property_security) as $val)<strong> {{ $val?$val:'' }}</strong> <br/>@endforeach
        </td>
        <td style="width:400.0pt">
            <p style="text-align: right"><strong><span style="font-size:22.0pt"><span
                            style="color:#538135">iMortgage </span></span></strong><strong><span
                        style="font-size:22.0pt">Canada</span></strong></p>
            <p style="text-align: right"><strong><span
                        style="font-size:16.0pt">   Private Lending Made Easy</span></strong></p>
        </td>
    </tr>
    </tbody>
</table>
<p>
    <span style="font-size:11pt; font-family:Calibri,sans-serif">
        <strong>Congratulations you are <span style="color:red">APPROVED!</span></strong>
    </span>
</p>
<p>
    <span style="font-size:11pt; font-family:Calibri,sans-serif">We are please to arrange a Second mortgage for
        $ <strong>{{ number_format((int)$client->amount) }}</strong> per terms and conditions below:
    </span>
</p>
<table border="0" style="width: 100%; margin: 0in 0in 0in 0in" cellspacing="0" cellpadding="0">
    <tr>
        <td colspan="1">Borrower(s): A {{ $client->name }}</td>
        <td colspan="4">
            @if($client->co_signor)
                @foreach(json_decode($client->co_signor) as $item)
                    <strong> {{ $item }} </strong>
                @endforeach
            @endif
        </td>
    </tr>
    <tr>
        <td>
            <strong>Property Security:</strong>
        </td>
        <td>
            @foreach(unserialize($client->property_security) as $key => $val)
                @if($val)
                    <strong>{!! ($key>0)?"<br/>":"" , $val!!} </strong>
                @endif
            @endforeach
        </td>
        <td>
            <strong>Legal PID:</strong>
        </td>
        <td>
            <strong>{{ $client->legal_pid }}</strong>
        </td>
    </tr>
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
            <strong>Amortization</strong>
{{--            <strong>{{ ($client->payment_type === 2)?'Amortization':'Interest only' }}</strong>--}}
        </td>
    </tr>
    <tr>
        <td>
            <strong>Monthly Payment:</strong>
        </td>
        <td>
            <span>$ <strong>{{ $monthlyPayment }}</strong></span>
        </td>
        <td><strong>Estimated Funding Date:</strong></td>
        <td><strong>{{ date('F j, Y', strtotime($client->closing_date)) }} </strong></td>
    </tr>
    <tr>
        <td><strong>Mortgage Term:</strong></td>
        <td><strong>{{ ($client->payment_type===1)?$client->term:$client->amortization_period }}</strong> months</td>
        <td><strong>Lender Fee:</strong></td>
        <td>$ <strong>{{ number_format((int)$settings['lender']['fee']) }}</strong></td>
    </tr>
    <tr>
        <td><strong>Administration Fee:</strong></td>
        <td>$ <strong>{{ number_format((int)$settings['admin']['fee']) }}</strong></td>
        <td><strong>iMortgage Canada Fee:</strong></td>
        <td>$ <strong>{{ number_format((int)$settings['mortgage']['fee']) }}</strong></td>
    </tr>
    <tr>
        <td><strong>Broker Fee:</strong></td>
        <td>$ <strong>{{ number_format((int)$settings['broker']['fee']) }}</strong></td>
    </tr>
</table>
<p><span style="font-size:12pt"><span style="font-family:Calibri,sans-serif">Conditions:</span></span></p>

<ol>
    <li><span style="font-size:11pt; font-family:Calibri,sans-serif;">Subject to satisfactory appraisal of the subject property.</span>
    </li>
    <li><span
            style="font-size:10pt; font-family:Calibri,sans-serif;"><strong>Prepayment Penalty: </strong>3-month interest penalty, fully open after 6 months </span>
    </li>
    <li><span style="font-size:11pt; font-family:Calibri,sans-serif;">Subject to satisfactory report of title, prior charges not to exceed $758,000 and in good standing Home Trust</span>
    </li>
    <li><span style="font-size:11pt; font-family:Calibri,sans-serif;">All legal and insurance binder fees, title insurance costs and disbursements are the sole responsibility of the borrower(s), plus mortgage discharge fee of $75. Assignment of rents to be registered on title.</span>
    </li>
    <li><span style="font-size:11pt; font-family:Calibri,sans-serif;">Late payments, including NSF or other returned cheques will result in a $150.00 administration charge. </span>
    </li>
    <li><span style="font-size:11pt; font-family:Calibri,sans-serif;">Suitable insurance protection against fire and other perils must be maintained with the lender shown as 2<sup>nd</sup> loss payable. Property taxes paid up to date. </span>
    </li>
    <li><span style="font-size:11pt; font-family:Calibri,sans-serif;">Legal retainer of $500 payable to designated iMortgage Canada Solicitor in trust upon acceptance of this offer. </span>
    </li>
    <li><span style="font-size:11pt; font-family:Calibri,sans-serif;">Renewal may be considered upon request and only if loan remains in good standing for a Fee of $500.&nbsp; </span>
    </li>
    <li><span style="font-size:11pt; font-family:Calibri,sans-serif;">The lender reserves the right to withdraw this approval, or to modify the terms as required, if any material facts appear which have previously not been disclosed.</span>
    </li>
    <li><span style="font-size:11pt; font-family:Calibri,sans-serif;">This offer is open for acceptance until 5 p.m. Monday Dec 2, 2019</span>
    </li>
</ol><p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif">Sincerely,</span></span></p><p><span
        style="font-size:11pt"><span style="font-family:Calibri,sans-serif">iMortgage Canada</span></span></p><p><span
        style="font-size:11pt"><span style="font-family:Calibri,sans-serif">Per: Peter Pasula</span></span></p><p><span
        style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong><span style="font-size:10.0pt">Further Terms and Consent</span></strong></span></span>
</p><p><span style="font-size:10.0pt"><span>I hereby formally authorize the Lender, iMortgage Canada, their agents and lawyers to make enquiries as to status of mortgages, property taxes, fire insurance, credit bureaus and if applicable, liens, judgements, strata and Canada Revenue Agency Information, in relation to the property indicated above and I/we authorize and direct such parties to provide the same by fax or email if so requested. This authorization is for the purpose of arranging and administering the mortgage and is effective for the duration of the mortgage. We/I acknowledge that the name of the lender may change or may not yet be determined and we/I hereby authorize and direct the Lenders lawyer or iMortgage Canada to insert or amend the name and address of a lender as designated by iMortgage Canada, in all mortgage documents and ancillary documents and on any preauthorized payment or post-dated cheques, and confirm all documents shall be read and construed as with the name of the lender, and may be relied upon by the lender.</span></span>
</p>

<table style="border-collapse:collapse; border:none; width: 100%">
    <tbody>
    <tr>
        <td style="vertical-align:bottom; width:1000.0pt; font-size:12pt; font-family:Calibri,sans-serif">
            <br/>
            <br/>
            <br/>
            <strong>FIXED CREDIT DISCLOSURE STATEMENT</strong>
        </td>
        <td style="width:400.0pt; vertical-align:bottom">
            <p style="text-align: right;"><strong><span style="font-size:22.0pt"><span
                            style="color:#538135">iMortgage </span></span></strong><strong><span
                        style="font-size:22.0pt">Canada</span></strong></p>
            <p style="text-align: right"><strong><span
                        style="font-size:16.0pt">   Private Lending Made Easy</span></strong></p>
        </td>
    </tr>
    </tbody>
</table>
<p style="font-size: 14px; font-weight: bold; text-decoration: underline">Cost of Credit Details:</p>

<table style="border-collapse:collapse; border:none; width: 100%; font-size: 12px">
    <tbody>
    <tr>
        <td style="width: 80%;">
            <span style="color: black">The Principal Amount of Mortgage is:</span> <br/>
            <span style="color: black">Deduct:</span>
        </td>
        <td style="width: 20%;">
            <strong>$ {{ number_format((int)$client->amount) }}</strong>
        </td>
    </tr>
    <tr>
        <td style="width: 80%;">
          <span style="color: black;">       (i)	Administration Fee:                 </span> <br/>
          <span style="color: black;">       (ii)	Lender Fee:</span> <br/>
          <span style="color: black;">       (iii)	Broker Fee</span> <br/>
          <span style="color: black;">       (iv)	iMortgage Canada Fee:</span> <br/>
          <span style="color: black">              (Title Insurance, Insurance Binder, Discharges etc)</span> <br/>
<span style="color: black">Total Net Advanced to {{ $client->name }}:</span> <br/>
        </td>
        <td style="width: 20%;">
            <span style="color: black;">$ {{ number_format((int)$settings['admin']['fee']) }}</span>   <br/>
            <span style="color: black;">$ {{ number_format((int)$settings['lender']['fee']) }}</span> <br/>
            <span style="color: black;">$ {{ number_format((int)$settings['broker']['fee']) }}</span> <br/>
            <span style="color: black;">$ {{ number_format((int)$settings['mortgage']['fee']) }}</span> <br/><br/>
            <span style="color: black; text-decoration: underline; font-weight: bold">$ {{ number_format(((int)$client->amount) - ( (int)$settings['admin']['fee'] + (int)$settings['lender']['fee'] + (int)$settings['broker']['fee'] + (int)$settings['mortgage']['fee'])
) }}</span> <br/>
        </td>
    </tr>
    <tr>
        <td style="width: 80%;">
            <span style="color: black">Payments Already made (or to be made) directly by {{ $client->name }}:</span> <br/>
            <span style="color: black;">        (a)	Appraisal/Inspection Fee (approximate): </span> <br/>
            <span style="color: black;">        (b)	Total monthly payments to be made in connection with the mortgage: </span> <br/>
            <span style="color: black;">        (c)	Balance to be paid at maturity date (unless renewed): </span> <br/>
            <span style="color: black;">        (d)	Total payments:         (a) + (b) + (c) </span> <br/>
            <span style="color: black;"> <span style="font-weight: bold;">        (e) Total Cost of Credit </span>   (d) – Total Net Advance to Borrower </span><br/>
            <span style="color: black">The Annual Percentage rate (percentage of average balance for the term) is: </span>
        </td>
        <td style="width: 20%;">
            <span> </span><br/>
            <span style="color: black;">+ $ {{ $settings['appraisal']['fee'] }}</span>   <br/>
            <span style="color: black;">+ $ {{ number_format($totalMonthly) }}</span> <br/>
            <span style="color: black;">+ $ {{ number_format((int)$client->amount) }}</span> <br/>
            <span style="color: black;">= $ {{ number_format($totalMonthly+(int)$client->amount +(int)$settings['appraisal']['fee']) }}</span> <br/>
            <span style="color: black;">$ {{ number_format((($totalMonthly+(int)$client->amount +(int)$settings['appraisal']['fee'])-((int)$client->amount) - ( (int)$settings['admin']['fee'] + (int)$settings['lender']['fee'] + (int)$settings['broker']['fee'] + (int)$settings['mortgage']['fee']))) }}</span>  <br/>
            <span style="color: black; text-decoration: underline">16.46 %</span>
        </td>
    </tr>
    </tbody>
</table>
<p>
    <span style="font-size: 12px; color: black">By signing below, you confirm your acceptance of the above mortgage and its terms and receipt of the Fixed Credit Disclosure Statement. You confirm that this mortgage assists you and that you have the financial means to make the monthly payments. </span>
</p>

<table cellspacing="0" class="MsoTableGrid" style="border-collapse:collapse; border:none; width: 100%">
    <tbody style="width: 100%;">
    <tr>
        <td style="border-bottom:1px solid black; border-left:none; border-right:none; border-top:none; vertical-align:top; width:170px">
            <p>___________</p>
        </td>
        @if($client->co_signor)
            @foreach(json_decode($client->co_signor) as $item)
                <td style="border-bottom:1px solid black; border-left:none; border-right:none; border-top:none; vertical-align:top; width:161px">
                    <p>___________</p>
                </td>
            @endforeach
        @endif
    </tr>
    <tr>
        <td style="border-bottom:none; border-left:none; border-right:none; border-top:none; vertical-align:top; width:170px">
            <p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong>A {{ $client->name }}</strong></span></span></p>
        </td>
        @if($client->co_signor)
            @foreach(json_decode($client->co_signor) as $item)
        <td style="border-bottom:none; border-left:none; border-right:none; border-top:none; vertical-align:top; width:161px">
            <p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif"><strong>{{ $item }}</strong></span></span></p>
        </td>
            @endforeach
        @endif
    </tr>
    </tbody>
</table>


<p><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif">AGREED TO AND ACCEPTED this __&shy;&shy;&shy;&shy;____day of____________,20___ at&nbsp; ___:___am/pm</span></span></p>

<table cellspacing="0" style="border-collapse:collapse; border:none; width: 100%">
    <tbody>
    <tr style="width: 100%">
        <td style="vertical-align:bottom;">
            <span style="font-size:14px; font-family:Calibri,sans-serif">Borrower's Insurance Agent:</span>
        </td>
        <td style="vertical-align:top;">_________________________________________________________________</td>
    </tr>
    <tr>
        <td style="vertical-align:bottom;">
            <span style="font-size:14px"><span style="font-family:Calibri,sans-serif">Telephone:</span></span>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:none; border-top:1px solid black; vertical-align:top; width:60%">_________________________________________________________________</td>
    </tr>
    </tbody>
</table>

<table cellspacing="0" style="border-collapse:collapse; border:none; width: 100%">
    <tbody>
    <tr style="width: 100%">
        <td style="vertical-align:top;">
            <span style="font-size:14px; font-family:Calibri,sans-serif">Borrowers Lawyer:</span>
        </td>
        <td style="vertical-align:top;">_________________________________________________________________</td>
    </tr>
    <tr>
        <td style="vertical-align:top;">
            <span style="font-size:14px"><span style="font-family:Calibri,sans-serif">Telephone/Fax:</span></span>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:none; border-top:1px solid black; vertical-align:top; width:60%">_________________________________________________________________</td>
    </tr>
    <tr>
        <td style="vertical-align:top;">
            <span style="font-size:14px"><span style="font-family:Calibri,sans-serif">Email:</span></span>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:none; border-top:1px solid black; vertical-align:top; width:60%">_________________________________________________________________</td>
    </tr>
    <tr>
        <td style="vertical-align:top;">
            <span style="font-size:14px"><span style="font-family:Calibri,sans-serif">Address:</span></span>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:none; border-top:1px solid black; vertical-align:top; width:60%">_________________________________________________________________</td>
    </tr>
    </tbody>
</table>

<table cellspacing="0" style="border-collapse:collapse; border:none; width: 100%">
    <tbody>
    <tr style="width: 100%">
        <td style="vertical-align:top;">
            <span style="font-size:14px; font-family:Calibri,sans-serif">Current Mortgage Lender:</span>
        </td>
        <td style="vertical-align:top;">_________________________________________________________________</td>
    </tr>
    <tr>
        <td style="vertical-align:top;">
            <span style="font-size:14px"><span style="font-family:Calibri,sans-serif">Account #</span></span>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:none; border-top:1px solid black; vertical-align:top; width:60%">_________________________________________________________________</td>
    </tr>
    <tr>
        <td style="vertical-align:top;">
            <span style="font-size:14px"><span style="font-family:Calibri,sans-serif">Phone # and Address:</span></span>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:none; border-top:1px solid black; vertical-align:top; width:60%">_________________________________________________________________</td>
    </tr>
    </tbody>
</table>

<table cellspacing="0" style="border-collapse:collapse; border:none; width: 100%">
    <tbody>
    <tr style="width: 100%">
        <td style="vertical-align:top;">
            <span style="font-size:14px; font-family:Calibri,sans-serif">Current Mortgage Lender:</span>
        </td>
        <td style="vertical-align:top;">_________________________________________________________________</td>
    </tr>
    <tr>
        <td style="vertical-align:top;">
            <span style="font-size:14px"><span style="font-family:Calibri,sans-serif">Account #</span></span>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:none; border-top:1px solid black; vertical-align:top; width:60%">_________________________________________________________________</td>
    </tr>
    <tr>
        <td style="vertical-align:top;">
            <span style="font-size:14px"><span style="font-family:Calibri,sans-serif">Phone # and Address:</span></span>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:none; border-top:1px solid black; vertical-align:top; width:60%">_________________________________________________________________</td>
    </tr>
    </tbody>
</table>
<br/>
<br/>
<table align="left" border="2" cellpadding="5" style="width:100%">
    <tbody>
    <tr>
        <td>
            <p style="font-size: 12px">Powered by: <strong><span style="color:red">The Mortgage Centre/Home Financing Solutions</span></strong></p>

            <p style="font-size: 12px">4720 Kingsway Avenue Suite 2600 Burnaby, British Columbia V5H 4N2</p>
        </td>
    </tr>
    </tbody>
</table>

