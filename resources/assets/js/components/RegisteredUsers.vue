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
                <h5 class="box-title">Filter By:</h5>  
                <div class="col-md-2">
                  <area-list></area-list>
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
                    <th style="width: 235px">Full Name</th>
                    <th style="width: 420px">Address</th>
                    <th style="width: 180px">Loan Amount</th>
                    <th style="width: 100px">Interest</th>
                    <th style="width: 155px">Term</th>
                    <!--<th style="width: 300px">Date Start</th>
                    <th style="width: 300px">Date End</th>-->
                    <th style="width: 200px">Contact</th>                    
                    <th style="width: 80px">Action</th>   
                    <th style="width: 80px"></th> 
                    </tr>
                    <tr v-for="profile in profiles" v-bind:key="profile.id">
                        <!--<td>{{ ctr++ }}</td>-->
                        <td>{{ profile.full_name }}</td>
                        <td>{{ profile.address }}</td>
                        <td><span class="badge bg-green"> {{ profile.loan }} </span></td>
                        <td>{{ profile.interest }}%</td>
                        <td>{{ profile.term }} month(s)</td>
                        <td>{{ profile.contact }}</td>
                        <td><button @click="editprofile(profile)" type="button" class="btn btn-block btn-warning btn-xs">Update</button></td>
                        <td><button @click="deleteprofile(profile.id)" type="button" class="btn btn-block btn-danger btn-xs">Deactivate</button></td>
                        
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
      this.profile.full_name = profile.full_name;
      this.profile.address = profile.address;
      this.profile.area = profile.area;
      this.profile.loan = profile.loan;
      this.profile.interest = profile.interest;
      this.profile.term = profile.term;
      this.profile.date_from = profile.date_from;
      this.profile.date_to = profile.date_to;
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
