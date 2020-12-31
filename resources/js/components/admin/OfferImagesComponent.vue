<template>
    <div>
        <VueFileAgent
        :thumbnailSize="120"
        v-model="fileRecords"
        ref="vueFileAgent"
        :deletable="true"
        :multiple="true"
        :accept="'image/*'"
        :maxSize="'3MB'"
        :maxFiles="3"
        :helpText="'Pasirinkite nuotraukos failą'"
        :errorText="{
            type: 'Neteisingas failo tipas! Prašome pasirinkti jpg / png  failo formatą',
            size: 'Failo dydis negali viršyti 10MB',
        }"
        @select="filesSelected($event)"
        @beforedelete="onBeforeDelete($event)"
        @delete="fileDeleted($event)"
        ></VueFileAgent>
        <div class="d-none" ref="fileInputs" v-html="inputsHtml"></div>
    </div>
</template>

<script>
    import {post, getLocalFile} from '../../helpers/requests'
    export default {
        props:['imgs'],
        data : function () {
            return {
                fileRecords: [],
                fileRecordsForUpload: [],
                uploadUrl: window.location.origin + '/api/admin/offers/offerImage',
                fileNames: []
            }
        },
        mounted : function () {
            if (this.imgs) {
                if (this.imgs.length > 0) this.fileNames = this.imgs
                Promise.all(this.fileNames.map(filename => {
                    return getLocalFile('/files/'+filename,{}).then(res => {
                        let file = new File([res], "filename")
                        return file
                    }).then(file => {
                            return {
                            url : window.location.origin + '/files/' + filename,
                            size: file.size,
                            name: filename,
                            lastModified: file.lastModified,
                            type: "image/jpeg",
                            upload: {
                                data: {
                                    name: filename
                                }
                            },
                            dimensions: {
                                width: 640,
                                height: 360
                            },
                            imageColor: [66, 62, 45]
                        }
                    })
                })).then(files => {
                    this.fileRecords = files
                })
            }
        },
        methods : {
            deleteUploadedFile: function (fileRecord) {
                this.$refs.vueFileAgent.deleteUpload(
                    this.uploadUrl,
                    this.uploadHeaders,
                    fileRecord
                ).then(res => {
                    var k = this.fileNames.indexOf(res.data);
                    if (k !== -1) this.fileNames.splice(k, 1);
                });
            },
            filesSelected: function (fileRecordsNewlySelected) {
                var validFileRecords = fileRecordsNewlySelected.filter(
                    (fileRecord) => !fileRecord.error
                );
                this.fileRecordsForUpload = this.fileRecordsForUpload.concat(
                    validFileRecords
                );
                
                this.$refs.vueFileAgent.upload(this.uploadUrl, this.uploadHeaders, this.fileRecordsForUpload).then(res => {
                    res.forEach(element => {
                        this.fileNames.push(element.data.name)
                    });
                });
                this.fileRecordsForUpload = [];
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
                        var k = this.fileNames.indexOf(fileRecord.upload.data.name);
                        if (k !== -1) this.fileNames.splice(k, 1);
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
        },
        computed: {
            inputsHtml () {
                let html = ''
                this.fileNames.forEach(element => {
                    html += `<input type="hidden" value="${element}" name="imgs[]">`
                });
                return html
            }
        }
    }
</script>
<style lang="scss">

</style>