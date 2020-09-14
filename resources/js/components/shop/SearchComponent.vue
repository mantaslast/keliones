<template>
    <div class="searchbar">
        <input v-model="searchVal" type="text" id="search" class="searchInput">
        <i @click="search($event)" class="fas fa-search mx-2"></i>
        <i @click="listen($event)" class="fas fa-microphone mic mx-2"></i>
    </div>
</template>

<script>
    import {post, get, put} from '../../helpers/requests'
    import {rec} from '../../helpers/recognition'
    export default {
        data : ()=>({
            searchVal : '',
        }),
        methods: {
            search(e) {
                console.log('search')
            },
            listen(e) {
                if (!window.webkitSpeechRecognition) return
                let recognition = rec(e)
                if (!recognition.started) {
                    recognition.start();
                } else {
                    recognition.stop();
                }
            }
        },
        mounted: function() {
            
        }
    }
</script>
