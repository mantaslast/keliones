<template>
    <div class="searchbar justify-content-center">
        <form ref="searchForm" action=""></form>
        <div class="search_item" style="border-top-left-radius:10px; border-bottom-left-radius:10px;">
            <input v-model.lazy="searchVal" type="text" id="search" class="searchInput" placeholder="Ieškoti...">
        </div>
        <div class="search_item text-center">
            <datepicker 
            :disabled-dates="datesDisabled"
            v-model="leave_at"
            :language="lt"
            @input="limitArriveAt"
            :placeholder="'Išvykimas nuo'"></datepicker>
        </div>

        <div class="search_item text-center">
            <datepicker 
            v-model="arrive_at"
            :language="lt"
            :disabled-dates="limit_leave_at"
            :placeholder="'Atvykimas iki'"></datepicker>
        </div>
        
        <div class="search_item ">
                <rangeslider class="mt-2" 
                :min="0" 
                :max="5000"
                :bg-style="{backgroundColor: '#fff', boxShadow: 'inset 0.5px 0.5px 3px 1px rgba(0,0,0,.36)'}" 
                :tooltip-style="{ backgroundColor: '#666', borderColor: '#666'}" 
                :process-style="{ backgroundColor: '#005b96' }" 
                v-model="price">
            </rangeslider>
        </div>
        <i id="searchIcon" @click="search($event)" class="fas fa-search mx-2"></i>
        <i @click="listen($event)" class="fas fa-microphone mic mx-2"></i>
    </div>
</template>

<script>
    import buildQuery from '../../helpers/querybuilder'
    import {rec} from '../../helpers/recognition'
    import Datepicker from 'vuejs-datepicker'
    import { lt } from 'vuejs-datepicker/dist/locale'
    import 'vue-range-component/dist/vue-range-slider.css'
    import VueRangeSlider from 'vue-range-component'
    export default {
        components : {'datepicker' : Datepicker, 'rangeslider' : VueRangeSlider },
        data : ()=>({
            searchVal : '',
            price : [0, 5000],
            leave_at : '',
            arrive_at : '',
            lt : lt,
            datesDisabled : {
                ranges : [
                    {
                        from : new Date(-1),
                        to : new Date()
                    }
                ]
            },
            limit_leave_at : {}
        }),
        methods: {
            search (e) {
                let filterQuery = buildQuery({
                        text: this.searchVal, 
                        price : this.price, 
                        leave_at : this.leave_at !== '' ? this.formatDate(this.leave_at) : '', 
                        arrive_at : this.arrive_at !== '' ? this.formatDate(this.arrive_at) : '', 
                    })
                    if (filterQuery.length == 0) {
                        let searchIcon = document.getElementById('searchIcon')
                        searchIcon.style.color = 'red'
                        new Promise((resolve, reject) => {
                            setTimeout(() => {resolve()}, 2000)
                        }).then(() => {searchIcon.style.color = 'grey'})
                    } else {
                        window.location = this.$refs.searchForm.action + 'paieska?' + filterQuery;
                    }
            },

            listen(e) {
                if (!window.webkitSpeechRecognition) return
                let recognition = rec(e)
                let self = this
                if (!recognition.started) {
                    recognition.start();
                } else {
                    recognition.stop();
                }
            },

            formatDate (date) {
                if (date && date.length == 0 ) return ''
                let d = new Date(date),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();

                if (month.length < 2) 
                    month = '0' + month;
                if (day.length < 2) 
                    day = '0' + day;

                return [year, month, day].join('-');
            },
            limitArriveAt () {
                this.limit_leave_at = {
                    ranges : [
                        {
                            from : new Date(-1),
                            to : this.leave_at,
                        }
                    ]
                }
            }
        },

    }
</script>
<style lang="scss">
.vdp-datepicker__calendar{
    top: -252px;
}
.vdp-datepicker{
    input{
        border: 1px solid #ccc;
    border-radius: 4px;
    padding: 6px 10px;
    transition: all 0.3s;
    font-size: 13px;
    }
}

.slider-tooltip-wrap{
    z-index: 999;
}
</style>