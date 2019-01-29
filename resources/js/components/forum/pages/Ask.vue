<template>
    <v-container>
        <v-form ref="form" @submit.prevent="askQuestion">

            <v-text-field
            v-model="form.title"
            label="Title"
            type="text"
            required
            ></v-text-field>

            <div class="error-block" v-if="errors.title">
                <span class="red--text" 
                v-for="(error, index) in errors.title"
                :key="index">{{error}}</span>
            </div>

            <v-select
            v-model="form.category_id"
            :items="categories"
            item-text="name"
            item-value="id"
            label="Category"
            ></v-select>

            <div class="error-block" v-if="errors.category_id">
                <span class="red--text" 
                v-for="(error, index) in errors.category_id"
                :key="index">{{error}}</span>
            </div>

            <markdown-editor v-model="form.body"></markdown-editor>

            <div class="error-block" v-if="errors.body">
                <span class="red--text" 
                v-for="(error, index) in errors.body"
                :key="index">{{error}}</span>
            </div>

            <v-btn
            color="green"
            type="submit"
            :disabled="disabled"
            >Ask question</v-btn>

        </v-form>
    </v-container>
</template>

<script>
export default {
    data(){
        return {
            form: {
                title: null,
                category_id: null,
                body: '',
            },
            categories: [],
            errors: {},
        }
    },
    created(){
        axios.get('/api/categories')
        .then(res => this.categories = res.data.data)
        .catch();
    },
    methods: {
        askQuestion(){
            if(!User.signedIn()){
                flash('You need to be authorized to do this action', 'info');
                return;
            }
            axios
            .post("/api/questions", this.form)
            .then(res => this.$router.push(res.data.path))
            .catch(error => (this.errors = error.response.data.errors));
        }
    },
    computed: {
        disabled(){
            return !(this.form.title && this.form.category_id && this.form.body);
        }
    }
}
</script>

<style>

</style>
