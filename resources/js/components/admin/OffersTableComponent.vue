<template>
    <div class="base-demo" style="width: 100%; position:relative;">
        <vue-table-dynamic ref="table" :params="params">
            <template v-slot:column-6="{ props }">
                <div class="btn btn-primary" @click="viewOffer(props)" ><i class="far fa-eye"></i></div>
                <div class="btn btn-warning ml-1" @click="editOffer(props)"><i class="fas fa-edit"></i></div>
                <div class="btn btn-danger ml-1" @click.prevent="deleteOffer(props)"><i class="far fa-trash-alt"></i></div>
            </template>
        </vue-table-dynamic>
        <i @click="exportPdf" class="far fa-file-pdf pdfIcon"></i>
        <i @click="exportCsv" class="fas fa-file-csv csvIcon"></i>
    </div>
</template>

<script>
import {formatOffersTableData, formatForCsv, today} from '../../helpers/tablehelpers'
import {deleteRecordConfirm} from '../../helpers/validation'
import {post, getPdf, getCsv} from '../../helpers/requests'
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
                ['Id', 'Pavadinimas', 'Miestas', 'Šalis', 'Kategorija', 'Kaina (€)', 'Veiksmas'],
                ...this.offers.reduce((accumulator, currentValue, currentIndex) => {
                    accumulator[currentIndex] = [currentValue.id, currentValue.name, currentValue.city, currentValue.country, this.categories[currentValue.category_id],currentValue.price ,'']
                    return accumulator
                }, [])
            ],
            header: 'row',
            sort: [0, 1, 2, 3, 4, 5],
            border: true,
            enableSearch: true,
            pagination: true,
            pageSize: 20,
            pageSizes: [20, 50, 100, 500],
            showTotal: true,
            columnWidth: [{column: 0, width: 60}],
        }
    },
    methods : {
        deleteOffer : function (props) {
            let offerId = props.rowData[0].data
            if (deleteRecordConfirm()) {
                post('/admin/offers/destroy',{'id' : offerId}).then(resp=>{
                    if (resp.success) {
                        this.params.data.splice(props.row, 1)
                        this.$notification.success("Pasiūlymas pašalintas sėkmingai", {  timer: 4});
                    } else {
                        this.$notification.error("Įvyko klaida", {  timer: 4});
                    }
                })
            }
        },
        
        editOffer : function (props) {
            let offerId = props.rowData[0].data
            window.location = window.location.origin+'/admin/offers/' + offerId+ '/edit'
        },

        viewOffer : function (props) {
            let offerId = props.rowData[0].data
            window.location = window.location.origin + '/admin/offers/' + offerId
        },

        exportCsv : function () {
            let tableData = this.$refs.table.tableData.activatedRows
            let formattedData = formatOffersTableData(tableData)
            getCsv('pasiulymai_'+today()+'.csv',formatForCsv(formattedData))
        },

        exportPdf : function () {
            let tableData = this.$refs.table.tableData.activatedRows
            let formattedData = formatOffersTableData(tableData)
            this.$notification.dark("Generuojamas pdf...", {  timer: 50});
            getPdf('/admin/offers/generatePdf',{offers: formattedData}).then(resp => {
                let blob = new Blob([resp],{type: 'application/pdf'});
                window.open(URL.createObjectURL(blob));
                this.$notification.removeAll()
            })
        }
    }
}
</script>
