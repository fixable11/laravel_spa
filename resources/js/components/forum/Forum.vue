<template>
    <v-container fluid grid-list-md>
        <v-layout row wrap>

            <v-flex xs8>
                <question 
                v-for="(question, index) in questions"
                :key="index"
                :question="question"
                ></question>
            </v-flex>
            <v-flex xs4>
                <sidebar></sidebar>
            </v-flex>

        </v-layout>
    </v-container>
</template>

<script>
import Question from './Question';
import Sidebar from './Sidebar';

export default {
    components: { Question, Sidebar },
    data(){
        return {
            questions: {}
        }
    },
    
    created(){
        axios.get('/api/questions')
        .then(res => this.questions = res.data.data)
        .catch(error => flash('Data fetching error', 'error'));
    }
}
</script>

<style>

</style>
