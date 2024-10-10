import { Component, OnInit } from '@angular/core';
import { TenantsService } from '../services/tenants.service';
import { CommonModule } from '@angular/common'; 
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

  constructor(private tenantsService: TenantsService) {}

  fetchData(): void {
    this.tenantsService.fetchTenants().subscribe(
      (data) => {
        this.tenants = data;
      },
      (error) => {
        console.error('Error fetching tenants:', error);
      }
    );
  }

  onCloseHandled(): void {
    this.display = 'none';
  }

  openModal(): void {
    this.display = 'block';
  }

  ngOnInit(): void {
    this.fetchData();
  }

  // Method to be called when a tenant is added
  onTenantAdded(): void {
    this.fetchData(); // Refresh the tenant list when a new tenant is added
  }
}
