// angular import
import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { DashboardService } from 'src/app/demo/default/dashboard/service/dashboard.service';
import { AuthService } from '../../authentication/login/auth.service';
import { PingResponse } from './service/ping-response.interface'; // Import the interface

// project import
import tableData from 'src/fake-data/default-data.json';
import { Router } from '@angular/router'; // Import Router
import { SharedModule } from 'src/app/theme/shared/shared.module';
import { MonthlyBarChartComponent } from './monthly-bar-chart/monthly-bar-chart.component';
import { IncomeOverviewChartComponent } from './income-overview-chart/income-overview-chart.component';
import { AnalyticsChartComponent } from './analytics-chart/analytics-chart.component';
import { SalesReportChartComponent } from './sales-report-chart/sales-report-chart.component';

// icons
import { IconService } from '@ant-design/icons-angular';
import { FallOutline, GiftOutline, MessageOutline, RiseOutline, SettingOutline } from '@ant-design/icons-angular/icons';
import { error } from 'console';

@Component({
  selector: 'app-default',
  standalone: true,
  imports: [
    CommonModule,
    SharedModule,
    MonthlyBarChartComponent,
    IncomeOverviewChartComponent,
    AnalyticsChartComponent,
    SalesReportChartComponent
  ],
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss']
})
export class DefaultComponent {
  // constructor
  constructor(private iconService: IconService, private dashboardService: DashboardService, private authService: AuthService ,private router: Router ) {
    this.iconService.addIcon(...[RiseOutline, FallOutline, SettingOutline, GiftOutline, MessageOutline]);
  }
  isLoggedIn: boolean = false;

  recentOrder = tableData;

  AnalyticEcommerce = [
    {
      title: 'Total Page Views',
      amount: '4,42,236',
      background: 'bg-light-primary ',
      border: 'border-primary',
      icon: 'rise',
      percentage: '59.3%',
      color: 'text-primary',
      number: '35,000'
    },
    {
      title: 'Total Users',
      amount: '78,250',
      background: 'bg-light-primary ',
      border: 'border-primary',
      icon: 'rise',
      percentage: '70.5%',
      color: 'text-primary',
      number: '8,900'
    },
    {
      title: 'Total Order',
      amount: '18,800',
      background: 'bg-light-warning ',
      border: 'border-warning',
      icon: 'fall',
      percentage: '27.4%',
      color: 'text-warning',
      number: '1,943'
    },
    {
      title: 'Total Sales',
      amount: '$35,078',
      background: 'bg-light-warning ',
      border: 'border-warning',
      icon: 'fall',
      percentage: '27.4%',
      color: 'text-warning',
      number: '$20,395'
    }
  ];

  transaction = [
    {
      background: 'text-success bg-light-success',
      icon: 'gift',
      title: 'Order #002434',
      time: 'Today, 2:00 AM',
      amount: '+ $1,430',
      percentage: '78%'
    },
    {
      background: 'text-primary bg-light-primary',
      icon: 'message',
      title: 'Order #984947',
      time: '5 August, 1:45 PM',
      amount: '- $302',
      percentage: '8%'
    },
    {
      background: 'text-danger bg-light-danger',
      icon: 'setting',
      title: 'Order #988784',
      time: '7 hours ago',
      amount: '- $682',
      percentage: '16%'
    }
  ];

  ngOnInit() {


    this.dashboardService.getAdminStatus().subscribe(
      isLoggedIn => {
        console.log('Admin Status Response:', isLoggedIn);
        this.isLoggedIn = isLoggedIn === 1;
        // this.authService.updateLocalStatus(this.isLoggedIn); // Update AuthService state
        this.onCheckServerPing();
        setInterval(() => this.onCheckServerPing(), 5000);
      },
      error => {
        console.error('Failed to fetch admin status', error);
        if (error.status === 401) { // Check for unauthorized status

          this.router.navigate(['/login']); // Redirect to login page
        }
        // Optionally, handle other error states
      }
    );
  }

  onCheckServerPing() {
    this.dashboardService.getServerPing().subscribe(
        (response: PingResponse) => {
            if (response.data.status === 'Ping Successful') {
                console.log('Ping successful:', response);
            }
        },
        error => {
            if (error.status === 403) {
                console.error('Admin session expired or logged out');

                this.authService.clearAuth();
                // Redirect to login
            }
        }
    );
}

 
}
