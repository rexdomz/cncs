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
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">New registration</h3>
        </div>

        <!-- /.box-header -->
        <div class="box-body">

          <div class="row">

            <div class="col-md-4">
                <div class="form-group">                               
                  <label for="inputFullName" class="col-sm-3 control-label">Full Name</label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control" id="fullname" placeholder="Lastname, Firstname  M.I. ...">
                  </div>
                </div>
                <div class="form-group">                               
                  <label for="inputFullName" class="col-sm-3 control-label">Address</label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control" id="fullname" placeholder="Address ...">
                  </div>
                </div>
                <div class="form-group">                               
                  <label for="inputFullName" class="col-sm-3 control-label">Area</label>
                  <div class="col-sm-8">
                      <select class="form-control select2" style="width: 100%;">
                        <option selected="selected">Dapitan City</option>
                        <option>Dipolog City</option>
                      </select>
                  </div>
                </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">                               
                <label for="inputFullName" class="col-sm-3 control-label">Loan Amount</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="address" placeholder="Amount to loan ...">
                </div>
              </div>
              <div class="form-group">                               
                <label for="inputFullName" class="col-sm-3 control-label">Interest Rate</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="address" placeholder="Interest ...">
                </div>
              </div>
              <div class="form-group">                               
                <label for="inputFullName" class="col-sm-3 control-label">Term</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="address" placeholder="Term ...">
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group">                               
                <label for="inputFullName" class="col-sm-3 control-label">Date Start</label>
                <div class="col-sm-8">
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" id="datepicker">
                  </div>
                </div>
              </div>
              <div class="form-group">                               
                <label for="inputFullName" class="col-sm-3 control-label">Date End</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="address" placeholder="">
                </div>
              </div>
              <div class="form-group">                               
                <label for="inputFullName" class="col-sm-3 control-label">Contact #</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="address" placeholder="Contact number (cp) ...">
                </div>
              </div>
            </div>

          </div>
      
        </div>

      </div>
      <!-- /.box -->
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                <h3 class="box-title">Lender List</h3>

                <div class="box-tools">
                    <ul class="pagination pagination-sm no-margin pull-right">
                        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchprofiles(pagination.prev_page_url)">Previous</a></li>
                        <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>                    
                        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchprofiles(pagination.next_page_url)">Next</a></li>
                    </ul>
                </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                <table class="table">
                    <tr>
                    <th style="width: 30px"># </th>
                    <th style="width: 265px">Full Name</th>
                    <th style="width: 450px">Address</th>
                    <th style="width: 180px">Loan Amount</th>
                    <th style="width: 150px">Interest</th>
                    <th style="width: 100px">Term</th>
                    <!--<th style="width: 300px">Date Start</th>
                    <th style="width: 300px">Date End</th>-->
                    <th style="width: 200px">Contact</th>                    
                    <th style="width: 80px">Action</th>   
                    <th style="width: 80px"></th> 
                    </tr>
                    <tr v-for="profile in profiles" v-bind:key="profile.id">
                        <td>{{ profile.id }}.</td>
                        <td>{{ profile.full_name }}</td>
                        <td>{{ profile.address }}</td>
                        <td>{{ profile.loan }}</td>
                        <td><span class="badge bg-green">{{ profile.interest }}%</span></td>
                        <td>{{ profile.term }}</td>
                        <td>{{ profile.contact }}</td>
                        <td><button @click="addprofile(profile.id)" type="button" class="btn btn-block btn-warning btn-xs">Edit</button></td>
                        <td><button @click="deleteprofile(profile.id)" type="button" class="btn btn-block btn-danger btn-xs">Delete</button></td>
                    </tr>
                </table>
                </div>
                <!-- /.box-body -->
            </div>

            <!-- /.box-body -->
                <div class="box-footer">
                    Showing {{ pagination.total }} records...
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

  created() {
    this.fetchprofiles();
  },

  methods: {
    fetchprofiles(page_url) {
      let vm = this;
      page_url = page_url || 'http://cncs.com/api/profiles';
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
      //this.profile.title = profile.title;
      //this.profile.body = profile.body;
    },
    clearForm() {
      this.edit = false;
      this.profile.id = null;
      this.profile.profile_id = null;
      //this.profile.title = '';
      //this.profile.body = '';
    }
  }
};
</script>
