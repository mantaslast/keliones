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
        props: ['userid'],
        data : ()=>({
            address : '',
            phone : '',
            country : '',
        }),
        methods: {
            submitForm(event){
                event.preventDefault()
                hideAllErrors('#profileForm')
                put('/profile/'+this.userid,{
                    address : this.address,
                    phone : this.phone,
                    country : this.country
                }).then(resp => {
                    if (resp.errors) {
                        showErrors(resp.errors)
                    } else {
                        document.getElementById('msg').innerText = 'Sėkmingai išsaugota profilio informacija'
                        document.getElementById('parentmsg').style.display = 'block'
                        setTimeout(() => {
                            document.getElementById('parentmsg').style.display = 'none'
                        }, 4000);
                    }
                })
            }
        },
        mounted: function() {
            get('/profile').then(response => {
                if (response.data) {
                    this.address = response.data.address
                    this.phone = response.data.phone
                    this.country = response.data.country
                    this.userId = response.data.id
                }
            })
        }
    }
</script>
