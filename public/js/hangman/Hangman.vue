<template>
    <div>
        <pre>{{apiState}}</pre>
    </div>
</template>

<script>
import axios from 'axios'
import urlParse from 'url-parse'

export default {
    data() {
        return {
            apiState: null,
            url: window.location.href
        }
    },

    computed: {
        urlGameUuid() {
            let parts = new urlParse(this.url)
            if(parts.pathname && parts.pathname.split('/').length > 3)
                return parts.pathname.split('/')[3]
            return null
        }
    },

    methods: {
        async getApiState() {
            try {
                let response = await axios.get('/hangman/get-api-state/'+this.urlGameUuid)
                this.apiState = response.data
            } catch (error) {
                return false
            }
        }
    },

    created() {
        this.getApiState()
    }
}
</script>