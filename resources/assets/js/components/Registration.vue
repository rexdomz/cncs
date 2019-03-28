<template>
  <div>
    
    <!--<form @submit.prevent="addprofile" class="mb-3">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Title" v-model="profile.title">
      </div>
      <div class="form-group">
        <textarea class="form-control" placeholder="Body" v-model="profile.body"></textarea>
      </div>
      <button type="submit" class="btn btn-light btn-block">Save</button>
    </form>
    <button @click="clearForm()" class="btn btn-danger btn-block">Cancel</button>-->

    <section class="content">
        
      <div class="col-md-6">
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
                    <div style="margin-bottom: 10px;" class="col-sm-8">
                        <input type="text" class="form-control" id="full_name" v-model="profile.full_name" placeholder="Lastname, Firstname  M.I. ...">
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
                        <area-list></area-list>
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
                            <select id="term" name="term" class="form-control select2" style="width: 100%;">
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
                            <input type="text" class="form-control pull-right" id="datepicker"> 
                            <input v-model="profile.date_from" type="hidden" id="date_start"> 
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
                            <input type="text" class="form-control pull-right" id="datepicker2"> 
                            <input v-model="profile.date_to" type="hidden" id="date_end"> 
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
                        <div class="col-sm-3">&nbsp;</div>  
                        <div style="margin-bottom: 10px;" class="col-sm-8">                    
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

      <div class="col-md-4">
        <div class="box box-default">

            <div class="box-header with-border">
            <h3 class="box-title">Status</h3>
            </div>        

            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">                                                
                        <div class="small-box bg-green">
                            <div class="inner">
                            <h3>{{ pagination.total }}</h3>

                            <p>Registered Users</p>
                            </div>
                            <div class="icon">
                            <i class="ion ion-person-add"></i>
                            </div>
                            
                        </div>                           
                    </div>                    
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
      profiles: [],      
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

  created() {
    this.fetchprofiles();        
  },

  methods: {    
    onChangeDate(){
      setTimeout(() => {                
        console.log(this.dateStart);    
      }, 500)
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
        console.log(this.profile)
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
