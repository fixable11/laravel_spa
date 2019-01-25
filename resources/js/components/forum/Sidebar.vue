<template>
    <v-card class="mt-3">

         <v-toolbar color="cyan" dark>
            <v-toolbar-title>Categories</v-toolbar-title>
        </v-toolbar>

          <v-list>
              <v-list-tile v-for="category in categories" :key="category.id">
                  <v-list-tile-content>
                      <v-list-tile-title>
                          {{category.name}}
                      </v-list-tile-title>
                  </v-list-tile-content>
              </v-list-tile>
          </v-list>

        
    </v-card>
</template>

<script>
export default {
    data(){
        return {
            categories: {}
        }
    },
    
    created(){
        axios.get(this.endpoint)
        .then(res => this.categories = res.data.data)
        .catch();
    },

    methods: {

    },

    computed: {
        endpoint(){
            return `/api/categories`;
        }
    }
}
</script>

<style>

</style>
