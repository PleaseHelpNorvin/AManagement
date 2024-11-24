import { Component, OnInit } from '@angular/core';
import { RouterModule } from '@angular/router';
import { Router } from '@angular/router';

import { CommonModule } from '@angular/common';
import { MatTableModule } from '@angular/material/table';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';

interface Tenant {
  id: number;
  name: string;
  apartment: string;
  dueDate: string;
  lastPayment: string;
  paymentStatus: string;
  phone: string;
  email: string;
  leaseStartDate: string;
  leaseEndDate: string;
  paymentHistory: any[];
  maintenanceRequests: any[];
}

@Component({
  selector: 'app-tenants-page',
  standalone: true,
  imports: [
    RouterModule,
    CommonModule,
    MatTableModule,
    MatIconModule,
    MatButtonModule
  ],
  templateUrl: './tenants-page.component.html',
  styleUrls: ['./tenants-page.component.css']
})
export class TenantsPageComponent implements OnInit {
  tenant: Tenant | undefined;
  isSmallScreen: boolean = false;
  public displayedColumns: string[] = ['id', 'name', 'apartment', 'dueDate', 'lastPayment', 'paymentStatus', 'actions'];
  // public dataSource = [];
  public dataSource: Tenant[] = [];

  constructor(private router: Router){}

  onResize(event: any) {
    this.isSmallScreen = event.target.innerWidth <= 600;
  }
  
  //mock tenants ill change the api to this format 
    tenants: Tenant[] = [
      {
        id: 1,
        name: 'John Doe',
        apartment: '101',
        dueDate: '2024-12-01',
        lastPayment: '2024-11-01',
        paymentStatus: 'Paid',
        phone: '123-456-7890',
        email: 'john.doe@example.com',
        leaseStartDate: '2024-01-01',
        leaseEndDate: '2025-01-01',
        paymentHistory: [
          { date: '2024-11-01', amount: '$1000' },
          { date: '2024-10-01', amount: '$1000' }
        ],
        maintenanceRequests: [
          { description: 'Plumbing issue', status: 'Closed' },
          { description: 'AC repair', status: 'Open' }
        ]
      },
      {
        id: 2,
        name: 'Jane Smith',
        apartment: '102',
        dueDate: '2024-12-05',
        lastPayment: '2024-11-05',
        paymentStatus: 'Pending',
        phone: '987-654-3210',
        email: 'jane.smith@example.com',
        leaseStartDate: '2024-02-01',
        leaseEndDate: '2025-02-01',
        paymentHistory: [
          { date: '2024-11-05', amount: '$1200' },
          { date: '2024-10-05', amount: '$1200' }
        ],
        maintenanceRequests: [
          { description: 'Electrical issue', status: 'Open' },
          { description: 'Water leak', status: 'Closed' }
        ]
      }
      // Add more tenants as needed...
    ];

  ngOnInit(): void {
    // Call the static method to set the tenant data
   
    this.getTenants();
  }

  // Static method to get tenant data (replacing API call)
  getTenants(): void {
    // Simulate an API call (commented out)
    // this.httpClient.get<Tenant[]>('API_ENDPOINT').subscribe(
    //   (response) => {
    //     this.dataSource = response;
    //     console.log('Data fetched from API:', response);
    //   },
    //   (error) => {
    //     console.error('Error fetching data:', error);
    //   }
    // );

    // Static method for now (using mock data)
    console.log('Static tenant data:', this.tenants);
    this.dataSource = this.tenants;  // Assigning mock tenant data
    console.log('Assigned dataSource:', this.dataSource);
  }
  viewTenant(tenant: Tenant): void {
    console.log('view tenant:', tenant);
    this.router.navigate(['admin/tenants/', tenant.id]);

  }
  editTenant(tenant: Tenant): void {
    console.log('Edit tenant:', tenant);
    this.router.navigate(['admin/tenants-edit/', tenant.id]);

    // Implement edit logic here (e.g., navigate to a form or open a modal)
  }
  generatePaymentReminder(tenant: Tenant): void {
    console.log('generatepayment remindder', tenant);
  }
  deleteTenant(tenant: Tenant): void {
    console.log('Delete tenant:', tenant);
    // Implement delete logic here (e.g., API call to delete tenant)
    this.dataSource = this.dataSource.filter(t => t.id !== tenant.id);
  }
}
