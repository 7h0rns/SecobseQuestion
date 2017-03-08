<template>
    <button
            class="btn btn-default fa fa-thumbs-o-up fa-lg"
            v-bind:class="{'btn-primary': voted}"
            v-text="text"
            v-on:click="vote"
    ></button>
</template>

<script>
    export default {
        props:['answer','count'],
        mounted() {
            this.$http.post('http://localhost:8000/api/answer/' + this.answer + '/votes/users').then(response =>{
                this.voted = response.data.voted
            })
        },
        data(){
            return {
                voted:false
            }
        },
        computed:{
            text(){
                return this.count
            }
        },
        methods: {
            vote(){
                this.$http.post('http://localhost:8000/api/answer/vote', {'answer':this.answer}).then(response => {
                    this.voted = response.data.voted;
                    response.data.voted ? this.count ++ : this.count --
                })
            }
        }
    }
</script>
