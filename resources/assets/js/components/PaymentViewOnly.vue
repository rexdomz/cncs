<template>
  <div>    
    <section class="content">
        <div class="row">

            <div class="col-md-8">
                <div class="box">                    
                    
                    <div class="box-body">
                         
                        <div class="col-md-4">                          
                          <p style="margin: 0 0 0 -10px">Search by Collector's name:</p>  
                          <select @change="fetchProfilesByAreas" v-model="area" id="area" name="area" class="area form-control select2">                                   
                              <option v-for="area in areas" :value="area.id" v-bind:key="area.id">{{ area.collector }} ( {{ area.area_code }} - {{ area.address }} )</option>
                          </select>
                        </div>   

                        <div class="col-md-4">
                          <p style="margin: 0">Search by customer's name:</p>                                                     
                          <input type="text" placeholder="Type a customer lastname" v-model="query" v-on:keyup="autoComplete" name="query" class="form-control searchnameinpt">
                        </div>                     

                        <div class="box-tools">
                            <ul class="pagination pagination-sm no-margin pull-right">
                                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchprofiles(pagination.prev_page_url)">Previous</a></li>
                                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>                    
                                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchprofiles(pagination.next_page_url)">Next</a></li>
                            </ul>
                        </div>                                            

                        <table class="table">
                            <tr>                                
                                <th>Full Name</th>                            
                                <th>Loan Amount</th>
                                <!--<th>Balance</th>
                                <th>Interest(%)</th>                                
                                <th>Term</th>-->
                                <!--<th>Interest(Php)</th>-->
                                <th>Rate/day</th> 
                                <th>Rate/Week</th>                               
                                <th>Maturity Date</th>                                               
                                <th>Action</th>                              
                            </tr>
                            <tr v-for="profile in profiles" v-bind:key="profile.id">                                                    
                                <td>{{ profile.full_name }}</td>                                                                                           
                                <td><span class="badge bg-blue"> {{ ( (profile.loan) + (profile.loan * (profile.interest/100) * profile.term) ) | currency('P') }} </span></td>
                                <!--<td><span class="badge bg-red">{{ ( ( (( (profile.loan) + (profile.loan * (profile.interest/100) * profile.term)) ) - totalAmount ) ) - profile.totalpay | currency('P') }}</span></td>
                                <td>{{ profile.interest }}%</td>
                                <td>{{ profile.term }} month(s)</td>-->
                                <!--<td>{{ (profile.loan * (profile.interest/100) * profile.term) | currency('P') }}</td>-->                                
                                <td>{{ ( ((profile.loan) + (profile.loan * (profile.interest/100) * profile.term)) / (profile.term * 30) ) | currency('P') }}</td>
                                <td>{{ ( ( ((profile.loan) + (profile.loan * (profile.interest/100) * profile.term)) / (profile.term * 30) ) * 7 ) | currency('P') }}</td>
                                <!--<td>{{ ( (profile.loan) + (profile.loan * (profile.interest/100) * profile.term) ) | currency('P') }}</td>-->
                                <td><span v-bind:style=" checkDate(profile) ? 'color: #000;' : 'color: red;' " >{{ profile.date_to | formatDate }}</span></td>
                                <td><button @click="editprofile(profile)" type="button" class="btn btn-block btn-info btn-xs">View Profile</button></td>                                
                            </tr>                                                        
                        </table>
                    </div>
                </div>
                <!--<div class="box-footer">
                    Showing ({{ pagination.total }}) records...
                </div>-->
            </div>

            <div class="col-md-4">
                <div id="PrintArea" class="box">
                    <div class="box-header">
                        <h3 class="box-title">Payment History</h3>
                        <h5><strong> Name: {{ profile.full_name | capitalize }} </strong></h5>
                        <p>                          
                         <span style="width: 130px;float: left;">Balance: </span><span class="badge bg-red">{{ ( (( (profile.loan) + (profile.loan * (profile.interest/100) * profile.term)) ) - totalAmount ) | currency('P') }} </span> <br>
                         <span style="width: 130px;float: left;">Loan Amount: </span><span class="badge bg-blue"> {{ ( (profile.loan) + (profile.loan * (profile.interest/100) * profile.term) ) | currency('P') }} </span> <br>
                         <span style="width: 130px;float: left;">Interest rate: </span><span class="badge bg-green"> {{ profile.interest }}% </span> <br>
                         <span style="width: 130px;float: left;"> Rate/day: </span><span class="badge bg-green"> {{ ( ((profile.loan) + (profile.loan * (profile.interest/100) * profile.term)) / (profile.term * 30) ) | currency('P') }}</span>
                        </p>
                    </div>
                    <div class="box-body">
                        <table class="table">
                            <tr>                                
                                <th>Payment</th>                            
                                <th>Date paid</th>   
                                <th>Action</th>               
                            </tr>
                            <tr v-for="payment in payments" v-bind:key="payment.id">                                                    
                                <td>{{ payment.pay | currency('P') }}</td>                                
                                <td>{{ payment.date_pay | formatDate }}</td>                                                         
                                <td><button @click="editpayment(payment)" type="button" class="btn btn-block btn-info btn-xs" data-toggle="modal" data-target="#modal-info">edit</button></td>
                                <td><button @click="deletepay(payment.id)" type="button" class="btn btn-block btn-danger btn-xs">remove</button></td>                                
                            </tr>
                            <tr><td><strong> payments: {{ totalAmount | currency('P') }} </strong></td></tr>
                        </table>                        
                    </div>
                </div> <!-- /box -->
                <div style="margin: 15px 0;" class="row col-sm-3">
                  <a :href=paymentHref class="btnPrint btn btn-block btn-info btn-xs">Print</a>
                </div>
            </div>

                <div class="modal modal-info fade" id="modal-info">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Payment details</h4>
                      </div>
                      <div class="modal-body" style="min-height: 200px;">
                        
                          <form @submit.prevent="addpayment" class="mb-4">                          
                          <div style="margin: 1em 0;" class="row">
                              <div class="form-group">                               
                                  <label for="inputFullName" class="control-label col-sm-4">edit amount</label>    
                                  <div class="col-sm-12">
                                      <input type="text" class="form-control" id="amount" v-model="payment.pay" placeholder="Amount to pay ...">                            
                                  </div>
                              </div>
                          </div>

                          <div style="margin: 0;" class="row col-sm-4">
                            <div class="form-group"> 
                              <button type="submit" value="submit" class="btn btn-primary btn-block">Save</button>                              
                            </div>
                          </div>
                        </form>
                        
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>                  
                      </div>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
        </div>    
    </section>
  </div>
