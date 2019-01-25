<template>
    <div>
        <markdown-editor v-model="body"></markdown-editor>

        <v-card-actions>
            <v-layout>
                <v-btn icon small @click="update({replyIndex, reply})">
                    <v-icon color="green">save</v-icon>
                </v-btn>
                <v-btn icon small @click="close">
                    <v-icon>close</v-icon>
                </v-btn>
            </v-layout>
        </v-card-actions>
    </div>
</template>

<script>
export default {
    props: ['replyIndex', 'reply'],
    data(){
        return {
            body: '',
        }
    },

    created(){
        this.body = this.reply.body;
    },

    methods: {
        close(){
            this.$emit('close');
        },
        update(data){
            let formData = data;
            formData.reply.body = this.body;

            events.$emit('updateReply', formData);
        }
    }
}
</script>

<style>
    .markdown-editor .CodeMirror, .markdown-editor .CodeMirror-scroll {
        min-height: 100px;
    }
</style>
