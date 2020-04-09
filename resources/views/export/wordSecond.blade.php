<table style="border-collapse:collapse; border:none; width: 100%">
    <tbody>
    <tr>
        <td style="vertical-align:bottom; width:1000.0pt; font-size:12pt; font-family:Calibri,sans-serif">
            <p style="margin-top: 12in"><strong>FIXED CREDIT DISCLOSURE STATEMENT</strong></p>
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
<p style="font-size: 9pt; font-weight: bold; text-decoration: underline; margin-top: 4in; margin-bottom: 3in">Cost of Credit Details:</p>

<table style="border-collapse:collapse; border:none; width: 100%; font-size: 9pt">
    <tbody>
    <tr  >
        <td style="width: 80%;">
            <p style="color: black"> The Principal Amount of Mortgage is:</p>
            <p style="color: black;"> Deduct:</p>
        </td>
        <td style="width: 20%;">
            <p style="font-weight: bold">$ {{ number_format((int)$client->amount) }}</p>
        </td>
    </tr>

    <tr>
        <td><p>        (i)	Administration Fee:</p></td>
        <td><p>$ {{ number_format($settings['admin']) }}</p></td>
    </tr>
    <tr>
        <td><p>        (ii)	Lender Fee:</p></td>
        <td><p>$ {{ number_format($settings['lender']) }}</p></td>
    </tr>
    <tr>
        <td><p>        (iii)	Broker Fee:</p></td>
        <td><p>$ {{ number_format($settings['broker']) }}</p></td>
    </tr>
    <tr>
        <td><p>        (iv)	iMortgage Canada Fee:</p></td>
        <td><p>$ {{ number_format($settings['mortgage']) }}</p></td>
    </tr>
    <tr>
        <td>
            <p>        (v)	Estimated Legal Fee and Disbursements</p>
            <p>        (Title Insurance, Insurance Binder, Discharges etc)</p>
        </td>
        <td><p>$ {{ isset($settings['estimated'])?number_format($settings['estimated']):'' }}</p></td>
    </tr>

    </tbody>
</table>

<table style="border-collapse:collapse; border:none; width: 100%; font-size: 9pt">
    <tbody>
    <tr>
        <td><p>Total Net Advanced to Borrower:</p></td>
        <td><p style="font-weight: bold">$ {{ number_format(((int)$client->amount) - ($settings['totalSum'] - $settings['appraisal'])) }}</p></td>
    </tr>
    <tr>
        <td>
            <p>Estimated Other Deductions (mortgage payouts, loan payouts etc):</p>
        </td>
        <td><p>$ -100,000</p></td>
    </tr>
    <tr>
        <td>
            <p>Payments Already made (or to be made) directly by {{ $client->name }}:</p>

        </td>
    </tr>
    <tr>
        <td><p>         (a) Appraisal/Inspection Fee (approximate):</p></td>
        <td><p style="vertical-align: bottom">+ $ {{ $settings['appraisal'] }}</p></td>
    </tr>
    <tr>
        <td><p>         (b) Total monthly payments to be made in connection with the mortgage:</p></td>
        <td><p>+ $ {{ number_format($totalMonthly) }}</p></td>
    </tr>
    <tr>
        <td><p>         (c) Balance to be paid at maturity date (unless renewed):</p></td>
{{--        <td><p>+ $ {{ number_format((int)$client->amount) }}</p></td>--}}
        <td><p>+ $ {{ number_format($balanceMaturityDate) }}</p></td>
    </tr>
    <tr>
        <td><p>         (d) Total payments: (a) + (b) + (c)</p></td>
        <td><p>$ {{ number_format($totalPayment) }}</p></td>
    </tr>
    <tr>
        <td>
            <p><span style="font-weight: bold;">         (e) Total Cost of Credit </span>   (d) – Total Net Advance to Borrower</p>
        </td>
        <td><p>$ {{ number_format($tcc) }}</p></td>
    </tr>
    <tr>
        <td>
            <p style="margin-left: 2in">
                <span
                    style="color: black">The Annual Percentage rate (percentage of average balance for the term) is: </span>

            </p>
        </td>
        <td><p style="color: black; text-decoration: underline">{{ number_format($apr,2) }} %</p></td>
    </tr>
    </tbody>
