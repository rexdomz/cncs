<template>
  <div>
    
   <section class="content">
      <div class="row">
        <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                  <h3 class="box-title">Quota - Collections</h3>          
              </div>                                      

              <div class="box-body">                 
                    <div class="col-md-3">
                    
                    </div>

                    <div class="box-tools">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchprofiles(pagination.prev_page_url)">Previous</a></li>
                            <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>                    
                            <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchprofiles(pagination.next_page_url)">Next</a></li>
                        </ul>
                    </div>
                    <div class="col-md-8">
                        <table style="margin-top: 1.5em; float: left" class="table">
                            <tr>                    
                            <th>Full Name</th>                    
                            <th>Loan Amount</th>
                            <th>Total Loan</th> 
                            <th>Interest</th>
                            <th>Term</th>
                            <th>Rate/day</th>
                            <th>Rate/Week</th>
                            </tr>
                            <tr v-for="profile in profiles" v-bind:key="profile.id">                        
                                <td>{{ profile.full_name }}</td>                        
                                <td><span class="badge bg-green"> {{ profile.loan | currency('P') }} </span></td>
                                <!--<td><span class="badge bg-blue"> {{ ( (profile.loan) + (profile.loan * (profile.interest/100) * profile.term) ) | currency('P') }} </span></td>-->
                                <td><span class="badge bg-blue">{{ ( (( (profile.loan) + (profile.loan * (profile.interest/100) * profile.term)) ) - totalAmount ) | currency('P') }}</span></td>
                                <td>{{ profile.interest }}%</td>
                                <td>{{ profile.term }} month(s)</td>
                                <td>{{ ( ((profile.loan) + (profile.loan * (profile.interest/100) * profile.term)) / (profile.term * 30) ) | currency('P') }}</td>
                                <td>{{ ( ( ((profile.loan) + (profile.loan * (profile.interest/100) * profile.term)) / (profile.term * 30) ) * 7 ) | currency('P') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <div><p>Filter by Area:                    
                            <select @change="fetchProfilesByAreas()" v-model="area" id="area" name="area" class="form-control select2" style="height: 30px !important; width: 50%; margin: 10px 0 5px 0;">
                                <option value="0" selected="selected">Default (all area)</option>        
                                <option v-for="area in areas" :value="area" v-bind:key="area.id">{{ area.area_code }} - {{ area.address }}</option>
                            </select></p>
                        </div>
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Collectibles</h3>
                                <p><span style="width: 150px;float: left;">Daily: </span><span class="badge bg-blue">{{ totalAmountDaily | currency('P') }} </span> <br>
                                <span style="width: 150px;float: left;">Weekly: </span><span class="badge bg-green"> {{ totalAmountWeekly | currency('P') }} </span> <br>
                                <span style="width: 150px;float: left;"> Area Collector: </span> {{ area.collector }} <br>
                                <span style="width: 150px;float: left;"> Total(lenders): </span> {{ pagination.total }}</p>
                            </div>
                            <div class="box-body">
                                
                            </div>
                        </div> <!-- /box -->
                    </div>

                </div>
                <!-- /.box-body -->
            </div>

            <!-- /.box-body -->
                <div class="box-footer">
                    Showing ({{ pagination.total }}) records...
                </div>
                <!-- /.box-footer-->
            <!-- /.box -->
            </div>  
      </div>    
      
    </section>

  </div>

</template>

<script>
export default {
  data() {
    return {
      myDate: null,  
      myDate2: null, 
      myDate3: null,      
      areas: [],
      area: {
          id: '',
          area_code: '',
          address: '',
          collector: 'All',
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
      profiles: [],      
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
        contact: ''
      },
      profile_id: '',
      pagination: {},
      edit: false
    };
  },

  watch: {
    myDate() {      
      this.myDate2 = new Date(this.myDate.setDate(this.myDate.getDate() + this.profile.term * 30));
      this.myDate3 = new Date(this.myDate.setDate(this.myDate.getDate() - this.profile.term * 30));          
      console.log('1st: '+ this.myDate3.toISOString().split('T')[0]);
      console.log('2nd: '+ this.myDate2.toISOString().split('T')[0]);
    }
  },

  created() {
    this.fetchprofiles();
    this.fetchAreas();
  },

  computed: {
      totalAmountDaily: function () {
          var sum = 0;
          this.profiles.forEach(e => {
              sum += ( ((e.loan) + (e.loan * (e.interest/100) * e.term)) / (e.term * 30) );
          });
          return sum
      },
      totalAmountWeekly: function () {
          var sum = 0;
          this.profiles.forEach(e => {
              sum += ( ((e.loan) + (e.loan * (e.interest/100) * e.term)) / (e.term * 30) * 7);
          });
          return sum
      },
      totalAmount: function () {
          var sum = 0;
          this.payments.forEach(e => {
              sum += e.pay;
          });
          return sum
      }
  },

  methods: {    
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
    fetchAreas(page_url) {            
        page_url = page_url || 'api/areas';
        fetch(page_url)
            .then(res => res.json())
            .then(res => {
            this.areas = res.data;            
            })
            .catch(err => console.log(err));
    },
    fetchProfilesByAreas() {    
        let vm = this;                
        var id = this.area.id          
        var perpage = 25;        
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
      page_url = page_url || 'api/profiles';
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
    deleteprofile(id) {
      if (confirm('Are You Sure?')) {
        fetch(`api/profile/${id}`, {
          method: 'delete'
        })
          .then(res => res.json())
          .then(data => {
            alert('profile Removed');
            this.fetchprofiles();
          })
          .catch(err => console.log(err));
      }
    },
    editprofile(profile) {
      this.edit = true;
      this.profile.id = profile.id;
      this.profile.profile_id = profile.id;
      this.profile.full_name = profile.full_name;
      this.profile.address = profile.address;
      this.profile.area = profile.area;      
      this.profile.loan = profile.loan;
      this.profile.interest = profile.interest;
      this.profile.term = profile.term;
      this.profile.date_from = moment(String(profile.date_from)).format('YYYY-MM-DD'); 
      this.profile.date_to = moment(String(profile.date_to)).format('YYYY-MM-DD');
      this.profile.contact = profile.contact;       
      this.fetchPaymentsByID(profile.id);       
    },
    clearForm() {
      this.edit = false;
      this.profile.id = null;
      this.profile.profile_id = null;
      this.profile.full_name = '';
      this.profile.address = '';
      this.profile.area = '';
      this.profile.loan = '';
      this.profile.interest = '';
      this.profile.term = '';
      this.profile.date_from = '';
      this.profile.date_to = '';
      this.profile.contact = ''; 
    }
  }
};
</script>
