<template>
  <div>
    
    <!--<form @submit.prevent="addarea" class="mb-3">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Title" v-model="area.title">
      </div>
      <div class="form-group">
        <textarea class="form-control" placeholder="Body" v-model="area.body"></textarea>
      </div>
      <button type="submit" class="btn btn-light btn-block">Save</button>
    </form>
    <button @click="clearForm()" class="btn btn-danger btn-block">Cancel</button>-->

    <section class="content">
        
      <div class="col-md-9">
        <div class="box box-default">

            <div class="box-header with-border">
            <h3 class="box-title">Area Registration</h3>
            </div>        

            <!-- /.box-header -->
            <div class="box-body">
            <div class="row">
                <form @submit.prevent="addarea" class="mb-4">
                
                <div class="form-group">                               
                <label for="inputFullName" class="col-sm-3 control-label">Area Code</label>
                <div style="margin-bottom: 10px;" class="col-sm-8">
                    <input type="text" class="form-control" id="area_code" v-model="area.area_code" placeholder="Type code e,g. a1, a2, a3 ...">
                </div>
                </div>

                <div class="form-group">                               
                <label for="inputFullName" class="col-sm-3 control-label">Address</label>
                <div style="margin-bottom: 10px;" class="col-sm-8">
                    <input type="text" class="form-control" id="address" v-model="area.address" placeholder="Type area location ...">
                </div>
                </div>

                <div class="form-group">                               
                <label for="inputFullName" class="col-sm-3 control-label">Collector's Name</label>
                <div style="margin-bottom: 10px;" class="col-sm-8">
                    <input type="text" class="form-control" id="collector" v-model="area.collector" placeholder="Type assigned collector's name ...">
                </div>
                </div>

                <div class="form-group">                               
                    <label for="inputFullName" class="col-sm-3 control-label">Contact #</label>
                    <div style="margin-bottom: 10px;" class="col-sm-8">
                        <input type="text" class="form-control" id="contact" v-model="area.contact" placeholder="Contact number (cp) ...">
                    </div>
                </div>

                <div style="margin-bottom: 1.5" class="form-group">                               
                    <div class="col-sm-3">&nbsp;</div>  
                    <div style="margin-bottom: 10px;" class="col-sm-8">                    
                        <button type="submit" class="btn btn-primary btn-block">Save</button>                                        
                        <button @click="clearForm()" class="btn btn-warning btn-block">Clear</button>                              
                    </div>
                </div>   

                </form>                                                            
            </div>
            <div style="margin-top: 2em" class="row">
                <div class="box-tools">
                    <ul class="pagination pagination-sm no-margin pull-right">
                        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchareas(pagination.prev_page_url)">Previous</a></li>
                        <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>                    
                        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchareas(pagination.next_page_url)">Next</a></li>
                    </ul>
                </div>
                <table class="table">
                    <tr>                    
                    <th style="width: 235px">Area Code</th>
                    <th style="width: 420px">Address</th>
                    <th style="width: 180px">Collector</th>                 
                    <th style="width: 200px">Contact</th>                    
                    <th style="width: 80px">Action</th>   
                    <th style="width: 80px"></th> 
                    </tr>
                    <tr v-for="area in areas" v-bind:key="area.id">                        
                        <td>{{ area.area_code }}</td>
                        <td>{{ area.address }}</td>
                        <td>{{ area.collector }} </td>
                        <td>{{ area.contact }}</td>                        
                        <td><button @click="editarea(area)" type="button" class="btn btn-block btn-warning btn-xs">Update</button></td>
                        <!--<td><button @click="deletearea(area.id)" type="button" class="btn btn-block btn-danger btn-xs">Deactivate</button></td>-->                        
                    </tr>
                </table>
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
                    <div class="col-sm-6">                                                
                        <div class="small-box bg-yellow">
                            <div class="inner">
                            <h3>{{ pagination.total }}</h3>

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
      areas: [],      
      area: {        
        id: '',
        area_code: '',
        address: '',
        collector: '',
        contact: ''
      },
      area_id: '',
      pagination: {},
      edit: false
    };
  },

  created() {
    this.fetchareas();
  },

  methods: {
    fetchareas(page_url) {
      let vm = this;
      page_url = 'http://cn.com/api/areas';
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.areas = res.data;
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
    addarea() {
      console.log(JSON.stringify(this.area))
      if (this.edit === false) {
        // Add
        fetch('http://cn.com/api/area', {
          method: 'post',
          body: JSON.stringify(this.area),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())          
          .then(data => {
            console.log(data);
            this.clearForm();
            alert('area Added');
            this.fetchareas();
          })
          .catch(err => console.log(err));
      } else {
        // Update

        fetch('http://cn.com/api/area', {
          method: 'put',
          body: JSON.stringify(this.area),
          headers: {
            'content-type': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            this.clearForm();
            alert('area Updated');
            this.fetchareas();
          })
          .catch(err => console.log(err));
      }
    },
    editarea(area) {
      this.edit = true;
      this.area.id = area.id;
      this.area.area_id = area.id;
      this.area.area_code = area.area_code;
      this.area.address = area.address;      
      this.area.collector = area.collector;
      this.area.contact = area.contact;              
    },
    clearForm() {
      this.edit = false;        
      this.area.id = null;
      this.area.area_id = null;
      this.area.area_code = '';
      this.area.address = '';
      this.area.collector = '';      
      this.area.contact = ''; 
    }
  }
};
</script>
