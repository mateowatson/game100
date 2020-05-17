<template>
    <div>
        <InvitePlayers :url-game-uuid="urlGameUuid"
            :api-state="apiState"
            v-if="apiState && apiState.game_state"
            @get-api-state="getApiState" />
        <pre>{{apiState}}</pre>
    </div>
</template>

<script>
import axios from 'axios'
import urlParse from 'url-parse'
import InvitePlayers from './InvitePlayers.vue'

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
                let response = await axios.get('/hangman/get-api-state/'+
                    this.urlGameUuid)
                this.apiState = response.data
            } catch (error) {
                return false
            }
        }
    },

    created() {
        this.getApiState()
    },

    components: { InvitePlayers },
}
</script>