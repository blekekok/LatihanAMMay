<template>
    <div class="content">
        <h1>Logging out</h1>
    </div>
</template>

<style>
    .content {
        display: flex;
        width: 100%;
        height: 100%;
        justify-content: center;
        align-items: center;
    }
</style>

<script>
    export default {
        async asyncData({ $axios, redirect }) {
            try {
                await $axios.post('/auth/logout');
            } catch (err) {
                console.err(err)
            }

            redirect('/');
        }
    }
</script>
