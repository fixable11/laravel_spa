<template>
    <v-container>
        <v-form ref="form" @submit.prevent="askQuestion">

            <v-text-field
            v-model="form.title"
            label="Title"
            type="text"
            required
            ></v-text-field>

            <v-select
            v-model="form.category_id"
            :items="categories"
            item-text="name"
            item-value="id"
            label="Category"
            ></v-select>

            <markdown-editor v-model="form.body"></markdown-editor>

            <v-btn
            color="green"
            type="submit"
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
            axios
            .post("/api/questions", this.form)
            .then(res => this.$router.push(res.data.path))
            .catch(error => (this.errors = error.response.data.errors));
        }
    }
}
</script>

<style>

</style>
