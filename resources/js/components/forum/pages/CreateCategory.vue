<template>
    <v-container>
        <v-form @submit.prevent="create">

           <v-text-field
            v-model="form.name"
            label="Category name"
            type="text"
            required
            ></v-text-field>

            <div class="error-block" v-if="errors.name">
                <span class="red--text" 
                v-for="(error, index) in errors.name"
                :key="index">{{error}}</span>
            </div>

            <v-btn :disabled="disabled" type="submit" color="teal">Create</v-btn>

        </v-form>

        <v-card class="mt-4">
            <v-toolbar color="cyan" dark>
                <v-toolbar-title>Categories</v-toolbar-title>
            </v-toolbar>
        </v-card>

        <v-list>
            <div v-for="(category, index) in categories" :key="index">

                <v-list-tile v-if="!category.editState">

                        <v-list-tile-action v-if="isAdmin">
                            <v-btn icon small @click="edit(category)">
                                <v-icon>edit</v-icon>
                            </v-btn>
                        </v-list-tile-action>

                        <v-list-tile-content>
                            <v-list-tile-title>
                                {{category.name}}
                            </v-list-tile-title>
                        </v-list-tile-content>

                        <v-list-tile-action v-if="isAdmin">
                            <v-btn icon small @click="destroy(category, index)">
                                <v-icon color="red">delete</v-icon>
                            </v-btn>
                        </v-list-tile-action>

                </v-list-tile>
                <v-list-tile v-else>

                    <v-layout align-center>

                            <v-btn icon small @click="update(category)">
                                <v-icon color="green">save</v-icon>
                            </v-btn>
                       
                            <v-text-field
                            :value="category.name"
                            @change="newName($event, category)"
                            label="Category name"
                            type="text"
                            required
                            ></v-text-field>
                        
                            <v-btn icon small @click="edit(category)">
                                <v-icon color="black">cancel</v-icon>
                            </v-btn>
                        
                    </v-layout>
                    
                </v-list-tile>

            </div>
        </v-list>

    </v-container>
</template>

<script>
export default {
    data(){
        return {
            form: {
                name: null
            },
            categories: [],
            errors: {},
        }
    },

    created(){
        axios.get(this.endpoint)
        .then(res => {
            
            this.categories = res.data.data;

            this.categories.forEach((category) => {
                this.$set(category, 'editState', false);
                this.$set(category, 'newName', '');
            });

        })
        .catch();
    },

    methods:{
        create(){

            if(!User.signedIn()){
                flash('You need to be authorized to do this action', 'info');
                return;
            }

            axios.post(this.endpoint, this.form)
            .then(res => {
                this.categories.unshift(res.data);
                this.form.name = '';
            })
            .catch(error => (this.errors = error.response.data.errors));
        },

        destroy(category, index){
            axios.delete(this.endpoint + `/${category.slug}`)
            .then(res => this.categories.splice(index , 1))
            .catch();
        },

        edit(category){
            this.$set(category, 'editState', !category.editState);
        },

        update(category){
            let formData = category;

            if(category.newName){
                formData.name = category.newName; 
            }

            axios.put(this.endpoint + `/${category.slug}`, formData)
            .then(res => {
                this.$set(category, 'name', res.data.name);
                this.$set(category, 'slug', res.data.slug);
                this.$set(category, 'editState', !category.editState);
            })
            .catch(error => flash(error.message, 'error'));

        },

        newName(newName, category){
            category.newName = newName;
        },

    },

    computed: {
        endpoint(){
            return '/api/categories';
        },

        disabled(){
            return !(this.form.name);
        },

        isAdmin(){
            return !!User.isAdmin();
        }
    }
}
</script>

<style>

</style>
