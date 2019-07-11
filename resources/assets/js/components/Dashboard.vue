<template>
  <div>

    <section class="content">              

      <div class="col-md-6">
        <div class="box box-default">

            <div class="box-header with-border">
            <h3 class="box-title">Functions</h3>
            </div>        

            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="small-box bg-yellow">
                            <div class="inner">
                            <h3>New</h3>

                            <p>Registration</p>
                            </div>
                            <div class="icon">
                            <i class="ion ion-person-add"></i>
                            </div>
                            <a href="admin/registration" class="small-box-footer">
                            Add New Entry <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                        <div class="small-box bg-aqua">
                            <div class="inner">                                
                                <p>Customers</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="admin/user-payment" class="small-box-footer">
                            View/Add <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                        <div class="small-box bg-green">
                            <div class="inner">
                            <h3>{{ pagination_profile.total }}</h3>

                            <p>Registered Users</p>
                            </div>
                            <div class="icon">
                            <i class="ion ion-person-add"></i>
                            </div>
                            <a href="admin/registered-users" class="small-box-footer">
                            More info <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>                           
                    </div>
                    <div class="col-sm-6">
                        <div class="small-box bg-red">
                            <div class="inner">
                                <h3>$$</h3>
                                <p>Collector's Quota</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="admin/quota" class="small-box-footer">
                            More info <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>                       
                        <div class="small-box bg-yellow">
                            <div class="inner">
                            <h3>{{ pagination_area.total }}</h3>

                            <p>Areas</p>
                            </div>
                            <div class="icon">
                            <i class="ion ion-person-add"></i>
                            </div>
                            <a href="admin/area" class="small-box-footer">
                            View/Add <i class="fa fa-arrow-circle-right"></i>
                            </a>
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
      areas: [],
      profiles: [],
      area: {
        id: '',
        area_code: '',
        address: '',
        collector: ''
      },
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
      pagination_profile: {},
      pagination_area: {},
      edit: false
    };
  },

  created() {
    this.fetchprofiles();
    this.fetchAreas();
  },

  methods: {

    fetchAreas(page_url) {
      let vm = this;
      page_url = 'http://cn.com/api/areas';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.areas = res.data;
          vm.makeAreaPagination(res.meta, res.links);
        })
        .catch(err => console.log(err));
    },    
    makeAreaPagination(meta, links) {
      let pagination = {
        current_page: meta.current_page,
        last_page: meta.last_page,
        next_page_url: links.next,
        prev_page_url: links.prev,
        per_page: meta.per_page,
        total: meta.total
      };

      this.pagination_area = pagination;
    },

    fetchprofiles(page_url) {
      let vm = this;
      page_url = 'http://cn.com/api/profiles';
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

      this.pagination_profile = pagination;
    },
    addprofile() {
      if (this.edit === false) {
        // Add
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
        // Update
        fetch('http://cn.com/api/profile', {
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
      this.profile.date_from = '';
      this.profile.date_to = '';
      this.profile.contact = ''; 
    }
  }
};
</script>
