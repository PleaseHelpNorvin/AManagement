import { Component } from '@angular/core';
import { ChartConfiguration, ChartType } from 'chart.js';
import { BaseChartDirective } from 'ng2-charts';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-home-page',
  standalone: true,
  imports: [BaseChartDirective, CommonModule],
  templateUrl: './home-page.component.html',
  styleUrls: ['./home-page.component.css'],
})
export class HomePageComponent {
  // Payment Overview Chart Data
  public paymentChartLabels: string[] = ['Paid', 'Overdue', 'Pending'];
  public paymentChartData: ChartConfiguration<'pie'>['data'] = {
    labels: this.paymentChartLabels,
    datasets: [
      {
        data: [1200, 500, 800],
        backgroundColor: ['#4caf50', '#f44336', '#ffeb3b'], // Colors for pie chart
      },
    ],
  };
  public paymentChartType: ChartType = 'pie';

  // Tenants Overview Chart Data
  public tenantChartLabels: string[] = ['Occupied', 'Vacant', 'New Tenants'];
  public tenantChartData: ChartConfiguration<'bar'>['data'] = {
    labels: this.tenantChartLabels,
    datasets: [
      {
        label: 'Tenants',
        data: [50, 10, 5],
        backgroundColor: ['#3f51b5', '#ff9800', '#9c27b0'], // Colors for bar chart
      },
    ],
  };
  public tenantChartType: ChartType = 'bar';

  // Chart Options
  public chartOptions: ChartConfiguration['options'] = {
    responsive: true,
    maintainAspectRatio: false,
  };
}
