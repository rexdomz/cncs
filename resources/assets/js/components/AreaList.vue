<template>
    <div style="margin-bottom: 1em;">
        <select id="area" name="area" class="form-control select2" style="width: 100%;">
            <option value="0" selected="selected">Select Area ...</option>        
            <option v-for="area in areas" :value="area.id" v-bind:key="area.id">{{ area.area_code }}, {{ area.address }}</option>
        </select>
    </div>
</template>

<!-- https://vuejs.org/v2/guide/forms.html -->

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
                }
            };
         },

        created() {
            this.fetchAreas();
        },

        methods: {
            fetchAreas(page_url) {            
                page_url = page_url || 'api/areas';
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                    this.areas = res.data;            
                    })
                    .catch(err => console.log(err));
            }
        }
    }
</script>