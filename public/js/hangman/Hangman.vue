<template>
    <div>{{body}}</div>
</template>

<script>
import axios from 'axios'
export default {
    data() {
        return {
            body: 'I am a notification.'
        }
    },

    methods: {
        async getApiState() {
            try {
                const response = await axios.get('/hangman/get-api-state/20200419135821e387fadcca29');
                console.log(response);
            } catch (error) {
                console.error(error);
            }
        }
    },

    created() {
        console.log('eeee');
        this.getApiState();
    }
}
</script>