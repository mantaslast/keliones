<template>
    <div @click="getOrderPdf" class="statusIcon_pdf">
        <i class="far fa-file-pdf "></i>
    </div>
</template>

<script>
    import {getPdf} from '../../helpers/requests'
    export default {
        props: ['orderid'],
        data : ()=>({
            
        }),
        methods: {
            getOrderPdf : function () {
                getPdf('/orders/generateInvoice',{orderid: this.orderid}).then(resp => {
                    let blob = new Blob([resp],{type: 'application/pdf'});
                    window.open(URL.createObjectURL(blob));
                    // this.$notification.removeAll()
                })
            }
        }
    }
</script>
<style lang="scss">

</style>