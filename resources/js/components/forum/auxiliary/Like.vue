<template>
    <div>
        <v-btn icon @click="like">
            <v-icon :color="color">favorite</v-icon> {{count}}
        </v-btn>
    </div>
</template>

<script>
export default {
    props: ['reply', 'questionSlug'],

    data(){
        return {
            liked: this.reply.liked,
            count: this.reply.likes_count,
        }
    },

    created(){
        Echo.channel('likeChannel')
            .listen('LikeEvent', (e) => {
                if(this.reply.id == e.id){
                    e.type == 1 ? this.count++ : this.count--;
                }
            });
    },

    methods: {

        like(){
            if(!User.signedIn()){
                flash('You need to be authorized to do this action', 'info');
                return;
            }

            this.liked ? this.decr() : this.incr();
            this.liked = !this.liked;
        },

        incr(){
            let url = `/api/questions/${this.questionSlug}/replies/${this.reply.id}/like`;

            axios.post(url)
            .then(() => this.count++);
        },

        decr(){
            let url = `/api/questions/${this.questionSlug}/replies/${this.reply.id}/unlike`;

            axios.delete(url)
            .then(() => this.count--);
        }

    },
    computed: {

        color(){
            return this.liked ? "blue" : 'black';
        }

    }
}
</script>

<style>

</style>
