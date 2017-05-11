<template>
    <span class="reply pull-right"><a href="javascript:;" v-on:click="reply"><i class="fa fa-reply"></i></a></span>
</template>

<script>
    export default {
        props: ['username'],
        methods: {
            reply(){
                $('#editor').focus().val('@' + this.username + ' ');
            }
        }
    }
</script>
