<template>
    <div class="container">
        <div class="d-flex align-items-center justify-content-end mt-3">
            <div class="title mr-auto">{{title}}</div>
            <datepicker 
                v-model="from"
                :language="lt"
                :disabled-dates="datesDisabled"
                @input="limitFrom"
                :placeholder="'Nuo'"></datepicker>
                <datepicker 
                v-model="to"
                :language="lt"
                :disabled-dates="limit_from"
                class="ml-1"
                :placeholder="'Iki'"></datepicker>
                <div @click="refreshData()" class="btn btn-primary btn-refresh ml-2"><i ref="refresh" class="fas fa-sync-alt"></i></div>
        </div>

        <!-- Trys korteles -->
        <div class="row mt-3">
            <div class="col-sm-4">
                <div class="analytics_card">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="analytics_card_title">
                                Apyvarta
                            </div>
                            <div class="analytics_card_content">
                                {{this.allData.orders_counts.total_sales.toFixed(2)}}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="analytics_card">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="analytics_card_title">
                                 Apmokėtos rezervacijos
                            </div>
                            <div class="analytics_card_content">
                                {{this.allData.orders_counts.sales_count}}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <i class="far fa-chart-bar"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="analytics_card">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="analytics_card_title">
                                Vartotojai
                            </div>
                            <div class="analytics_card_content">
                                {{this.allData.users_counts.total_users}}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Du chartai -->
        <div class="row mt-3">
            <div class="col-sm-6">
                <div class="chartBlock">
                    <bar-chart-component :title="'Užsakymai'" :analyticsdata="this.allData.orders"></bar-chart-component>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="chartBlock">
                    <bar-chart-component :title="'Vartotojai'" :analyticsdata="this.allData.users"></bar-chart-component>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import buildQuery from '../../helpers/querybuilder'
import { lt } from 'vuejs-datepicker/dist/locale'
import Datepicker from 'vuejs-datepicker'
import BarChartComponent from './BarChartComponent' // Barchart'as
import {get} from '../../helpers/requests'

export default {
        components : {BarChartComponent, 'datepicker' : Datepicker},
        props: ['analyticsdata'],
        data: function () {
            return {
                lt : lt,
                from: '',
                to: '',
                limit_from: {},
                datesDisabled : {},
                allData : this.analyticsdata
            }
        },
        mounted: function () {
           
        },
        methods : {
            limitFrom () {
                this.limit_from = {
                    ranges : [
                        {
                            from : new Date(-1),
                            to : this.from,
                        }
                    ]
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
            refreshData () {
                this.$refs.refresh.classList.add('rotating')
                let datesQuery = buildQuery({
                    from : this.from !== '' ? this.formatDate(this.from) : '2019-01-01', 
                    to : this.to !== '' ? this.formatDate(this.to) : '2100-01-01', 
                })

                 get('/admin/analytics?'+datesQuery).then(response => {
                    this.allData = response.data
                    this.$refs.refresh.classList.remove('rotating')
                })
            }
        },
        computed :{
            title : function () {
                if (this.from == '' && this.to == '') return 'Visi duomenys'
                if (this.from == '' && this.to !== '') return 'Iki ' + this.formatDate(this.to)
                if (this.from !== '' && this.to == '') return 'Nuo ' + this.formatDate(this.from)
                return this.formatDate(this.from) + ' - ' + this.formatDate(this.to)
            }
        }
    };
</script>
<style lang="scss">
.vdp-datepicker__calendar{
    top: 35px;
}
.btn-refresh{
    background-color:#8A2BE2;
    opacity: .5;
    transition: all .4s;
    &:hover{
        opacity: 1;
        background-color: #8A2BE2;
    }
}
</style>