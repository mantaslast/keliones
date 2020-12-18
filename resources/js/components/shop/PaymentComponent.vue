<template>
    <div class="paymentModal" style="display:none;">
        <form 
            ref="form"
            role="form" 
            :action="this.postroute" 
            method="post" 
            class="require-validation"
            data-cc-on-file="false"
            :data-stripe-publishable-key="this.stripekey"
            id="payment-form">
            <input type="hidden" name="_token" :value="this.csrf">
            <input type="hidden" name="orderid" :value="this.orderid">
            <div onclick="paymentModalHide()" class="closePaymentsModal">
                <i class="fas fa-times"></i>
            </div>
            <div style="display:none;" ref="paymentError" class="form-row row paymentModal_err">
                Neteisingai įvesti duomenys
            </div>
            <div class='form-row row'>
                <div class='col-12 form-group required'>
                    <label class='control-label'>Vardas, pavardė</label> 
                    <input ref="fullname" class='form-control card-holder' type='text' v-model="fullname">
                </div>
            </div>
            
            <div class='form-row row'>
                <div class='col-12 form-group required'>
                    <label class='control-label'>Kortelės numeris</label>
                    <input ref="cardnumber" autocomplete='off' class='form-control card-number' v-model="cardnumber" type='text' v-cardformat:formatCardNumber >
                </div>
            </div>

            <div class='form-row row'>
                <div class='col-12 form-group cvc required'>
                    <label class='control-label'>CVV</label>
                    <input ref="cardcvv" autocomplete='off' class='form-control card-cvc' v-model="cardcvv" placeholder='pvz.: 123' type='text' v-cardformat:formatCardCVC>
                </div>
            </div>
            <div class='form-row row'>
                <div class='col-12 form-group expiration required'>
                    <label class='control-label'>Galiojimas</label>
                    <input ref="cardexp" class='form-control card-expiry-month' v-model="cardexp" placeholder='01/2020' type='text' v-cardformat:formatCardExpiry>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button @click.prevent="submitPayment($event)" ref="subBtn" class="btn btn-primary btn-lg btn-block mx-0" type="submit">Apmokėti ({{ this.orderprice }}&euro;)</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        props: ['stripekey', 'postroute', 'orderprice', 'csrf', 'orderid'],
        data : ()=>({
            fullname: '',
            cardexp: '',
            cardcvv: '',
            cardnumber: '',
            errors: {}
        }),
        methods: {
            submitPayment(e) {
                let regName = /^[a-zA-Z]{2,40}( [a-zA-Z]{2,40})+$/;
                if(!regName.test(this.fullname.trim())){
                    this.$refs.fullname.classList.add('is-invalid')
                    this.errors['fullname'] = true
                }else{
                    this.$refs.fullname.classList.remove('is-invalid')
                    this.errors['fullname'] = false
                }

                if(this.cardcvv.length >= 3) {
                    this.$refs.cardcvv.classList.remove('is-invalid')
                    this.errors['cardcvv'] = false
                } else {
                    this.$refs.cardcvv.classList.add('is-invalid')
                    this.errors['cardcvv'] = true
                }
                
                if(this.cardnumber.length < 16 || this.cardnumber.length > 20) {
                    this.$refs.cardnumber.classList.add('is-invalid')
                    this.errors['cardnumber'] = true
                } else {
                    this.$refs.cardnumber.classList.remove('is-invalid')
                    this.errors['cardnumber'] = false
                }

                 if(this.cardexp.length !== 9) {
                    this.$refs.cardexp.classList.add('is-invalid')
                    this.errors['cardexp'] = true
                } else {
                    this.$refs.cardexp.classList.remove('is-invalid')
                    this.errors['cardexp'] = false
                }

                if (this.errors['fullname'] == true || this.errors['cardnumber'] == true || this.errors['cardcvv'] == true || this.errors['cardexp'] == true) {
                    this.$refs.paymentError.style.display = 'block'
                } else {
                    this.$refs.paymentError.style.display = 'none'
                    Stripe.setPublishableKey(this.stripekey);
                    Stripe.createToken({
                        number: this.cardnumber.replace(/ /g,""),
                        cvc: this.cardcvv,
                        exp_month: this.cardexp.split('/')[0].trim(),
                        exp_year: this.cardexp.split('/')[1].trim()
                    }, (status, response) => {
                        if (response.error) {
                            alert('Įvyko klaida')
                        } else {
                            /* token contains id, last4, and card type */
                            let token = response['id'];
                            let form = this.$refs.form
                            form.innerHTML += "<input type='hidden' name='stripeToken' value='" + token + "'/>";
                            form.submit()

                            // $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                            // $form.get(0).submit();
                        }
                    });
                }
            }
        },
        mounted(){
        }
    }
</script>
<style lang="scss">

</style>