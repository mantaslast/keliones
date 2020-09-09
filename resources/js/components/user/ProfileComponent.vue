<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form id="profileForm">
                    <div class="form-group">
                        <label for="inputAddress">Adresas</label>
                        <input v-model="address" name="address" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress">Telefonas</label>
                        <input v-model="phone" name="phone" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputAddress2">Šalis</label>
                        <input v-model="country" name="country" type="text" class="form-control">
                    </div>
                    <button @click="submitForm($event)" type="submit" class="btn btn-primary">Išsaugoti</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import {post, get, put} from '../../helpers/requests'
    import {showErrors, hideAllErrors} from '../../helpers/validation'
    export default {
        props: ['userid','profileid'],
        data : ()=>({
            address : '',
            phone : '',
            country : '',
        }),
        methods: {
            submitForm(event){
                event.preventDefault()
                hideAllErrors('#profileForm')
                put('/profile/'+this.profileid,{
                    address : this.address,
                    phone : this.phone,
                    country : this.country
                }).then(resp => {
                    if (resp.errors) {
                        showErrors(resp.errors)
                    } else {
                        
                    }
                })
            }
        },
        mounted: function() {
            get('/profile').then(response => {
                if (response.data) {
                    this.address = response.data.profile.address
                    this.phone = response.data.profile.phone
                    this.country = response.data.profile.country
                    this.userId = response.data.id
                }
            })
        }
    }
</script>
