<template>
  <div>    
    <section class="content">
        <div class="row">

            <div class="col-md-8">
                <div class="box">                    
                    
                    <div class="box-body">
                        <h5 class="box-title">Filter By:</h5>  
                        <div class="col-md-3">
                          <select @change="fetchProfilesByAreas" v-model="area" id="area" name="area" class="form-control select2">
                              <option value="0" selected="selected">Filter by Area</option>        
                              <option v-for="area in areas" :value="area.id" v-bind:key="area.id">{{ area.area_code }} - {{ area.address }}</option>
                          </select>
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
                                <th>Principal Loan</th>
                                <th>Interest Rate</th>                                
                                <th>Term</th>
                                <th>Interest</th>
                                <th>Rate/day</th>
                                <!--<th>Balance</th>-->                            
                                <th>Maturity Date</th>                                               
                                <th>Action</th>                              
                            </tr>
                            <tr v-for="profile in profiles" v-bind:key="profile.id">                                                    
                                <td>{{ profile.full_name }}</td>
                                <td><span class="badge bg-green"> {{ profile.loan | currency('P') }} </span></td>                                                                
                                <td>{{ profile.interest }}%</td>
                                <td>{{ profile.term }} month(s)</td>
                                <td>{{ (profile.loan * (profile.interest/100) * profile.term) | currency('P') }}</td>                                
                                <td>{{ ( ((profile.loan) + (profile.loan * (profile.interest/100) * profile.term)) / (profile.term * 30) ) | currency('P') }}</td>
                                <!--<td>{{ ( (profile.loan) + (profile.loan * (profile.interest/100) * profile.term) ) | currency('P') }}</td>-->
                                <td><span v-bind:style=" checkDate(profile) ? 'color: #000;' : 'color: red;' " >{{ profile.date_to | formatDate }}</span></td>
                                <td><button @click="editprofile(profile)" type="button" class="btn btn-block btn-info btn-xs">View Payment</button></td>                                
                            </tr>                                                        
                        </table>
                    </div>
                </div>
                <div class="box-footer">
                    Showing ({{ pagination.total }}) records...
                </div>
            </div>

            <div class="col-md-4">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Payment Form</h3>
                    </div>
                    <div class="box-body">                        
                        <div style="margin: 1em 0;" class="row">
                              <div class="form-group">                               
                                  <label for="inputFullName" class="control-label col-sm-4">Name</label>    
                                  <div class="col-sm-12">
                                      <input type="text" class="form-control" id="full_name" v-model="profile.full_name" placeholder="Borrower's name...">                            
                                  </div>
                              </div>
                        </div>
                        <form @submit.prevent="addpayment" class="mb-4">                          
                          <div style="margin: 1em 0;" class="row">
                              <div class="form-group">                               
                                  <label for="inputFullName" class="control-label col-sm-4">Amount</label>    
                                  <div class="col-sm-12">
                                      <input type="text" class="form-control" id="amount" v-model="payment.pay" placeholder="Amount to pay ...">                            
                                  </div>
                              </div>
                          </div>

                          <div style="margin: 1em 0;" class="row">
                              <div class="input-group date">
                                  <label for="inputFullName" class="control-label col-sm-4"> Date</label>                                                        
                                  <div class="input-group-addon">
                                      <i class="fa fa-calendar" style="margin: 0 20px 0 5px;"></i>
                                  </div>                            
                                  <!--<input id="payDate" class="form-control pull-right" type="date" :value="payDate && payDate.toISOString().split('T')[0]" @input="payDate = $event.target.valueAsDate">-->
                                  <input v-model="payDate" id="payDate" type="date" class="form-control pull-right" style="padding: 0;margin: 0 15px 0 0;">
                                  <input v-model="payDate" type="hidden">                                   
                              </div>
                          </div>

                          <div style="margin: 0;" class="row col-sm-4">
                            <div class="form-group"> 
                              <button type="submit" value="submit" class="btn btn-primary btn-block">Save</button>                              
                            </div>
                          </div>

                        </form>

                    </div>
                </div> <!-- /box -->
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Payment History</h3>
                        <p>Balance: <span class="badge bg-blue">Php </span> | Loan: <span class="badge bg-green"> {{ profile.loan | currency('P') }} </span></p>
                    </div>
                    <div class="box-body">
                        <table class="table">
                            <tr>                                
                                <th>Payment</th>                            
                                <th>Date paid</th>                  
                            </tr>
                            <tr v-for="payment in payments" v-bind:key="payment.id">                                                    
                                <td>{{ payment.pay | currency('P') }}</td>                                
                                <td>{{ payment.date_pay | formatDate }}</td>                         
                            </tr>
                        </table>
                    </div>
                </div> <!-- /box -->
            </div>

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
        page_url = page_url || 'http://cn.com/api/areas';
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
        var perpage = 20;
        console.log('Area:' + id)
        fetch(`api/profilesbyarea/${id}/${perpage}`)
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

    fetchPaymentsByID(id) {    
        let vm = this;                        
        var perpage = 20;                
        fetch(`api/paymentsbyid/${id}/${perpage}`)
          .then(res => res.json())
          .then(res => {
            this.payments = res.data;
            console.log(this.payments);
            vm.makePagination(res.meta, res.links);
          })
          .catch(err => console.log(err));                  
    },

    addpayment() {      
      if (this.payedit === false) {        
        this.payment.profile_id = this.profile.id;        
        this.payment.date_pay = moment(String(this.payDate)).format('YYYY-MM-DD hh:mm:ss');   
        console.log("test: " + JSON.stringify(this.payment));     
        // Add        
        fetch('api/newpayment', {
          method: 'post',
          body: JSON.stringify(this.payment),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            //this.clearForm();
            alert('Payment Added');
            //this.fetchprofiles();
            this.fetchPaymentsByID(this.payment.profile_id);
          })
          .catch(err => console.log(err));
      } else {
        // Update
        fetch('api/updatepayment', {
          method: 'put',
          body: JSON.stringify(this.profile),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            //this.clearForm();
            alert('Payment Updated');
            //this.fetchprofiles();
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
    }

  }
};
</script>
