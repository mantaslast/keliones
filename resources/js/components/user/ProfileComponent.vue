<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form>
                    <div class="form-group">
                        <label for="inputAddress">Adresas</label>
                        <input v-model="phone" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Telefonas</label>
                        <input v-model="address" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress2">Šalis</label>
                        <input v-model="country" type="text" class="form-control">
                    </div>
                    <button @click="submitForm($event)" type="submit" class="btn btn-primary">Sign in</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import {post, get} from '../../helpers/requests'
    export default {
        data : ()=>({
            address : '',
            phone : '',
            country : ''
        }),
        methods: {
            submitForm(event){
                event.preventDefault()
                post('/profile',{
                    address : this.address,
                    phone : this.phone,
                    country : this.country
                })
            }
        },
        mounted: function() {
            get('/profile').then()
        }
    }
</script>
