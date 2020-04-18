import Vue from 'vue'
import Hangman from './Hangman.vue'

new Vue({
    el: '#hangmanapp',
    components: { Hangman },
    template: '<Hangman />'
});