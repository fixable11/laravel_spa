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

        this.listen();
    },
    computed:{

        body(){
            return md.parse(this.question.body);
        },

        own(){
            return User.signedIn() ? User.own(this.question.user_id) : false;
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
        },

        listen(){
            events.$on('newReply', reply => {
                this.question.replies.push(reply);
                this.question.replies_count++;
            });

            events.$on('deleteReply', data => {

                let url = this.endpoint + '/replies/' + data.reply.id;
                
                axios.delete(url)
                .then(res => {
                    this.question.replies.splice(data.index, 1);
                    this.question.replies_count--;
                })
                .catch();
                
            });

            events.$on('updateReply', data => {

                let url = this.endpoint + '/replies/' + data.reply.id;

                axios.put(url, data.reply)
                .then(res => {
                    this.question.replies[data.replyIndex].body = res.data.reply.body;

                    this.question.replies[data.replyIndex].editState = false;
                })
                .catch();

            });

            if(User.signedIn()){ 
                Echo.private('App.Models.User.' + User.id())
                    .notification((notification) => {
                        this.question.replies.push(notification.reply);
                        this.question.replies_count++;
                    });
            }

            Echo.channel('deleteReplyChannel')
                .listen('DeleteReplyEvent', (e) => {
                    for (let index = 0; index < this.question.replies.length; index++) {
                        if(this.question.replies[index].id == e.id){
                            this.question.replies.splice(index, 1);
                            this.question.replies_count--;
                        }  
                    }
                });

        }
    }
}
</script>

<style>

</style>
