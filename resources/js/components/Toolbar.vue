<template>
  <v-toolbar>
    <!-- <v-toolbar-side-icon></v-toolbar-side-icon> -->
    <v-toolbar-title>Bitfumes</v-toolbar-title>
    <v-spacer></v-spacer>
    <div class="hidden-sm-and-down">
    
        <router-link
        v-for="(item, index) in items"
        :key="index"
        v-show="item.show"
        :to="{ name: item.routeName, params: {}}">
            <v-btn flat>{{item.title}}</v-btn>
        </router-link>

    </div>
  </v-toolbar>
</template>


<script>
export default {
    data(){
        return {
            items: [
                {'title': 'Forum', routeName: 'forum', show: true},
                {'title': 'Login', routeName: 'login', show: !User.signedIn()},
                {'title': 'Logout', routeName: 'logout', show: User.signedIn()},
                //{'title': 'Ask Question', routeName: 'ask-question', show: User.signedIn},
                //{'title': 'Category', routeName: 'category', show: User.signedIn},
            ]
        }
    },
    created(){
        events.$on('logout', () => {
            User.logout();
            //this.$router.push({'name': 'forum'});
            window.location = '/forum'; //workaround
        });
    }
}
</script>

<style>

</style>
