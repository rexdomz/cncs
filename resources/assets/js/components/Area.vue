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
            <h3 class="box-title">Area Registration</h3>
            </div>        

            <!-- /.box-header -->
            <div class="box-body">
            <div class="row">
                
                <div class="form-group">                               
                <label for="inputFullName" class="col-sm-3 control-label">Area Code</label>
                <div style="margin-bottom: 10px;" class="col-sm-8">
                    <input type="text" class="form-control" id="areacode" v-model="profile.full_name" placeholder="Type code e,g. a1, a2, a3 ...">
                </div>
                </div>

                <div class="form-group">                               
                <label for="inputFullName" class="col-sm-3 control-label">Address</label>
                <div style="margin-bottom: 10px;" class="col-sm-8">
                    <input type="text" class="form-control" id="areaaddress" v-model="profile.address" placeholder="Type area location ...">
                </div>
                </div>

                <div class="form-group">                               
                <label for="inputFullName" class="col-sm-3 control-label">Collector's Name</label>
                <div style="margin-bottom: 10px;" class="col-sm-8">
                    <input type="text" class="form-control" id="collectorname" v-model="profile.full_name" placeholder="Type assigned collector's name ...">
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
                        <div class="small-box bg-yellow">
                            <div class="inner">
                            <h3>44</h3>

                            <p>Areas</p>
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
