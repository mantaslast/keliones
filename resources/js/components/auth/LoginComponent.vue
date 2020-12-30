<template>
    <div class="card" ref="login">
        <div class="card-header">
            Prisijungti
            <span @click="close"><i class="fas fa-times"></i></span>
        </div>

        <div class="card-body">
            <form method="POST" id="loginForm">
                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">El. paštas</label>

                    <div class="col-md-6">
                        <input v-model="email" id="email" type="email" class="form-control" name="email" autocomplete="email" autofocus>
                        <!-- <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span> -->
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">Slaptažodis</label>

                    <div class="col-md-6">
                        <input v-model="password" id="password" type="password" class="form-control" name="password" autocomplete="current-password">
                        <!-- <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span> -->
                    </div>
                </div>

                <!-- <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                </div> -->

                <div class="form-group row mb-0">
                    <div class="col-12">
                        <button @click.prevent="login" type="submit" class="btn btn-primary login_submit ml-0 mb-3">
                            Prisijungti
                        </button>
                    </div>
                    <div class="col-12">
                        <a class="" href="/password/reset">
                            Pamiršote slaptažodį?
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import {setCookie} from '../../helpers/cookies' //Cookiu metodai
    import {showErrors, hideAllErrors} from '../../helpers/validation'
    import {post} from '../../helpers/requests'
    export default {
        data : ()=>({
            email : '',
            password : ''
        }),
        methods: {
            login () {
                hideAllErrors('#loginForm')
                post('/login',{email : this.email, password : this.password}, false).then(resp=>{
                    if (resp.errors) {
                        showErrors(resp.errors)
                    } else {
                        setCookie('api_token', resp.data.api_token, 1)
                        location.reload();
                    }
                })
            },
            close(){
                document.querySelector('.body_overlay').style.display = 'none'
                this.$refs.login.style.display = 'none'
            }
        }
    }
</script>
