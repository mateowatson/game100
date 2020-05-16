<template>
    <div>
        <form @submit.prevent="addInvitee">
            <label for="invitee">Invite players</label><br>
            <input type="text" id="invitee" name="invitee"
                placeholder="Player username" v-model="invitee">
            <input type="submit" name="submit" value="Invite">
            <div role="alert" v-for="confirmation in confirmations">
                {{ confirmation }}
            </div>
        </form>
        <ul>
            <li v-for="invitees_item in invitees">
                {{invitees_item.name}} - {{invitees_item.accepted ?
                    'joined' :
                    'awaiting response'}}
            </li>
        </ul>
    </div>
</template>

<script>
import axios from 'axios'
export default {
    props: ['urlGameUuid'],

    data() {
        return {
            invitee: '',
            invitees: [],
            confirmations: []
        }
    },

    methods: {
        addInvitee(event) {
            if(!this.invitees.find((invitee) => invitee.name = this.invitee)) {
                this.invitees.push({
                    name: this.invitee,
                    accepted: false
                })
            }
            this.sendInvite(this.invitee)
                .then((response) => {
                    this.confirmations.push(response)
                    setTimeout(this.shiftConfirmations, 3000)
                })
            this.invitee = ''
        },

        async sendInvite(invitee) {
            var formData = new FormData()
            formData.append('csrf', window.appCsrf)
            try {
                let response = await axios.post('/send-game-invite/'+
                    this.urlGameUuid+'/'+invitee, formData)
                return response.data
            } catch (error) {
                return error
            }
        },

        shiftConfirmations() {
            this.confirmations.shift()
        }
    }
}
</script>