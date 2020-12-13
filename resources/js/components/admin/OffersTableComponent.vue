<template>
    <div class="base-demo" style="width: 100%">
        <vue-table-dynamic ref="table" :params="params">
            <template v-slot:column-5="{ props }">
                <div class="btn btn-warning" @click="editOffer(props)">Redaguoti</div>
                <div class="btn btn-danger ml-1" @click.prevent="deleteOffer(props)">Ištrinti</div>
            </template>
        </vue-table-dynamic>
    </div>
</template>

<script>
import {deleteRecordConfirm} from '../../helpers/validation'
import {post} from '../../helpers/requests'
import VueTableDynamic from 'vue-table-dynamic'
export default {
    components: { VueTableDynamic },
    props:['offers'],
    data : function () {
        return {
            categories : {1: 'Poilsinės kelionės', 2 : 'Pažintinės kelionės', 3 : 'Pramoginės kelionės', 4 : 'Egzotinės kelionės'},
            params : {},
        }
    }, 
    mounted : function () {
        this.params = {
            data: [
                ['Id', 'Pavadinimas', 'Miestas', 'Šalis', 'Kategorija', 'Veiksmas'],
                ...this.offers.reduce((accumulator, currentValue, currentIndex) => {
                    accumulator[currentIndex] = [currentValue.id, currentValue.name, currentValue.city, currentValue.country, this.categories[currentValue.category_id], '']
                    return accumulator
                }, [])
            ],
            header: 'row',
            sort: [0, 1, 2, 3, 4],
            border: true,
            enableSearch: true,
            pagination: true,
            pageSize: 20,
            pageSizes: [20, 50, 100, 500]
        }
    },
    methods : {
        deleteOffer : function (props) {
            let offerId = props.rowData[0].data
            if (deleteRecordConfirm()) {
                post('/admin/offers/destroy',{'id' : offerId}).then(resp=>{
                    if (resp.success) {
                        this.params.data.splice(props.row, 1)
                    } else {

                    }
                })
            }
        },
        editOffer : function (props) {
            let offerId = props.rowData[0].data
            window.location = window.location.origin+'/admin/offers/' + offerId+ '/edit'
        }
    }
}
</script>
