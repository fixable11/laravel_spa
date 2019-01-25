<template>
    <v-container v-if="question.ready">
        <v-layout row>
            <v-flex xs12 v-if="!editState">
                <v-card>

                    <v-card-title>
                        <div>
                            <div class="headline">
                                {{question.title}}
                            </div>
                            <span class="grey--text">{{question.user}} said {{question.created_at}}</span>
                        </div>
                        <v-spacer></v-spacer>
                        <v-btn class="teal" dark>{{question.replies_count}} Replies</v-btn>
                    </v-card-title>

                    <v-card-text v-html="body"></v-card-text>
                    <v-card-actions v-if="own">
                        <v-btn icon @click="editing">
                            <v-icon>edit</v-icon>
                        </v-btn>
                        <v-btn icon @click="destroy">
                            <v-icon color="red">delete</v-icon>
                        </v-btn>
                    </v-card-actions>

                </v-card>
            </v-flex>
            <v-flex xs12 v-else>
                <v-card>

                    <v-form ref="form" @submit.prevent="update">

                        <v-text-field
                        v-model="form.title"
                        label="Title"
                        type="text"
                        required
                        ></v-text-field>

                        <markdown-editor v-model="form.body"></markdown-editor>

                        <v-card-actions v-if="own">
                            <v-btn icon type="submit">
                                <v-icon color="green">save</v-icon>
                            </v-btn>
                            <v-btn icon @click="editing">
                                <v-icon color="black">cancel</v-icon>
                            </v-btn>
                        </v-card-actions>

                    </v-form>

                </v-card>
            </v-flex>

        </v-layout>

        <replies :question="question"></replies>

    </v-container>
</template>

<script>
import Replies from "../auxiliary/Replies.vue";

export default {
    components: { Replies },
    data(){
        return {
            question: {
                ready: false,
            },
            editState: false,
            form: {
                title: null,
                body: null
            }
        }
    },
    created(){
        this.fetchQuestion();

        events.$on('newReply', reply => {
            this.question.replies.push(reply);
        });
    },
    computed:{

        body(){
            return md.parse(this.question.body);
        },

        own(){
            return User.own(this.question.user_id);
        },

        endpoint(){
            return `/api/questions/${this.$route.params.slug}`;
        },
        
    },
    methods: {

        destroy(){
            axios.delete(this.endpoint)
            .then(res => this.$router.push('/forum'))
            .catch(error => flash('Error deleting question', 'error'))
        },

        editing(){
            this.editState = !this.editState;
        },

        update(){
            axios.put(this.endpoint, this.form)
            .then(res => {
                this.editing();

                this.question.title = this.form.title;
                this.question.body = this.form.body;
            })
            .catch(error => flash('Error updating question', 'error'))
        },

        fetchQuestion(){
             axios.get(this.endpoint)
            .then(res => {
                this.question = res.data.data;
                this.question.ready = true;

                this.form.title = res.data.data.title;
                this.form.body = res.data.data.body;
            })
            .catch(error => flash('Error loading question', 'error'));
        }
    }
}
</script>

<style>

</style>
