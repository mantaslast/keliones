<template>
  <div class="">
        <v-select class="mb-2"
        v-model="dropdownSelected"
        :option="dropdownOptions"
        :placement="'down'"
        ></v-select>
        <VueFileAgent
        v-model="fileRecords"
        ref="vueFileAgent"
        :deletable="true"
        :multiple="true"
        :accept="'.csv'"
        :maxSize="'10MB'"
        :maxFiles="3"
        :helpText="'Pasirinkite CSV failą'"
        :errorText="{
            type: 'Neteisingas failo tipas! Prašome pasirinkti CSV failo formatą',
            size: 'Failo dydis negali viršyti 10MB',
        }"
        @select="filesSelected($event)"
        @beforedelete="onBeforeDelete($event)"
        @delete="fileDeleted($event)"
        ></VueFileAgent>
        <button class="ml-0 mt-1" :disabled="!fileRecordsForUpload.length" @click="uploadFiles()">
        Generuoti
        </button>
     
        <div v-if="this.importData.success || this.importData.failed || this.importData.rejected" class="importResults d-flex mt-2">
            <div title="Sėkmingai importuoti" v-show="this.importData.success && this.importData.success.length > 0" class="modal_success mbadge d-flex align-items-center my-1">
                <i style="width: 50px;" class="fas fa-check-circle"></i>
                <div v-if="this.importData.success !== undefined" class="modal_count">{{this.importData.success.length}}</div>
            </div>
            <div :class="{active : open}" @click="open=true" title="Ne pasiūlymo URL su teisingu domenu" v-show="this.importData.failed && this.importData.failed.length > 0" class="modal_warning mbadge d-flex align-items-center my-1">
                <i style="width: 50px;" class="fas fa-exclamation-triangle"></i>
                <div v-if="this.importData.failed !== undefined" class="modal_count">{{this.importData.failed.length}}</div>
            </div>
            <div title="Netinkamas URL" v-show="this.importData.rejected && this.importData.rejected.length > 0" class="modal_failed mbadge d-flex align-items-center my-1">
                <i style="width: 50px;" class="fas fa-exclamation"></i>
                <div v-if="this.importData.rejected !== undefined" class="modal_count">{{this.importData.rejected.length}}</div>
            </div>
        </div>

        <vue-table-dynamic ref="table" :params="params">
             <template v-slot:column-4="{ props }">
                <div v-html="limitText(props)"></div>
            </template>
            <template v-slot:column-5="{ props }">
                <div v-if="props.cellData == 0" title="Išsaugoti prie importuotų" class="btn btn-warning ml-1" @click="saveImported(props)"><i class="fas fa-share-square"></i></div>
                <div v-if="props.cellData == 1" title="Išsaugotas prie importuotų" class="btn btn-primary ml-1"><i class="far fa-check-circle"></i></div>
            </template>
        </vue-table-dynamic>

        <vue-modaltor v-if="importData.failed && importData.failed.length > 0" :visible="open" @hide="hideModal">
            <template slot="close-icon">
                <svg
                version="1.1"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 40 40"
                width="20"
                height="20"
                xml:space="preserve"
                >
                <path
                    class="st0"
                    fill="#41b883"
                    d="M8.7,7.6c-0.4-0.4-1-0.4-1.4,0C6.9,8,6.9,8.6,7.3,9l11,11l-11,11c-0.4,0.4-0.4,1,0,1.4c0.4,0.4,1,0.4,1.4,0 l11-11l11,11c0.4,0.4,1,0.4,1.4,0c0.4-0.4,0.4-1,0-1.4l-11-11L32,9c0.4-0.4,0.4-1,0-1.4c-0.4-0.4-1-0.4-1.4,0l-11,11L8.7,7.6z"
                />
                </svg>
            </template>
            <div class="wrongUrls">
                <div class="wrongurl" v-for="(item, index) in importData.failed" :key="index">{{item}}</div>
            </div>
            </vue-modaltor>
  </div>
</template>

<script>
import vSelect from "vselect-component";
import { post, postCsv } from "../../helpers/requests";
import VueTableDynamic from 'vue-table-dynamic'

