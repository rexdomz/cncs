<template>
  <div>
    
    <section class="content">
        
      <div class="col-md-9">
        <div class="box box-default">

            <div class="box-header with-border">
            <h3 class="box-title">New Registration</h3>
            </div>        

            <!-- /.box-header -->
            <div class="box-body">
            <div class="row">
                <form @submit.prevent="addprofile" class="mb-4">
                    <div class="form-group">                               
                    <label for="inputFullName" class="col-sm-3 control-label">Full Name</label>
                    <div style="margin-bottom: 10px;" class="col-sm-9">
                        <input type="text" class="form-control" id="full_name" v-model="profile.full_name" placeholder="Lastname, Firstname  M.I. ...">
                    </div>
                    </div>
                    <div class="form-group">                               
                    <label for="inputFullName" class="col-sm-3 control-label">Address</label>
                    <div style="margin-bottom: 10px;" class="col-sm-9">
                        <input type="text" class="form-control" id="address" v-model="profile.address" placeholder="Address ...">
                    </div>
                    </div>
                    <div class="form-group">                               
                    <label for="inputFullName" class="col-sm-3 control-label">Area</label>
                    <div style="margin-bottom: 10px;" class="col-sm-9">
                        <select v-model="profile.area" id="area" name="area" class="form-control select2" style="width: 100%;">
                            <option value="0" selected="selected">Select Area ...</option>        
                            <option v-for="area in areas" :value="area.id" v-bind:key="area.id">{{ area.area_code }}, {{ area.address }}</option>
                        </select>
                    </div>
                    </div>

                    <div class="form-group">                               
                        <label for="inputFullName" class="col-sm-3 control-label">Loan</label>
                        <div style="margin-bottom: 10px;" class="col-sm-9">
                            <input type="text" class="form-control" id="loan" v-model="profile.loan" placeholder="e,g 1000, 2000, 5000...">
                        </div>
                    </div>

                    <div class="form-group">                               
                        <label for="inputFullName" class="col-sm-3 control-label">Interest</label>
                        <div style="margin-bottom: 10px;" class="col-sm-9">
                            <input type="text" class="form-control" id="interest" v-model="profile.interest" placeholder="eg 10, 20, 30...">
                        </div>
                    </div>

                    <div class="form-group">                               
                        <label for="inputFullName" class="col-sm-3 control-label">Term</label>
                        <div style="margin-bottom: 10px;" class="col-sm-9">
                            <select v-model="profile.term" id="term" name="term" class="form-control select2" style="width: 100%;">
                            <option value="0" selected="selected">Select Term ...</option>        
                            <option v-for="i in (1, 12)" :value=i :key="i" > {{ i }} Month(s) </option>
                        </select>                    
                        </div>
                    </div>

                    <div class="form-group">                               
                        <label for="inputFullName" class="col-sm-3 control-label">Date Start</label>
                        <div style="margin-bottom: 10px;" class="col-sm-9">
                          <div class="input-group date">
                            <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                            </div>
                            <!--<input class="form-control pull-right" id="datepicker">--> 
                            <input id="myDate" class="form-control pull-right" type="date" :value="myDate && myDate.toISOString().split('T')[0]" @input="myDate = $event.target.valueAsDate">
                            <input v-model="myDate" type="hidden">
                          </div>
                        </div>
                    </div>

                    <div class="form-group">                               
                        <label for="inputFullName" class="col-sm-3 control-label">Date End</label>
                        <div style="margin-bottom: 10px;" class="col-sm-9">
                          <div class="input-group date">
                            <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                            </div>                            
                            <!--<input id="myDate2" class="form-control pull-right" v-model="myDate2" type="text" >-->
                            <input id="myDate2" class="form-control pull-right" type="date" :value="myDate2 && myDate2.toISOString().split('T')[0]" @input="myDate2 = $event.target.valueAsDate">
                            <input v-model="myDate2" type="hidden">
                          </div>
                        </div>
                    </div>

                    <div class="form-group">                               
                        <label for="inputFullName" class="col-sm-3 control-label">Contact #</label>
                        <div style="margin-bottom: 10px;" class="col-sm-9">
                            <input type="text" class="form-control" id="contact" v-model="profile.contact" placeholder="Contact number (cp) ...">
                        </div>
                    </div>

                    <div class="form-group">                               
                        <div class="col-sm-3">&nbsp;</div>  
                        <div style="margin-bottom: 10px;" class="col-sm-9">                    
                            <button type="submit" class="btn btn-primary btn-block">Save</button>                                        
                            <button @click="clearForm()" class="btn btn-warning btn-block">Clear</button>                              
                        </div>
                    </div>
                </form> 
            </div>
            </div>
        </div>        
        <!-- /.box -->
      </div>
      <!-- /.registration -->

      <div class="col-md-3">
        <div class="box box-default">

            <div class="box-header with-border">
            <h3 class="box-title">Status</h3>
            </div>        

            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">                                                
                        <div class="small-box bg-green">
                            <div class="inner">
                            <h3>{{ pagination.total }}</h3>

                            <p>Registered Users</p>
                            </div>
                            <div class="icon">
                            <i class="ion ion-person-add"></i>
                            </div>                            
                        </div> 
                        <div class="alert alert-danger" role="alert" v-if="errors.length">                                    
                            <b>Please correct the following error(s):</b>
                            <ul><li v-for="error in errors" :key="error.index" >{{ error }}</li></ul>                    
                        </div>                          
                    </div>                    
                </div>
                <div class="row">   
                  
                </div>
            </div>

        </div>
      </div>
      <!-- /.details -->

    </section>

  </div>

</template>

<script>

export default {
  data() {
    return {   
      myDate: '',  
      myDate2: null, 
      myDate3: null,
      profiles: [],  
      errors: [],    
      areas: [],
      area: {
          id: '',
          area_code: '',
          address: '',
          collector: '',
          contact: ''            
      },
      profile: {        
        id: '',
        full_name: '',
        address: '',
        area: '',
        loan: '',
        interest: '',
        term: '',
        date_from: null,
        date_to: null,
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
    this.fetchAreas();  
    this.fetchprofiles();          
  },

  methods: {   
    fetchprofiles(page_url) {
      let vm = this;
      page_url = page_url || `http://cn.com/api/profiles`;
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
      this.errors = [];
      if (!this.profile.full_name) {
        this.errors.push('Full name required.');
      }
      if (!this.profile.address) {
        this.errors.push('Address required.');
      }
      if (!this.profile.area) {
        this.errors.push('Area required.');
      }
      if (!this.profile.loan) {
        this.errors.push('Loan required.');
      }
      if (!this.profile.interest) {
        this.errors.push('Interest required.');
      }
      if (!this.profile.term) {
        this.errors.push('Term required.');
      }
      if (!this.profile.contact) {
        this.errors.push('Contact information required.');
      }
      /*if (!this.profile.date_from) {
        this.errors.push('Invalid start date.');
      }
      if (!this.profile.date_to) {
        this.errors.push('Invalid end date.');
      }*/
      //console.log(this.errors.length);
      this.profile.date_from = moment(String(this.myDate3)).format('YYYY-MM-DD hh:mm:ss');      
      this.profile.date_to = moment(String(this.myDate2)).format('YYYY-MM-DD hh:mm:ss');
      console.log(JSON.stringify(this.profile));        
      if (this.edit === false && this.errors.length <= 0 ) {
        console.log(JSON.stringify(this.profile))        
        // Add
        fetch(`http://cn.com/api/profile`, {
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
      this.profile.date_from = null;
      this.profile.date_to = null
      this.profile.contact = ''; 
    }
  }
};
</script>
