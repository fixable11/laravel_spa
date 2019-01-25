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
                </v-card-title>

                <v-divider></v-divider>

                <v-card-text v-html="reply.body"></v-card-text>

                <div v-if="own(reply.user_id)">
                    <v-divider></v-divider>

                    <v-card-actions>
                        <v-layout>
                            <v-btn icon small>
                                <v-icon>edit</v-icon>
                            </v-btn>
                            <v-btn icon small>
                                <v-icon color="red">delete</v-icon>
                            </v-btn>
                        </v-layout>
                    </v-card-actions>
                </div>

            </v-card>
        </v-flex>

        <new-reply :question-slug="question.slug"></new-reply>

    </v-layout>
</template>

<script>
import NewReply from "./NewReply";
export default {
    props: ['question'],
    components: { NewReply },
    data(){
        return {
           replies: this.question.replies
        }
    },
    methods: {

        own(id){
            return User.own(id);
        }

    },
    
    computed:{
        
    }
}
</script>

<style>

</style>
