<template>
  <div>
    
   <section class="content">
      <div class="row">
        <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                  <h3 class="box-title">Borrower's List</h3>          
              </div>                                      

              <div class="box-body">
                 
                <div class="col-md-3">
                  <div>                    
                    <select @change="fetchProfilesByAreas" v-model="area" id="area" name="area" class="area form-control select2">
                        <option value="0" selected="selected">Filter by Area</option>        
                        <option v-for="area in areas" :value="area.id" v-bind:key="area.id">{{ area.area_code }} - {{ area.address }}</option>
                    </select>
                  </div>
                </div>

                <div class="box-tools">
                    <ul class="pagination pagination-sm no-margin pull-right">
                        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchprofiles(pagination.prev_page_url)">Previous</a></li>
                        <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>                    
                        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchprofiles(pagination.next_page_url)">Next</a></li>
                    </ul>
                </div>

               <table style="margin-top: 1.5em; float: left" class="table">
                    <tr>
                    <!--<th style="width: 100px">Record ID </th>-->
                    <th >Full Name</th>
                    <th >Address</th>
                    <th >Principal Loan</th>
                    <th >Rate</th>
                    <th >Interest</th>
                    <th>Loan Amount</th>  
                    <th>Balance</th>                            
                    <th>Rate/Day</th>                   
                    <th >Term</th>
                    <th >Contact</th>                    
                    <th >Action</th>   
                    <th ></th> 
                    </tr>
                    <tr v-for="profile in profiles" v-bind:key="profile.id">                        
                        <td>{{ profile.full_name }}</td>
                        <td>{{ profile.address }}</td>
                        <td><span class="badge bg-green"> {{ profile.loan | currency('P') }} </span></td>
                        <td>{{ profile.interest }}%</td>
                        <td>{{ (profile.loan * (profile.interest/100) * profile.term) | currency('P') }}</td>                        
                        <td><span class="badge bg-blue"> {{ ( (profile.loan) + (profile.loan * (profile.interest/100) * profile.term) ) | currency('P') }} </span></td>
                        <td><span class="badge bg-red">{{ ( ( (( (profile.loan) + (profile.loan * (profile.interest/100) * profile.term)) ) - totalAmount ) ) - profile.totalpay | currency('P') }}</span></td>
                        <td>{{ ( ((profile.loan) + (profile.loan * (profile.interest/100) * profile.term)) / (profile.term * 30) ) | currency('P') }}</td>
                        <td>{{ profile.term }} month(s)</td>
                        <td>{{ profile.contact }}</td>                        
                        <td><button @click="editprofile(profile)" type="button" class="btn btn-block btn-info btn-xs" data-toggle="modal" data-target="#modal-info">Update</button></td>
                        <td><button @click="deleteProfile(profile.id)" class="btn btn-danger btn-xs">Delete</button></td>
                    </tr>
                </table>
                </div>
                <!-- /.box-body -->
            </div>

            <div class="modal modal-info fade" id="modal-info">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Borrower's Profile</h4>
                </div>
                <div class="modal-body" style="min-height: 500px;">
                  
                    <form @submit.prevent="addprofile" class="mb-4">
                        <div class="form-group">                               
                        <label for="inputFullName" class="col-sm-3 control-label">Full Name</label>
                        <div style="margin-bottom: 10px;" class="col-sm-8">
                            <input type="text" class="form-control" name="full_name" id="full_name" v-model="profile.full_name" placeholder="Lastname, Firstname  M.I. ...">
                        </div>
                        </div>
                        <div class="form-group">                               
                        <label for="inputFullName" class="col-sm-3 control-label">Address</label>
                        <div style="margin-bottom: 10px;" class="col-sm-8">
                            <input type="text" class="form-control" id="address" v-model="profile.address" placeholder="Address ...">
                        </div>
                        </div>
                        <div class="form-group">                               
                        <label for="inputFullName" class="col-sm-3 control-label">Area</label>
                        <div style="margin-bottom: 10px;" class="col-sm-8">
                            <select v-model="profile.area" id="area" name="area" class="form-control select2">
                              <option value="0" selected="selected">Select Area ...</option>        
                              <option v-for="area in areas" :value="area.id" v-bind:key="area.id">{{ area.area_code }}, {{ area.address }}</option>
                          </select>
                        </div>
                        </div>

                        <div class="form-group">                               
                            <label for="inputFullName" class="col-sm-3 control-label">Loan Amount</label>
                            <div style="margin-bottom: 10px;" class="col-sm-8">
                                <input type="text" class="form-control" id="loan" v-model="profile.loan" placeholder="e,g 1000, 2000, 5000...">
                            </div>
                        </div>
                        <div class="form-group">                               
                            <label for="inputFullName" class="col-sm-3 control-label">Interest Rate</label>
                            <div style="margin-bottom: 10px;" class="col-sm-8">
                                <input type="text" class="form-control" id="interest" v-model="profile.interest" placeholder="eg 10, 20, 30...">
                            </div>
                        </div>
                        <div class="form-group">                               
                            <label for="inputFullName" class="col-sm-3 control-label">Term</label>
                            <div style="margin-bottom: 10px;" class="col-sm-8">
                            <select v-model="profile.term" id="term" name="term" class="form-control select2" style="width: 100%;">
                                <option value="0" selected="selected">Select Term ...</option>        
                                <option v-for="i in (1, 12)" :value=i :key="i" > {{ i }} Month(s) </option>
                            </select>                 
                            </div>
                        </div>

                        <div class="form-group">                               
                            <label for="inputFullName" class="col-sm-3 control-label">Date Start</label>
                            <div style="margin-bottom: 10px;" class="col-sm-8">
                              <div class="input-group date">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                <!--<input v-model="profile.date_from" type="text" class="form-control pull-right" id="datepicker">                                 
                                <input v-model="profile.date_from" type="hidden" id="date_start">-->                                
                                <input id="myDate" class="form-control pull-right" type="text" v-model="profile.date_from" placeholder="2019-04-01"> 
                                <!--<input id="myDate" class="form-control pull-right" type="date" :value="myDate && myDate.toISOString().split('T')[0]" @input="myDate = $event.target.valueAsDate">
                                <input v-model="myDate" type="hidden">-->
                              </div>
                            </div>
                        </div>

                        <div class="form-group">                               
                            <label for="inputFullName" class="col-sm-3 control-label">Date End</label>
                            <div style="margin-bottom: 10px;" class="col-sm-8">
                              <div class="input-group date">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                <input id="myDate" class="form-control pull-right" type="text" v-model="profile.date_to" placeholder="2019-04-01"> 
                                <!--<input v-model="profile.date_to" type="text" class="form-control pull-right" id="datepicker2"> 
                                <input v-model="profile.date_to" type="hidden" id="date_end">--> 
                              </div>
                            </div>
                        </div>

                        <div class="form-group">                               
                            <label for="inputFullName" class="col-sm-3 control-label">Contact #</label>
                            <div style="margin-bottom: 10px;" class="col-sm-8">
                                <input type="text" class="form-control" id="contact" v-model="profile.contact" placeholder="Contact number (cp) ...">
                            </div>
                        </div>

                        <div class="form-group">                               
                            <div class="col-sm-3">
                              <button type="submit" class="btn btn-primary btn-xs">Update Record</button>
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
    addprofile() {
      console.log(JSON.stringify(this.profile))
      if (this.edit === false) {
        fetch('http://cn.com/api/profile', {
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
        fetch('http://cn.com/api/profiler', {
            method: 'put',
            body: JSON.stringify(this.profile),
            headers: {
              'content-type': 'application/json'
            }
          })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('Profile Updated');
            this.fetchProfilesByAreas();
          })
          .catch(err => console.log(err));               
      }      
    },
    fetchAreas(page_url) {            
        page_url = 'http://cn.com/api/areas';
        fetch(page_url)
            .then(res => res.json())
            .then(res => {
            this.areas = res.data;            
            })
            .catch(err => console.log(err));
    },
    fetchProfilesByAreas() {    
        let vm = this;                
        var id = this.area
        var perpage = 25;
        //console.log('Area:' + id)
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
    deleteProfile(id) {
      if (confirm('Are You Sure?')) {
        fetch(`http://cn.com/api/profile/${id}`, {
          method: 'delete'
        })
          .then(res => res.json())
          .then(data => {
            alert('profile Removed');
            //this.fetchprofiles();
            this.fetchProfilesByAreas();
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
