<template>
  <div>    
    <section class="content">
        <div class="row">

            <div class="col-md-9">
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
                                <th>Balance</th>                            
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
                                <td><span class="badge bg-blue"> {{ ( (profile.loan) + (profile.loan * (profile.interest/100) * profile.term) ) | currency('P') }} </span></td>
                                <td>{{ profile.date_to | formatDate }}</td>
                                <td><button @click="editprofile(profile)" type="button" class="btn btn-block btn-info btn-xs">Add Pay</button></td>                                
                            </tr>                                                        
                        </table>
                    </div>
                </div>
                <div class="box-footer">
                    Showing ({{ pagination.total }}) records...
                </div>
            </div>

            <div class="col-md-3">
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
                        <div style="margin: 1em 0;" class="row">
                            <div class="form-group">                               
                                <label for="inputFullName" class="control-label col-sm-4">Amount</label>    
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="amount" placeholder="Amount to pay ...">                            
                                </div>
                            </div>
                        </div>

                        <div style="margin: 1em 0;" class="row">
                            <div class="input-group date">
                                <label for="inputFullName" class="control-label col-sm-4"> Date</label>                                                        
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>                            
                                <input type="text" class="form-control pull-right" id="datepickerpay">                                   
                            </div>
                        </div>

                        <div style="margin: 0 0 1.5em 0;" class="row col-sm-4">
                            <button type="submit" class="btn btn-primary btn-block ">Save</button>
                        </div>

                    </div>
                </div> <!-- /box -->
                <div class="box">
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
      areas: [],
      area: {
          id: '',
          area_code: '',
          address: '',
          collector: '',
          contact: ''            
      },       
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
        contact: ''
      },
      profile_id: '',
      pagination: {},
      edit: false
    };
  },

  created() {
    this.fetchprofiles();
    this.fetchAreas();
  },

  methods: {
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
        var perpage = 15;
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
    addprofile() {
      if (this.edit === false) {
        // Add
        fetch('api/profile', {
          method: 'post',
          body: JSON.stringify(this.profile),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('profile Added');
            this.fetchprofiles();
          })
          .catch(err => console.log(err));
      } else {
        // Update
        fetch('api/profile', {
          method: 'put',
          body: JSON.stringify(this.profile),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('profile Updated');
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
      /*this.profile.address = profile.address;
      this.profile.area = profile.area;
      this.profile.loan = profile.loan;
      this.profile.interest = profile.interest;
      this.profile.term = profile.term;
      this.profile.date_from = profile.date_from;
      this.profile.date_to = profile.date_to;
      this.profile.contact = profile.contact;*/              
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
