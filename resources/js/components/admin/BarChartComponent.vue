
<script>
import { Bar } from "vue-chartjs";
export default {
  extends: Bar,
  props: ['analyticsdata', 'title'],
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
          return {
            labels: this.analyticsdata.map((order) => {
                return order.date;
            }),
            datasets: [
                {
                    label: this.title,
                    backgroundColor: "#8A2BE2",
                    data: this.analyticsdata.map((order) => {
                        return order.count;
                    }),
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
