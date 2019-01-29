<template>
    <v-layout row>
        <v-flex 
        md12 
        v-for="(reply, index) in replies" 
        :key="index"
        class="mt-4">
            <v-card>

                <v-card-title>
                    <div class="title blue--text">{{reply.user}}</div>
                    <div class="ml-2">said {{reply.created_at}}</div>

                    <v-spacer></v-spacer>
                    <like :reply="reply" :question-slug="question.slug"></like>
                </v-card-title>

                <v-divider></v-divider>
                
                <edit-reply 
                :reply="reply" 
                :reply-index="index" 
                @close="editing(reply)" 
                v-if="reply.editState">
                </edit-reply>
                
                <div v-else>
                    <v-card-text v-html="body(reply.body)"></v-card-text>

                    <div v-if="own(reply.user_id)">
                        <v-divider></v-divider>

                        <v-card-actions>
                            <v-layout align-center>
                                <v-btn icon small @click="editing(reply)">
                                    <v-icon>edit</v-icon>
                                </v-btn>
                                <v-btn icon small @click="destroy({index, reply})">
                                    <v-icon color="red">delete</v-icon>
                                </v-btn>
                            </v-layout>
                        </v-card-actions>
                    </div>
                </div>

            </v-card>
        </v-flex>

        <new-reply v-if="signedIn" :question-slug="question.slug"></new-reply>
        <v-flex v-else class="mt-3 subheading">
            <router-link :to="{ name: 'login'}">Login to reply</router-link>
        </v-flex>

    </v-layout>
</template>

<script>
import NewReply from "./NewReply";
import EditReply from "./EditReply";
import Like from "./Like";
export default {
    props: ['question'],
    components: { NewReply, EditReply, Like },
    data(){
        return {
            replies: this.question.replies,
            editState: false,
        }
    },

    created(){
        
    },

    mounted(){
        this.replies.forEach(reply => {
            this.$set(reply, 'editState', false);
        });
    },
    methods: {

        own(id){
            return User.signedIn() ? User.own(id) : false;
        },

        destroy(data){
            events.$emit('deleteReply', data);
        },

        body(body){
            return md.parse(body);
        },

        editing(reply){
            this.$set(reply, 'editState', !reply.editState);
        },

    },
    
    computed:{
        signedIn(){
            return User.signedIn();
        }
    }
}
</script>

<style>

</style>