</table>

<p style="margin-top: 5in; margin-bottom: 5in">
    <span style="font-size: 12px; color: black">By signing below, you confirm your acceptance of the above mortgage and its terms and receipt of the Fixed Credit Disclosure Statement. You confirm that this mortgage assists you and that you have the financial means to make the monthly payments. </span>
</p>

<table cellspacing="0" class="MsoTableGrid" style="border-collapse:collapse; border:none; width: 100%; margin-top: 1in">
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

<p style="margin-top: 2.5in; margin-bottom: 2.5in"><span style="font-size:11pt"><span style="font-family:Calibri,sans-serif">AGREED TO AND ACCEPTED this __&shy;&shy;&shy;&shy;____day of____________,20___ at&nbsp; ___:___am/pm</span></span></p>

<table cellspacing="0" style="border-collapse:collapse; border:none">
    <tbody>
    <tr>
        <td style="vertical-align:bottom; width:100%">
            <span style="font-size:14px; font-family:Calibri,sans-serif">Borrower's Insurance Agent:</span>
        </td>
        <td style="vertical-align:top; width:60%">_________________________________________________________________</td>
    </tr>
    <tr>
        <td style="vertical-align:bottom;">
            <span style="font-size:14px"><span style="font-family:Calibri,sans-serif">Telephone:</span></span>
        </td>
        <td style="vertical-align:top; width:60%">_________________________________________________________________</td>
    </tr>
    </tbody>
</table>
<p style="margin-top: 2.5in; margin-bottom: 2.5in"></p>
<table cellspacing="0" style="border-collapse:collapse; border:none">
    <tbody>
    <tr>
        <td style="vertical-align:bottom; width:100%; margin-right: 5in">
            <p style="font-size:14px; font-family:Calibri,sans-serif;  margin-right: 5in">Borrowers Lawyer:</p>
        </td>
        <td style="vertical-align:top; width:60%">              _________________________________________________________________</td>
    </tr>
    <tr>
        <td style="vertical-align:bottom; width:100%">
            <p style="font-size:14px"><span style="font-family:Calibri,sans-serif">Telephone/Fax:</span></p>
        </td>
        <td style="vertical-align:top; width:60%">              _________________________________________________________________</td>
    </tr>
    <tr>
        <td style="vertical-align:bottom; width:100%">
            <p style="font-size:14px"><span style="font-family:Calibri,sans-serif">Email:</span></p>
        </td>
        <td style="vertical-align:top; width:60%">              _________________________________________________________________</td>
    </tr>
    <tr>
        <td style="vertical-align:bottom; width:100%">
            <p style="font-size:14px"><span style="font-family:Calibri,sans-serif">Address:</span></p>
        </td>
        <td style="vertical-align:top; width:60%">              _________________________________________________________________</td>
    </tr>
    </tbody>
</table>
<p style="margin-top: 2.5in; margin-bottom: 2.5in"></p>
<table cellspacing="0" style="border-collapse:collapse; border:none; width: 100%; text-align: justify">
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
        <td style="border-bottom:1px solid black; border-left:none; border-right:none; border-top:1px solid black; vertical-align:top;">_________________________________________________________________</td>
    </tr>
    <tr>
        <td style="vertical-align:top;">
            <span style="font-size:14px"><span style="font-family:Calibri,sans-serif">Phone # and Address:</span></span>
        </td>
        <td style="border-bottom:1px solid black; border-left:none; border-right:none; border-top:1px solid black; vertical-align:top;">_________________________________________________________________</td>
    </tr>
    </tbody>
</table>
<p style="margin-top: 2.5in; margin-bottom: 3in"></p>

<table cellspacing="0" style="border-collapse:collapse; border:none; width: 100%; text-align: justify">
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

