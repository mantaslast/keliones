<template>
    <div>
        <star-rating @rating-selected="setRating" :star-size="20" v-model="userrating"></star-rating>
    </div>
</template>

<script>
    import StarRating from 'vue-star-rating'
    import {post} from '../../helpers/requests'
    export default {
        components : {StarRating},
        props: {
            userrating:{
                default:0
            },
            offer: 0
        },

        methods: {
            setRating () {
                post('/rating', {
                    rating : this.userrating,
                    offer : this.offer
                })
            },
        },
    }
</script>
