<template>
    <div class="base-demo" style="width: 100%; position:relative;">
        <vue-table-dynamic ref="table" :params="params">
            <template v-slot:column-3="{ props }">
                <span v-html="renderStatus(props)"></span>
            </template>
            <template v-slot:column-4="{ props }">
                <div class="btn btn-primary" @click="viewUser(props)" ><i class="far fa-eye"></i></div>
                <div class="btn btn-warning ml-1" @click="editUser(props)"><i class="fas fa-edit"></i></div>
                <div class="btn btn-danger ml-1" @click.prevent="deleteUser(props)"><i class="far fa-trash-alt"></i></div>
            </template>
        </vue-table-dynamic>
        <i @click="exportPdf" class="far fa-file-pdf pdfIcon"></i>
        <i @click="exportCsv" class="fas fa-file-csv csvIcon"></i>
    </div>
</template>

<script>
import {formatUsersTableData, formatForCsv, today} from '../../helpers/tablehelpers'
import {deleteRecordConfirm} from '../../helpers/validation'
import {post, getPdf, getCsv} from '../../helpers/requests'
import VueTableDynamic from 'vue-table-dynamic'
export default {
    components: { VueTableDynamic },
    props:['users'],
    data : function () {
        return {
            params : {},
        }
    }, 
    mounted : function () {
        this.params = {
            data: [
                ['Id', 'Vardas', 'El. paštas', 'Rolė', 'Veiksmas'],
                ...this.users.reduce((accumulator, currentValue, currentIndex) => {
                    accumulator[currentIndex] = [currentValue.id, currentValue.name, currentValue.email, currentValue.role,'']
                    return accumulator
                }, [])
            ],
            header: 'row',
            sort: [0, 1, 2, 3],
            border: true,
            enableSearch: true,
            pagination: true,
            pageSize: 20,
            pageSizes: [20, 50, 100, 500],
            showTotal: true,
            columnWidth: [{column: 0, width: 60}, {column: 4, width: 150}],
        }
    },
    methods : {
        deleteUser : function (props) {
            let userId = props.rowData[0].data
            if (deleteRecordConfirm()) {
                post('/admin/users/destroy',{'id' : userId}).then(resp=>{
                    if (resp.success) {
                        this.params.data.splice(props.row, 1)
                        this.$notification.success("Vartotojas pašalintas sėkmingai", {  timer: 4});
                    } else {
                        this.$notification.error("Įvyko klaida", {  timer: 4});
                    }
                })
            }
        },
        
        editUser : function (props) {
            let userId = props.rowData[0].data
            window.location = window.location.origin+'/admin/users/' + userId+ '/edit'
        },

        viewUser : function (props) {
            let userId = props.rowData[0].data
            window.location = window.location.origin + '/admin/users/' + userId
        },

        renderStatus: function (prop) {
            let role = prop.cellData
            if ( role == 1) {
                return '<div>Klientas</div>'
            } else if (role == 2) {
                return '<div>Administratorius</div>'
            } else if (role == 3) {
                return '<div>Super-administratorius</div>'
            }
        },

        exportCsv : function () {
            let tableData = this.$refs.table.tableData.activatedRows
            let formattedData = formatUsersTableData(tableData)
            getCsv('vartotojai_'+today()+'.csv',formatForCsv(formattedData))
        },

        exportPdf : function () {
            let tableData = this.$refs.table.tableData.activatedRows
            let formattedData = formatUsersTableData(tableData)
            this.$notification.dark("Generuojamas pdf...", {  timer: 50});
            getPdf('/admin/users/generatePdf',{users: formattedData}).then(resp => {
                let blob = new Blob([resp],{type: 'application/pdf'});
                window.open(URL.createObjectURL(blob));
                this.$notification.removeAll()
            })
        }
    }
}
</script>
