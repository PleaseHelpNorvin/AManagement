import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { TenantsService } from '../../core/service/tenants/tenants.service'; // Import the service

import { CommonModule } from '@angular/common';
import { MatTableModule } from '@angular/material/table';
import { MatButtonModule } from '@angular/material/button';
import { MatIconModule } from '@angular/material/icon';

interface Tenant {
  id: number;
  name: string;
  apartment: string | null; // Apartment can be null
  leaseStart: string;
  leaseEnd: string;
  status: string;
}

@Component({
  selector: 'app-tenants-page',
  standalone: true,
  imports: [
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
  public displayedColumns: string[] = ['id', 'name', 'apartment', 'leaseStart', 'leaseEnd', 'status', 'actions'];
  public dataSource: Tenant[] = []; // Array to hold tenant data

  constructor(private router: Router, private tenantsService: TenantsService) {}

  ngOnInit(): void {
    // Fetch tenants when the component is initialized
    this.getTenants();
  }

  onResize(event: any) {
    this.isSmallScreen = event.target.innerWidth <= 600;
  }

  // Call TenantsService to get tenant data from API
  getTenants(): void {
    this.tenantsService.getTenants().subscribe(
      (response) => {
        console.log('Data fetched from API:', response);
        this.dataSource = response.data.map((tenant: any) => ({
          id: tenant.id,
          name: tenant.name,
          apartment: tenant.apartment || 'N/A',
          leaseStart: tenant.leaseStart,
          leaseEnd: tenant.leaseEnd,
          status: tenant.status,
        }));
      },
      (error) => {
        console.error('Error fetching data:', error);
      }
    );
  }

  viewTenant(tenant: Tenant): void {
    console.log('view tenant:', tenant);
    this.router.navigate(['admin/tenants/', tenant.id]);
  }

  editTenant(tenant: Tenant): void {
    console.log('Edit tenant:', tenant);
    this.router.navigate(['admin/tenants-edit/', tenant.id]);
  }

  generatePaymentReminder(tenant: Tenant): void {
    console.log('generate payment reminder for', tenant);
  }

  deleteTenant(tenant: Tenant): void {
    console.log('Delete tenant:', tenant);
    // Implement delete logic here (e.g., API call to delete tenant)
    this.dataSource = this.dataSource.filter(t => t.id !== tenant.id);
  }
}