</template>

<script>

//npm install vue2-filters
import Vue2Filters from 'vue2-filters'
Vue.use(Vue2Filters)

export default {
  data() {    
    return {
      query: '',
      payDate: new Date().toISOString().slice(0,10),
      areas: [],
      area: {
          id: '',
          area_code: '',
          address: '',
          collector: '',
          contact: ''            
      },  
      payments: [],
      payment: {        
        id: '',
        profile_id: '',
        pay: '',
        date_pay: ''     
      },        
      pay_id: '',    
      profile_id: '',           
      profiles: [],
      loaninterest: [],
      ctr: 1,
      profile: {        
        id: '',
        full_name: '',
        address: '',
        area: '',
        loan: '',
        interest: '',
        term: '',
        date_from: '',
        date_to: '',
        contact: '',
        date_expire: false        
      },            
      profile_id: '',
      pagination: {},
      edit: false,
      payedit:  false
    };
  },

  filters: {
    formatDate(value) {                
      return moment(String(value)).format('D MMM YYYY');      
    }
  },

  created() {
    this.fetchprofiles();
    this.fetchAreas();
  },

  computed: {
      totalAmount: function () {
          var sum = 0;
          this.payments.forEach(e => {
              sum += e.pay;
          });
          return sum
      },
      paymentHref () {
        //console.log(this.profile.id);
        return "payment-view/" + this.profile.id;
      }
  },

  methods: {
    checkDate(profile) {
      var date = moment(profile.date_to)
      var now = moment().valueOf();
      if (date > now) {
        this.profile.date_expire = true;     
        return true;   
      } else {
        this.profile.date_expire = false;        
        return false;
      }        
    },

    fetchAreas(page_url) {            
        page_url = 'http://cn.com/api/areas';
        fetch(page_url)
            .then(res => res.json())
            .then(res => {
            this.areas = res.data;        
            console.log(this.area)    
            })
            .catch(err => console.log(err));
    },
    fetchProfilesByAreas() {    
        let vm = this;        
        //page_url = page_url || 'http://cncs.com/api/profilesbyarea/${id}';
        var id = this.area
        var perpage = 25;
        console.log('Area:' + id)
        fetch(`http://cn.com/api/profilesbyarea/${id}/${perpage}`)
          .then(res => res.json())
          .then(res => {
            this.profiles = res.data;
            vm.makePagination(res.meta, res.links);
          })
          .catch(err => console.log(err));        
    },
    fetchprofiles(page_url) {
      let vm = this;
      page_url = page_url || 'http://cn.com/api/profiles';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.profiles = res.data;          
          vm.makePagination(res.meta, res.links);
        })
        .catch(err => console.log(err));        
    },

    makePagination(meta, links) {
      let pagination = {
        current_page: meta.current_page,
        last_page: meta.last_page,
        next_page_url: links.next,
        prev_page_url: links.prev,
        per_page: meta.per_page,
        total: meta.total
      };

      this.pagination = pagination;
    },
    printPay(){
      console.log(this.payments);
    },
    fetchPaymentsByID(id) {    
        let vm = this;                        
        var perpage = 60;                
        fetch(`http://cn.com/api/paymentsbyid/${id}/${perpage}`)
          .then(res => res.json())
          .then(res => {
            this.payments = res.data;
            //console.log(this.payments);
            //vm.makePagination(res.meta, res.links);
          })
          .catch(err => console.log(err));                  
    },

    addpayment() {      
      if (this.payedit === false) {        
        this.payment.profile_id = this.profile.id;        
        this.payment.date_pay = moment(String(this.payDate)).format('YYYY-MM-DD hh:mm:ss');                
        // Add        
        fetch('http://cn.com/api/newpayment', {
          method: 'post',
          body: JSON.stringify(this.payment),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            //this.clearForm();
            //alert('Payment Added');
            //this.fetchprofiles();
            this.fetchPaymentsByID(this.payment.profile_id);
          })
          .catch(err => console.log(err));
      } else {
        // Update
        fetch('http://cn.com/api/updatepayment', {
          method: 'put',
          body: JSON.stringify(this.payment),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            //alert('Payment Updated');
            this.fetchPaymentsByID(this.payment.profile_id);
          })
          .catch(err => console.log(err));          
      }
    },
    deletepay(id) {
      if (confirm('Are You Sure?')) {
        fetch(`http://cn.com/api/deletepayment/${id}`, {
          method: 'delete'
        })
          .then(res => res.json())
          .then(data => {
            //alert('payment Removed');
            this.fetchPaymentsByID(this.payment.profile_id);
          })
          .catch(err => console.log(err));
      }
    },
    editprofile(profile) {
      this.edit = true;
      this.profile.id = profile.id;
      this.profile.profile_id = profile.id;
      this.profile.full_name = profile.full_name;    
      this.profile.loan = profile.loan;      
      this.profile.interest = profile.interest;
      this.profile.term = profile.term;
      this.profile.date_from = profile.date_from;
      this.profile.date_to = profile.date_to;
      this.fetchPaymentsByID(profile.id); 
      //this.fetchProfilesByAreas();       
    },

    autoComplete(page_url){
      this.results = [];
      if(this.query.length > 1){     
          var query = this.query
          page_url = `http://cn.com/api/profilesbykeyword/${query}`;
          fetch(page_url)
              .then(res => res.json())
              .then(res => {
              this.profiles = res.data;         
              console.log(this.profiles);    
              })
              .catch(err => console.log('what error?: ' + err));
              
      } else {
        this.fetchprofiles();
      }
    }, //end autocomplete

    editpayment(payment) {
      this.payedit = true;
      this.payment.id = payment.id;
      this.payment.pay_id = payment.id;
      this.payment.profile_id = payment.profile_id; 
      this.payment.pay = payment.pay;
      this.payment.date_pay = payment.date_pay;
    },
    clearForm() {
      this.payedit = false;
      this.payment.id = null;
      this.payment.pay_id = null;
      //this.payment.profile_id = payment.profile_id; 
      this.payment.pay = '';
      this.payment.date_pay = new Date().toISOString().slice(0,10);
    }
  }
};
</script>
