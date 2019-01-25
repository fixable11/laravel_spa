<template>
    <v-flex class="mt-4">
        <markdown-editor v-model="body"></markdown-editor>
        <v-btn @click="submit" color="green">
            Submit
        </v-btn>
    </v-flex>
</template>

<script>
export default {
    props: ['questionSlug'],
    data(){
        return {
            body: '',
        }
    },
    methods: {
        submit(){
            axios.post(this.endpoint, {
                body: this.body
            })
            .then(res => {
                this.body = '';
                events.$emit('newReply', res.data.reply);
            })
            .catch();
        }
    },
    computed:{
        endpoint(){
            return `/api/questions/${this.questionSlug}/replies`;
        }
    }
}
</script>

<style>

</style>
