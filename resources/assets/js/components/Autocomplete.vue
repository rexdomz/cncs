<template>
 <div>
  <input type="text" placeholder="Type a customer lastname" v-model="query" v-on:keyup="autoComplete" name="query" class="form-control searchnameinpt">
  <!--<div class="panel-footer" v-if="results.length">
   <ul class="list-group" v-for="profile in profiles" v-bind:key="profile.id">
       <li>{{ profile.full_name}}</li>
   </ul>
  </div>-->
 </div>
</template>
<script>

 export default{
  data(){
   return {
    query: '',
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
        contact: '',
        date_expire: false        
      },            
    results: []
   }
  },
  methods: {
   autoComplete(page_url){
    this.results = [];
    if(this.query.length > 2){     
        var query = this.query
        page_url = `http://cn.com/api/profilesbykeyword/${query}`;
        fetch(page_url)
            .then(res => res.json())
            .then(res => {
            this.profiles = res.data;         
            console.log(this.profiles);    
            })
            .catch(err => console.log('what error?: ' + err));
            
     }
   } //end autocomplete
  }
 }
</script>