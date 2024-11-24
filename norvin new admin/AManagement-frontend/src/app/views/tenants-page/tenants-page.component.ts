import { Component } from '@angular/core';
import { RouterModule } from '@angular/router';
import { MatDialog,MatDialogModule  } from '@angular/material/dialog';
import { CommonModule } from '@angular/common';
import { TenantModalComponent } from './tenant-modal/tenant-modal.component';  // Import the TenantModalComponent
import { MatButtonModule } from '@angular/material/button';
import { MatInputModule } from '@angular/material/input';  // Import MatInputModule
import { MatTableModule } from '@angular/material/table';  // Import MatTableModule
import { MatFormFieldModule } from '@angular/material/form-field';  // Import MatFormFieldModule
import { FormsModule } from '@angular/forms';  // Import FormsModule for ngModel

interface Tenant {
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
    MatDialogModule,
    MatButtonModule,
    MatInputModule,
    MatTableModule,
    MatFormFieldModule,
    // TenantModalComponent,
    FormsModule  // Add FormsModule here
  ],
  templateUrl: './tenants-page.component.html',
  styleUrls: ['./tenants-page.component.css']
})
export class TenantsPageComponent {
  // displayedColumns: string[] = ['name', 'apartment', 'dueDate', 'lastPayment', 'paymentStatus', 'actions'];
  // tenants: Tenant[] = [
  //   {
  //     name: 'John Doe',
  //     apartment: '101',
  //     dueDate: '2024-12-01',
  //     lastPayment: '2024-11-01',
  //     paymentStatus: 'Paid',
  //     phone: '123-456-7890',
  //     email: 'john.doe@example.com',
  //     leaseStartDate: '2024-01-01',
  //     leaseEndDate: '2025-01-01',
  //     paymentHistory: [
  //       { date: '2024-11-01', amount: '$1000' },
  //       { date: '2024-10-01', amount: '$1000' }
  //     ],
  //     maintenanceRequests: [
  //       { description: 'Plumbing issue', status: 'Closed' },
  //       { description: 'AC repair', status: 'Open' }
  //     ]
  //   },
  //   // Add more tenant data here...
  // ];

  // searchQuery: string = '';

  // constructor(public dialog: MatDialog) {}

  // // Filter tenants based on search query
  // get filteredTenants() {
  //   return this.tenants.filter(tenant =>
  //     tenant.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
  //     tenant.apartment.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
  //     tenant.paymentStatus.toLowerCase().includes(this.searchQuery.toLowerCase())
  //   );
  // }

  // // Open the Tenant Modal with the tenant details
  // viewDetails(tenant: Tenant) {
  //   console.log('Tenant data:', tenant);
  //   this.dialog.open(TenantModalComponent, {
  //     data: tenant // Pass the tenant data to the modal
  //   });
  // }

  // sendMessage(tenant: Tenant) {
  //   console.log('Send message to', tenant);
  //   // Open a chat or messaging component
  // }

  // updateDetails(tenant: Tenant) {
  //   console.log('Update details for', tenant);
  //   // Logic to open update form/modal
  // }

  // generateReminder(tenant: Tenant) {
  //   console.log('Generate payment reminder for', tenant);
  //   // Logic to send reminder to the tenant
  // }
}
