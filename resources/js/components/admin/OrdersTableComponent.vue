<template>
    <div class="base-demo" style="width: 100%; position:relative;">
        <vue-table-dynamic ref="table" :params="params">
            <template v-slot:column-2="{ props }">
                <span v-html="renderStatus(props)"></span>
            </template>
            <template v-slot:column-6="{ props }">
                <div class="btn btn-primary" @click="viewOrder(props)" ><i class="far fa-eye"></i></div>
                
            </template>
        </vue-table-dynamic>
        <i @click="exportPdf" class="far fa-file-pdf pdfIcon"></i>
        <i @click="exportCsv" class="fas fa-file-csv csvIcon"></i>
    </div>
</template>

<script>
import {formatOrdersTableData, formatForCsv, today} from '../../helpers/tablehelpers'
import {deleteRecordConfirm} from '../../helpers/validation'
import {post, getPdf, getCsv} from '../../helpers/requests'
import VueTableDynamic from 'vue-table-dynamic'
export default {
    components: { VueTableDynamic },
    props:['orders'],
    data : function () {
        return {
            params : {},
        }
    }, 
    mounted : function () {
        this.params = {
            data: [
                ['Id','Raktas', 'Būsena', 'El. paštas', 'Kelionės pavadinimas', 'Kaina (€)', 'Veiksmas'],
                ...this.orders.reduce((accumulator, currentValue, currentIndex) => {
                    accumulator[currentIndex] = [currentValue.id, currentValue.key, currentValue.status, currentValue.email, currentValue.offer.name, currentValue.offer.price,'']
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
            columnWidth: [{column: 0, width: 40}, {column: 1, width: 200}, {column: 2, width: 100},{column: 5, width: 100}, {column: 6, width: 60}],
        }
    },
    methods : {
        viewOrder : function (props) {
            let orderId = props.rowData[0].data
            window.location = window.location.origin + '/admin/orders/' + orderId
        },
        
        renderStatus: function (prop) {
            let status = prop.cellData
            if ( status == 0) {
                return '<div style="color:#ffbf00;">Inicijuotas</div>'
            } else if (status == 1) {
                return '<div style="color:red;">Atšauktas</div>'
            } else if (status == 2) {
                return '<div style="color:#21A226;">Apmokėtas</div>'
            } else if (status == 3) {
                return '<div style="color:green;">Įvykęs</div>'
            }
        },

        exportCsv : function () {
            let tableData = this.$refs.table.tableData.activatedRows
            let formattedData = formatOrdersTableData(tableData)
            getCsv('uzsakymai_'+today()+'.csv',formatForCsv(formattedData))
        },

        exportPdf : function () {
            let tableData = this.$refs.table.tableData.activatedRows
            let formattedData = formatOrdersTableData(tableData)
            this.$notification.dark("Generuojamas pdf...", {  timer: 50});
            getPdf('/admin/orders/generatePdf',{orders: formattedData}).then(resp => {
                let blob = new Blob([resp],{type: 'application/pdf'});
                window.open(URL.createObjectURL(blob));
                this.$notification.removeAll()
            })
        }
    }
}
</script>
