import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { CommonModule } from '@angular/common';
import { TenantsService } from '../../../core/service/tenants/tenants.service';  // Import the service

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
  standalone: true,  // Use standalone if this component is standalone
  imports: [CommonModule],
  templateUrl: './tenants-details.component.html',
  styleUrls: ['./tenants-details.component.css']
})
export class TenantsDetailsComponent implements OnInit {
  tenantId!: number;
  tenant: Tenant | undefined;

  constructor(
    private route: ActivatedRoute,  // ActivatedRoute to get the route parameters
    private tenantsService: TenantsService  // Inject TenantsService
  ) {}

  ngOnInit(): void {
    // Extract tenant ID from the route parameters
    this.route.paramMap.subscribe(params => {
      this.tenantId = +params.get('id')!; // Convert the string ID to a number
      // Fetch tenant details based on tenantId
      this.getTenantDetails();
    });
  }

  getTenantDetails(): void {
    this.tenantsService.getTenantById(this.tenantId).subscribe({
      next: (data) => {
        // Assign fetched tenant data to the tenant variable
        this.tenant = data;
        console.log('Fetched tenant details:', this.tenant); // Log the tenant data for debugging
      },
      error: (err) => {
        // console.error('Error fetching tenant details:', err);  // Handle errors
      }
    });
  }
}
