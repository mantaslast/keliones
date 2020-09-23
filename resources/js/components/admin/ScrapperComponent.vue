<template>
    <div class="d-flex align-items-center">
        <div class="scrapperTitle">Rasti automatiškai</div>
        <input name="url" class="ml-3 scrapperUrl" v-model="url" type="text">
        <div @click="scrape" class="btn btn-primary ml-3">Ieškoti</div>
        <div v-if="datesModal" class="datesModal">
            <div v-for="(item, index) in scrappedData" :key="index" class="modal_item w-100 justify-content-between">
                <div class="modal_subItem" style="flex-basis: 40%;">
                    <span class="item_label">Pavadinimas</span>
                    <span class="item_content">{{ scrappedName }}</span>
                </div>
                <div class="modal_subItem">
                    <span class="item_label">Išvykimo data</span>
                    <span class="item_content">{{ item.dateFrom }}</span>
                </div>
                <div class="modal_subItem">
                    <span class="item_label">Atvykimo data</span>
                    <span class="item_content">{{ item.dateTo }}</span>
                </div>
                <div class="modal_subItem">
                    <span class="item_label">Kaina</span>
                    <span class="item_content">{{ item.price }} &euro;</span>
                </div>
                <div class="modal_subItem justify-content-center">
                    <input :data-item=index @change="applyData(item)" type="checkbox">
                </div>
            </div>
            <div class="description" v-html=scrappedDescription></div>
        </div>

    </div>
</template>

<script>
    import {post} from '../../helpers/requests'
    export default {
        data : function () {
            return {
                url : '',
                datesModal : false,
                scrappedData : [],
                scrappedDescription : '',
                scrappedName : ''
            }
        },
        methods : {
            scrape () {
                let expression = /[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)?/gi;
                let regex = new RegExp(expression);

                if (this.url.match(regex)) {
                    post('/scrapper',{'url' : this.url}).then(resp=>{
                        if (resp.errors) {
                            alert('Įvyko klaida, bandykite informaciją įvesti rankiniu būdu')
                        } else {
                            this.datesModal = true
                            document.getElementsByClassName('body_overlay')[0].style.display = 'block'
                            this.scrappedData = resp.data
                            this.scrappedDescription = resp.description
                            this.scrappedName = resp.name
                        }
                    })
                } else {
                    alert('Blogas URL!')
                }
            },
            applyData (item) {
                document.getElementById('name').value = this.scrappedName.trim()
                document.getElementById('leave_at').value = item.dateFrom
                document.getElementById('arrive_at').value = item.dateTo
                document.getElementById('description').innerHTML = this.scrappedDescription
                document.getElementsByClassName('fr-view')[0].innerHTML=this.scrappedDescription
                document.getElementsByClassName('fr-placeholder')[0].innerHTML=''
               
                document.getElementById('price').value = item.price
                this.datesModal = false
                document.getElementsByClassName('body_overlay')[0].style.display = 'none'

            }
        }
    }
</script>

<style lang="scss">
    .scrapperTitle{
        font-weight: bold;
    }
    .scrapperUrl{
        border: 1px solid grey;
        border-radius: 5px;
        font-size: 13px;
        padding: 6px 5px;
        width: 400px;
    }
    .datesModal{
        position: absolute;
        background: #fff;
        box-shadow: 0 0 4px 1.2px hsla(185,7%,68%,.8);
        z-index: 9999;
        top: 150px;
        left: 10%;
        right: 10%;
        padding: 10px;
        display: flex;
        flex-direction: column;
        border-radius: 5px;
        .modal_item{
            display: flex;
            .item_label{
                font-size: 12px;
                color: grey;
            }
            .item_content{
                font-size: 14px;
                color:#000;
            }
            .modal_subItem{
                display: flex;
                flex-direction: column;
            }
        }
    }

    .description{
        margin-top: 20px;
        max-height: 300px;
        overflow: scroll;
    }
</style>
