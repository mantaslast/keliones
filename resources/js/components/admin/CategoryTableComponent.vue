<template>
    <div class="base-demo" style="width: 100%; position:relative;">
        <vue-table-dynamic ref="table" :params="params">
            <template v-slot:column-2="{ props }">
                <div class="btn btn-primary" @click="viewCategory(props)" ><i class="far fa-eye"></i></div>
                <div class="btn btn-warning ml-1" @click="editCategory(props)"><i class="fas fa-edit"></i></div>
                <div class="btn btn-danger ml-1" @click.prevent="deleteCategory(props)"><i class="far fa-trash-alt"></i></div>
            </template>
        </vue-table-dynamic>
        <i @click="exportPdf" class="far fa-file-pdf pdfIcon"></i>
        <i @click="exportCsv" class="fas fa-file-csv csvIcon"></i>
    </div>
</template>

<script>
import {formatCategoriesTableData, formatForCsv, today} from '../../helpers/tablehelpers'
import {deleteRecordConfirm} from '../../helpers/validation'
import {post, getPdf, getCsv} from '../../helpers/requests'
import VueTableDynamic from 'vue-table-dynamic'
export default {
    components: { VueTableDynamic },
    props:['categories'],
    data : function () {
        return {
            params : {},
        }
    }, 
    mounted : function () {
        this.params = {
            data: [
                ['Id', 'Pavadinimas', 'Veiksmas'],
                ...this.categories.reduce((accumulator, currentValue, currentIndex) => {
                    accumulator[currentIndex] = [currentValue.id, currentValue.name, '']
                    return accumulator
                }, [])
            ],
            header: 'row',
            sort: [0, 1],
            border: true,
            enableSearch: true,
            pagination: true,
            pageSize: 20,
            pageSizes: [20, 50, 100, 500],
            showTotal: true,
            columnWidth: [{column: 0, width: 60}, {column: 2, width: 150}],
        }
    },
    methods : {
        deleteCategory : function (props) {
            let categoryId = props.rowData[0].data
            if (deleteRecordConfirm()) {
                post('/admin/categories/destroy',{'id' : categoryId}).then(resp=>{
                    if (resp.success) {
                        this.params.data.splice(props.row, 1)
                        this.$notification.success("Kategorija pašalinta sėkmingai", {  timer: 4});
                    } else {
                        this.$notification.error("Įvyko klaida", {  timer: 4});
                    }
                })
            }
        },
        
        editCategory : function (props) {
            let categoryId = props.rowData[0].data
            window.location = window.location.origin+'/admin/categories/' + categoryId+ '/edit'
        },

        viewCategory : function (props) {
            let categoryId = props.rowData[0].data
            window.location = window.location.origin + '/admin/categories/' + categoryId
        },

        exportCsv : function () {
            let tableData = this.$refs.table.tableData.activatedRows
            let formattedData = formatCategoriesTableData(tableData)
            getCsv('kategorijos_'+today()+'.csv',formatForCsv(formattedData))
        },

        exportPdf : function () {
            let tableData = this.$refs.table.tableData.activatedRows
            let formattedData = formatCategoriesTableData(tableData)
            this.$notification.dark("Generuojamas pdf...", {  timer: 50});
            getPdf('/admin/categories/generatePdf',{categories: formattedData}).then(resp => {
                let blob = new Blob([resp],{type: 'application/pdf'});
                window.open(URL.createObjectURL(blob));
                this.$notification.removeAll()
            })
        }
    }
}
</script>
