import { Component, OnInit } from '@angular/core';
import { TenantsService } from '../services/tenants.service';
import { CommonModule, NgIf } from '@angular/common'; 
import { FormsModule } from '@angular/forms';


import Swal from 'sweetalert2';

import { TenantModalComponent } from './tenant-modal/tenant-modal.component';

@Component({
  selector: 'app-tenant-table',
  standalone: true,
  imports: [CommonModule, FormsModule, TenantModalComponent],
  templateUrl: './tenant-table.component.html',
  styleUrls: ['./tenant-table.component.scss'],
})
export class TenantTableComponent implements OnInit {
  display = 'none';
  showNew: Boolean = false;
  tenants = [];
  isVisible = false;

  constructor(private tenantsService: TenantsService) {}

  fetchData(): void {
    this.tenants = [
      { id: 1, firstname: 'John', lastname: 'Doe', email: 'john.doe@example.com', phone: '123-456-7890' },
      { id: 2, firstname: 'Jane', lastname: 'Smith', email: 'jane.smith@example.com', phone: '234-567-8901' },
      { id: 3, firstname: 'Michael', lastname: 'Johnson', email: 'michael.johnson@example.com', phone: '345-678-9012' },
      { id: 4, firstname: 'Emily', lastname: 'Brown', email: 'emily.brown@example.com', phone: '456-789-0123' },
    ];

    //. ive commented this cause the backend is not ready yet

    // this.tenantsService.fetchTenants().subscribe(
    //   (data) => {
    //     this.tenants = data;
    //   },
    //   (error) => {
    //     console.error('Error fetching tenants:', error);
    //   }
    // );
  }

  onCloseHandled(): void {
    this.display = 'none';
  }
// Method to open the modal
openModal(): void {
  console.log('Opening modal'); // Debugging line
  this.isVisible = true; // Update visibility status
}


  ngOnInit(): void {
    this.fetchData();
  }

  // Method to be called when a tenant is added
  onTenantAdded(): void {
    this.fetchData(); // Refresh the tenant list when a new tenant is added
  }
}
