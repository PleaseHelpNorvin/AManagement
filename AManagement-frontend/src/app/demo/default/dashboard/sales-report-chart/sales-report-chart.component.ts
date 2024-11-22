// angular import
import { Component, ViewChild } from '@angular/core';

// third party
import {
  NgApexchartsModule,
  ChartComponent,
  ApexChart,
  ApexAxisChartSeries,
  ApexPlotOptions,
  ApexXAxis,
  ApexYAxis,
  ApexStroke,
  ApexGrid,
  ApexTooltip,
  ApexLegend,
  ApexDataLabels
} from 'ng-apexcharts';

// Define ChartOptions Type
export type ChartOptions = {
  series: ApexAxisChartSeries;
  chart: ApexChart;
  plotOptions: ApexPlotOptions;
  dataLabels: ApexDataLabels;
  legend: ApexLegend;
  xaxis: ApexXAxis;
  colors: string[];
  stroke: ApexStroke;
  grid: ApexGrid;
  yaxis: ApexYAxis;
  tooltip: ApexTooltip;
};

@Component({
  selector: 'app-sales-report-chart',
  standalone: true,
  imports: [NgApexchartsModule],
  templateUrl: './sales-report-chart.component.html',
  styleUrls: ['./sales-report-chart.component.scss']
})
export class SalesReportChartComponent {
  @ViewChild('chart') chart!: ChartComponent;
  chartOptions!: Partial<ChartOptions>;

  constructor() {
    // Chart options configuration
    this.chartOptions = {
      chart: {
        type: 'bar',  // Type of chart (Bar Chart)
        height: 430,  // Height of the chart
        toolbar: {
          show: false  // Hide toolbar
        },
        background: 'transparent'  // Set chart background to transparent
      },
      plotOptions: {
        bar: {
          columnWidth: '30%',  // Set width for bar columns
          borderRadius: 4  // Round the corners of bars
        }
      },
      stroke: {
        show: true,  // Enable stroke
        width: 8,  // Set stroke width
        colors: ['transparent']  // Set stroke color to transparent
      },
      dataLabels: {
        enabled: false  // Disable data labels on bars
      },
      legend: {
        position: 'top',  // Place legend at the top
        horizontalAlign: 'right',  // Align legend to the right
        show: true,  // Show legend
        fontFamily: `'Public Sans', sans-serif`,  // Set font for legend
        offsetX: 10,  // Horizontal offset for the legend
        offsetY: 10,  // Vertical offset for the legend
        labels: {
          useSeriesColors: false  // Disable series color usage for labels
        },
        markers: {
          shape: 'circle',  // Set marker shape to circle
          // width: 12,  // Set marker width
          // height: 12,  // Set marker height
          strokeWidth: 2,  // Set marker border width
          fillColors: ['#faad14', '#1677ff'],  // Marker colors
        },
        itemMargin: {
          horizontal: 15,  // Set horizontal margin for items in the legend
          vertical: 5  // Set vertical margin for items in the legend
        }
      },
      series: [
        {
          name: 'Net Profit',  // First series name
          data: [180, 90, 135, 114, 120, 145]  // Data for the first series (Net Profit)
        },
        {
          name: 'Revenue',  // Second series name
          data: [120, 45, 78, 150, 168, 99]  // Data for the second series (Revenue)
        }
      ],
      xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],  // Set categories (months)
        labels: {
          style: {
            colors: ['#222', '#222', '#222', '#222', '#222', '#222']  // Set color for X-axis labels
          }
        }
      },
      tooltip: {
        theme: 'light'  // Set tooltip theme to light
      },
      colors: ['#faad14', '#1677ff'],  // Set colors for the series
      grid: {
        borderColor: '#f5f5f5'  // Set grid border color
      }
    };
  }
}