export default {
  components: { vSelect, VueTableDynamic },
  data: function () {
    return {
      dropdownOptions: [
        { value: "scrapper", label: "Importuoti nuorodas robotui" },
        { value: "plain", label: "Importuoti pasiūlymus iš csv" },
      ],
      dropdownSelected: {
        value: "scrapper",
        label: "Importuoti nuorodas robotui",
      },
      fileRecords: [],
      uploadUrl: window.location.origin + "/api/admin/imports",
      fileRecordsForUpload: [],
      open: false,
      importData: {},
      params : {},
    };
  },
  methods: {
    uploadFiles: function () {
        let formData = new FormData()
        this.$notification.dark("Importuojami duomenys...", {  timer: 50});
        for (let file of this.$refs.vueFileAgent.fileRecords) {
            formData.append("files[]", file.file)
        }

        if (this.dropdownSelected.value == 'scrapper') {
            postCsv('/admin/scrapperimports', {body:formData}).then(res => {
                console.log(res)
                this.importData = res
                this.$notification.removeAll()
                this.$notification.success("Duomenys sugeneruoti sėkmingai!", {  timer: 6});
                if (this.importData.success.length > 0) {
                      this.setTableData(this.importData.success)
                }
            })
        } else if (this.dropdownSelected.value == 'plain') {
            postCsv('/admin/plainimports', {body:formData}).then(res => {
                console.log(res)
                this.importData = res
                this.$notification.removeAll()
                this.$notification.success("Duomenys sugeneruoti sėkmingai!", {  timer: 6});
            })
        }
    },
    deleteUploadedFile: function (fileRecord) {
      this.$refs.vueFileAgent.deleteUpload(
        this.uploadUrl,
        this.uploadHeaders,
        fileRecord
      );
    },
    filesSelected: function (fileRecordsNewlySelected) {
      var validFileRecords = fileRecordsNewlySelected.filter(
        (fileRecord) => !fileRecord.error
      );
      this.fileRecordsForUpload = this.fileRecordsForUpload.concat(
        validFileRecords
      );
    },
    onBeforeDelete: function (fileRecord) {
      var i = this.fileRecordsForUpload.indexOf(fileRecord);
      if (i !== -1) {
        this.fileRecordsForUpload.splice(i, 1);
        var k = this.fileRecords.indexOf(fileRecord);
        if (k !== -1) this.fileRecords.splice(k, 1);
      } else {
        if (confirm("Are you sure you want to delete?")) {
          this.$refs.vueFileAgent.deleteFileRecord(fileRecord);
        }
      }
    },
    fileDeleted: function (fileRecord) {
      var i = this.fileRecordsForUpload.indexOf(fileRecord);
      if (i !== -1) {
        this.fileRecordsForUpload.splice(i, 1);
      } else {
        this.deleteUploadedFile(fileRecord);
      }
    },

    setTableData(data) {
        let offers = Array.prototype.concat.apply([], data.map(offer => {
            return offer.data.map(trg => {
                return [offer.name, trg.dateFrom === undefined ? '-' : trg.dateFrom , trg.dateTo, trg.price, offer.description,0]
            })
        })); 
       
        this.params = {
            data: [
                ['Pavadinimas', 'Išvykimas', 'Atvykimas', 'Kaina (€)', 'Aprašymas', 'Veiksmas'],
                ...offers
            ],
            header: 'row',
            sort: [0, 1, 2, 3],
            border: true,
            enableSearch: true,
            pagination: true,
            pageSize: 20,
            pageSizes: [20, 50, 100, 500],
            showTotal: true,
            columnWidth: [{column: 0, width: 250}, {column: 1, width: 100}, {column: 2, width: 100}, {column: 3, width: 100}, {column: 5, width: 60}],
        }
    },
    saveImported : function (props) {
        let rowData = props.rowData
        let offerData = {
            name : rowData[0].data,
            leave_at : rowData[1].data,
            arrive_at : rowData[2].data,
            price : rowData[3].data,
            description : rowData[4].data,
        }
        this.params.data.splice(props.row, 1)
        post('/admin/storeImportedOffer', {data : offerData}).then(res => {
           this.$notification.success("Pasiūlymas perkeltas prie importuotų sąrašo!", {  timer: 4});
        })
    },
    hideModal() {
      this.open = false;
    },
    limitText(props) {
        let str = props.cellData
        return str.length + ' Simboliai'
    }
  },
};
</script>

<style lang="scss">
.down {
  &.select {
    width: 220px;
  }
}
.modal{
    &_count{
        font-size: 30px;
    }
    &_success{
        i{
            color: #7FFF00;
        }
    }
    &_warning{
        cursor:pointer;
        &:hover{
            i{
                opacity: 1;
            }
        }
        i{
            opacity: .5;
            color: #FFD700;
        }
        &.active{
            i{
                opacity: 1;
            }
        }
    }
    &_failed{
        i{
            color: #FF0000;
        }
    }
}
.mbadge{
    font-size: 45px;
}
.importResults{
    padding: 15px;
    border-radius: 15px;
    justify-content: space-evenly;
    background: white;
    border: 1px solid gainsboro;
}
</style>
