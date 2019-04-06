<!DOCTYPE html>
<html>
<head>
<title>Printing result...</title>
<style type="text/css">
    table{
        border: 1px solid #eee;
        border-collapse: collapse;
        float: left;
        margin: 0;
        width: 80%;
    }
    td, th {
        text-align: left;
        padding: 6px 10px;
    }
    tr {
        border: 1px solid #eee;
    }
    h5 {
        margin: 2px auto;       
    }

</style>
</head>
<body>                    

    <h3>Payment History</h3>    
    <h4><strong> Name: {{ $profile->full_name }} </strong></h4>       
    <h5><span style="float: left;">Principal Loan: P{{ number_format($profile->loan,2) }} </span> &nbsp; </h5>
    <h5><span style="float: left;">Interest: {{ $profile->interest }} %</span> &nbsp; </h5>
    <h5><span style="float: left;">Balance: P{{ number_format($originalBalance - $totalPayment,2) }}</span> &nbsp; </h5>
    <h5><span style="float: left;">Rate/day: P{{ number_format($ratePerDay,2) }}</span> &nbsp; </h5>
    <br>

    <table>
        <tr>                                
            <th>Payment</th>                            
            <th>Date paid</th>                       
        </tr>
        @foreach($payments as $key => $payment)
        <tr>
            <td>{{ number_format($payment->pay, 2) }}</td>
            <td>{{ date('d-m-Y', strtotime($payment->date_pay)) }}</td>
        </tr>
        @endforeach

        <tr>
        <td>Total payments: </td>
        <td> {{ $totalPayment }}</td>
        </tr>
        
    </table>

    <h5></h5>
    

</body>
</html>