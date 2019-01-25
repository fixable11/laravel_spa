<template>
    <v-card v-if="question.ready">
        <v-container fluid>
            <v-card-title>
                <div>
                    <div class="headline">
                        {{question.title}}
                    </div>
                    <span class="grey--text">{{question.user}} said {{question.created_at}}</span>
                </div>
                <v-spacer></v-spacer>
                <v-btn class="teal">5 Replies</v-btn>
            </v-card-title>

            <v-card-text v-html="body"></v-card-text>
            <v-card-actions v-if="own">
                <v-btn icon>
                    <v-icon>edit</v-icon>
                </v-btn>
                <v-btn icon @click="destroy">
                    <v-icon color="red">delete</v-icon>
                </v-btn>
            </v-card-actions>

        </v-container>
    </v-card>
</template>

<script>
export default {
    data(){
        return {
            question: {
                ready: false,
            },
        }
    },
    created(){
        axios.get(`/api/questions/${this.$route.params.slug}`)
        .then(res => {
            this.question = res.data.data;
            this.question.ready = true;
        })
        .catch(error => flash('Error loading question', 'error'));
    },
    computed:{
        body(){
            return md.parse(this.question.body);
        },
        own(){
            return User.own(this.question.user_id);
        }
    },
    methods: {
        destroy(){
            axios.delete(`/api/questions/${this.question.slug}`)
            .then(res => this.$router.push('/forum'))
            .catch(error => flash('Error deleting question', 'error'))
        }
    }
}
</script>

<style>

</style>
