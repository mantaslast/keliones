
<script>
import { Bar } from "vue-chartjs";
export default {
  extends: Bar,
  props: ['analyticsdata'],
  watch: {
    analyticsdata: function (val) {
        this.renderBarChart()
    },
  },
  data: function () {
    return {
      chartdata: {
        labels: [],
        datasets: [],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          xAxes: [
            {
              display: true,
            },
          ],
          yAxes: [
            {
              ticks: {
                beginAtZero: true,
              },
            },
          ],
        },
      },
    };
  },
  methods : {
      renderBarChart : function () {
          this.renderChart(this.chartData, this.options)
      }
  },
  computed : {
      chartData: function () {
        let merged = this.analyticsdata.successfull.concat(this.analyticsdata.unsuccessfull)
        let dates = merged.map(data => {
            return data.date
        })

        let labels = [...new Set(dates)].sort(function(a,b){
            return new Date(a) - new Date(b);
        });

       let successfullData = labels.map(labelDate => {
           let found = {
               date: labelDate,
               count: 0
           }
           this.analyticsdata.successfull.forEach(order => {
               if (order.date == labelDate) {
                   found = order
               }
           });
           return found
       })

       let unsuccessfullData = labels.map(labelDate => {
           let found = {
               date: labelDate,
               count: 0
           }
           this.analyticsdata.unsuccessfull.forEach(order => {
               if (order.date == labelDate) {
                   found = order
               }
           });
           return found
       })

        return {
            labels: labels,
            datasets: [
                {
                    label: 'Apmokėtos rezervacijos',
                    backgroundColor: "#8A2BE2",
                    data: successfullData.map(order => {
                        return order.count
                    }) 
                },
                {
                    label: 'Neapmokėtos rezervacijos',
                    backgroundColor: "#fff",
                    data: unsuccessfullData.map(order => {
                        return order.count
                    }) 
                },
            ]
        }
      }
  },
  mounted: function () {
      this.renderBarChart()
  },
};
</script>
