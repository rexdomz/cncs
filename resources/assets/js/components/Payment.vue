<template>
  <div>    
    <section class="content">
        <div class="row">

            <div class="col-md-8">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Profiles</h3>
                    </div>
                    <div class="box-body">
                        <table class="table">
                            <tr>                                
                                <th>Full Name</th>                            
                                <th>Loan Amount</th>
                                <th>Interest</th>
                                <th>Term</th>
                                <th>Rate/day</th>
                                <th>Balance</th>                            
                                <th>Maturity Date</th>                                               
                                <th>Action</th>                              
                            </tr>
                            <tr>                                
                                <td>Haleigh Labadie</td>
                                <td>10000</td>                                
                                <td><span class="badge bg-green">10%</span></td>
                                <td>2</td>
                                <td>100</td>
                                <td><span class="badge bg-red">10000</span></td>
                                <td>12/12/12</td>
                                <td><button type="button" class="btn btn-block btn-info btn-xs">Add Pay</button></td>                                
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Payment Form</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">                               
                            <label for="inputFullName" class="col-sm-3 control-label">Amount</label>    
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="amount" placeholder="Amount to pay ...">                            
                            </div>
                        </div>
                        </hr>
                        <div class="input-group date">
                            <label for="inputFullName" class="col-sm-3 control-label">Transaction Date</label>                            
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>                            
                            <input type="text" class="form-control pull-right" id="datepicker">                            
                        </div>
                        </hr>
                        <div class="col-sm-3">
                            <button type="submit" class="btn btn-primary btn-block">Save</button>
                        </div>
                    </div>
                    </hr>
                    <div class="box-header">
                        <h3 class="box-title">Payment History</h3>
                    </div>
                    <div class="box-body">
                        <table class="table">
                            <tr>                                
                                <th>Payment</th>                            
                                <th>Date</th>                  
                            </tr>
                            <tr>                                
                                <td>0</td>
                                <td>---</td>                                                           
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

        </div>    
    </section>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log('Component mounted.')
  }
}
 </script>