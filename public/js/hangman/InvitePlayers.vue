<template>
    <div>
        <form @submit.prevent="addInvitee">
            <label for="invitee">Invite players</label><br>
            <input type="text" id="invitee" name="invitee"
                placeholder="Player username" v-model="invitee">
            <input type="submit" name="submit" value="Invite"
                :disabled="!this.invitee">
            <div role="alert" v-for="confirmation in confirmations">
                {{ confirmation }}
            </div>
            <div role="alert" v-for="error in errors">
                {{ error }}
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
            confirmations: [],
            errors: []
        }
    },

    methods: {
        addInvitee() {
            var isInvited = this.invitees
                .find((invitee) => invitee.name === this.invitee)
            if(isInvited) {
                this.errors.push(this.invitee+' has already been invited.')
                setTimeout(this.shiftErrors, 3000)
                return;
            }

            this.sendInvite(this.invitee)
                .then((response) => {
                    if(response.success) {
                        this.confirmations.push('Invitation sent.')
                        this.invitees.push({
                            name: this.invitee,
                            accepted: false
                        })
                        this.invitee = ''
                        this.$emit('get-api-state')
                        setTimeout(this.shiftConfirmations, 3000)
                    } else {
                        this.errors.push('The request failed.')
                        this.invitee = ''
                        setTimeout(this.shiftErrors, 3000)
                    }
                })
        },

        async sendInvite(invitee) {
            var formData = new FormData()
            formData.append('csrf', window.appCsrf)
            try {
                let response = await axios.post('/hangman/send-game-invite/'+
                    this.urlGameUuid+'/'+invitee, formData)
                return response.data
            } catch (error) {
                return false
            }
        },

        shiftConfirmations() {
            this.confirmations.shift()
        },

        shiftErrors() {
            this.errors.shift()
        },
    }
}
</script>