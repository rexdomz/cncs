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
        padding: 2px 4px;
        width: 100%;
    }
    td, th {
        text-align: left;
        padding: 6px 10px;
        font-size: 11px;
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

    <h3>Qouta | <i>All records</i> </h3>         
    <h5>Area Collector: {{ $collector }}</h5>           
    <h5><span style="float: left;">Daily: P{{ number_format($daily, 2) }} </span> &nbsp; </h5>
    <h5><span style="float: left;">Weekly: P{{ number_format($weekly, 2) }}</span> &nbsp; </h5>    
    <br>

    <table>
        <tr>                                
        <th>Full Name</th>  
        <th>Principal Loan</th>    
        <td>Loan Amount</td>                              
        <th>Balance</th>                                            
        <th>Term</th>                            
        <th>Rate/day</th>
        <th>Maturity</th>                                                            
        </tr>   
        @foreach($profiles as $key => $profile)
        <tr>
            <td>{{ $profile->full_name }}</td>              
            <td>{{ number_format($profile->loan, 2) }}</td>  
            
            @php 
                $totalAmount = 0;                  
                $totalAmount = $profile->loan + ($profile->loan * ($profile->interest/100) * $profile->term);                     
            @endphp
            
            <td>{{ number_format($totalAmount, 2) }}</td>
            <td>{{ number_format($totalAmount - $profile->totalpay, 2) }}</td>          
            <td>{{ $profile->term }}month(s)</td>   

            @php
                $originalBalance = 0;
                $originalBalance = $profile->loan + ($profile->loan * ($profile->interest/100) * $profile->term);

                $ratePerDay = 0;
                $ratePerDay = $originalBalance/($profile->term * 30);

                $ratePerWeek = 0;
                $ratePerWeek = ($originalBalance/($profile->term * 30) * 7) ;
            @endphp

            <td>{{ number_format($ratePerDay, 2) }}</td>

            @php
                $date_now = date("Y-m-d");
                if ( $date_now > $profile->date_to ) {
                    $color = "red";
                } else {
                    $color = "#000";
                }
            @endphp

            <td style="color: @php echo $color; @endphp">{{ date('d-m-Y', strtotime($profile->date_to)) }}</td>      
        </tr>
        @endforeach                     
    </table>
    
</body>
</html>