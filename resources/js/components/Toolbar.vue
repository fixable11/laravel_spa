<template>
  <v-toolbar>
   
    <v-menu class="hidden-md-and-up">

        <v-toolbar-side-icon slot="activator"></v-toolbar-side-icon>
        
        <v-list>
            <v-list-tile v-for="(item, index) in items" :key="index" v-show="item.show">
                <v-list-tile-content>
                    <router-link :to="{ name: item.routeName, params: {}}">
                        <v-btn flat>{{item.title}}</v-btn>
                    </router-link>
                </v-list-tile-content>
            </v-list-tile>
        </v-list>

    </v-menu>

    <v-toolbar-title>Bitfumes</v-toolbar-title>

    <v-spacer></v-spacer>

    <app-notification v-if="signedIn"></app-notification>


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
import AppNotification from "./forum/auxiliary/AppNotification";
export default {
    components: { AppNotification },
    data(){
        return {
            signedIn: User.signedIn(),
            items: [
                {'title': 'Forum', routeName: 'forum', show: true},
                {'title': 'Ask Question', routeName: 'ask', show: User.signedIn},
                {'title': 'Create Category', routeName: 'categories.create', show: User.signedIn},
                {'title': 'Login', routeName: 'login', show: !User.signedIn()},
                {'title': 'Logout', routeName: 'logout', show: User.signedIn()},    
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
