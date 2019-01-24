<template>
    <v-container>
        <v-form ref="form" @submit.prevent="login($event)">
            <v-text-field
            v-model="form.email"
            label="Email"
            type="email"
            required
            ></v-text-field>

            <v-text-field
            v-model="form.password"
            label="Password"
            type="password"
            required
            ></v-text-field>

            <v-btn
            color="green"
            type="submit"
            >Login</v-btn>

            <router-link :to="{ name: 'signup', params: {}}">
                <v-btn color="blue">Sign up</v-btn>
            </router-link>

        </v-form>
    </v-container>
</template>

<script>
export default {
    data(){
        return {
            form: {
                email: null,
                password: null,
            },
        }
    },
    created(){
        if(User.signedIn()){
            this.$router.push({'name': 'forum'});
        }
    },
    methods: {
        login(event){
            axios.post('/api/auth/login', this.form)
            .then((res) => {
                User.responseAfterLogin(res);
                //this.$router.push({'name': 'forum'});
                window.location = '/forum'; //workaround
            })
            .catch(error => flash(error.response.data.error, 'error'));
        }
    }
}
</script>

<style>

</style>
