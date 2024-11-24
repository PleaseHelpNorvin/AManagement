import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { CommonModule } from '@angular/common';

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
  selector: 'app-tenants-details',
  imports: [CommonModule],
  templateUrl: './tenants-details.component.html',
  styleUrl: './tenants-details.component.css'
})
export class TenantsDetailsComponent implements OnInit{
  tenantId!: number;
  tenant: Tenant | undefined;

  tenants: Tenant[] = [  // Sample tenants, ideally this data should come from an API or a shared service
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
      paymentHistory: [{
          date: '2024-11-01', 
          amount: '$1000' 
        }],
      maintenanceRequests: [{ 
          description: 'Plumbing issue', 
          status: 'Closed' 
        }]
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
      paymentHistory: [{ date: '2024-11-05', amount: '$1200' }],
      maintenanceRequests: [{ description: 'Electrical issue', status: 'Open' }]
    }
  ];

  constructor(private route: ActivatedRoute) {}

  ngOnInit(): void {
   // Extract tenant ID from the route parameters
   this.route.paramMap.subscribe(params => {
    this.tenantId = +params.get('id')!; // Now it's safe to assert this as a number
    // Fetch tenant details based on tenantId
    this.getTenantDetails();
  });
  }

  getTenantDetails(): void {
    // Find the tenant using the ID from the route
    this.tenant = this.tenants.find(t => t.id === this.tenantId);
    if (!this.tenant) {
      console.error('Tenant not found!');
    }
  }
}
