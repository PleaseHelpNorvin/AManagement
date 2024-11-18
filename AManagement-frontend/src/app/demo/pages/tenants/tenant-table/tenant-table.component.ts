import { Component, OnInit } from '@angular/core';
import { TenantsService } from '../services/tenants.service';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap'; // Import NgbModal
import { TenantModalComponent } from './tenant-modal/edit-modal/tenant-modal.component';
import { ViewTenantModalComponent } from './tenant-modal/view-tenant-modal/view-tenant-modal.component';
import { NgxPaginationModule, PaginationInstance } from 'ngx-pagination';
import { faCircle, faCircleNotch } from '@fortawesome/free-solid-svg-icons';
import Swal from 'sweetalert2';
import { CommonModule } from '@angular/common'; // Import CommonModule

@Component({
  selector: 'app-tenant-table',
  standalone: true,
  imports: [
    CommonModule,           // Ensure CommonModule is imported
    NgxPaginationModule,    // For pagination functionality
    TenantModalComponent,    // For modal functionality
    ViewTenantModalComponent
  ],
  templateUrl: './tenant-table.component.html',
  styleUrls: ['./tenant-table.component.scss'],
})
export class TenantTableComponent implements OnInit {
  faCircle = faCircle;
  faCircleNotch = faCircleNotch;

  tenants: any[] = [];  
  selectedTenant: any = null;
  selectedTenantId: number | null = null

  config: PaginationInstance = {
    id: 'advanced',
    itemsPerPage: 10,
    currentPage: 1,
  };

  constructor(private tenantsService: TenantsService, private modalService: NgbModal) {}

  ngOnInit(): void {
    this.fetchData();
  }

  fetchData(): void {
    this.tenantsService.fetchTenants().subscribe(
      (response) => {
        this.tenants = response.data;
        console.log('Fetched tenants:', this.tenants);
      },
      (error) => {
        Swal.fire('Error', 'Failed to load tenants', 'error');
      }
    );
  }


  viewTenant(tenantId: number): void {
    this.tenantsService.fetchTenantById(tenantId).subscribe(
      (response) => {
        if (response && response.data) {
          const tenant = response.data;
          console.log('Fetched tenant for view:', tenant);
  
          const modalRef = this.modalService.open(ViewTenantModalComponent);
          modalRef.componentInstance.tenant = { ...tenant }; 

          modalRef.componentInstance.closeModal.subscribe(() => {
            modalRef.close(); 
          });
        }
      },
      (error) => {
        Swal.fire('Error', 'Failed to load tenant data', 'error');
      }
    );
  }

  editTenant(tenantId: number): void {
    console.log('Fetching tenant with ID:', tenantId);
  
    this.tenantsService.fetchTenantById(tenantId).subscribe(
      (response) => {
        if (response && response.data) {
          // Extract tenant data from the response
          const tenant = response.data;
  
          console.log('Fetched tenant for modal:', tenant);
  
          // Open modal and pass only the tenant data
          const modalRef = this.modalService.open(TenantModalComponent);
          modalRef.componentInstance.tenant = { ...tenant };  // Pass the tenant data to the modal
  
          // Subscribe to the modal's event for when the tenant is updated
          modalRef.componentInstance.tenantUpdated.subscribe((updatedTenant) => {
            this.onTenantUpdated(updatedTenant);  // Update the tenant list or perform actions
          });
  
          // Close modal handler
          modalRef.componentInstance.closeModal.subscribe(() => {
            modalRef.close();
          });
        } else {
          Swal.fire('Error', 'Tenant not found', 'error');
        }
      },
      (error) => {
        Swal.fire('Error', 'Failed to load tenant data', 'error');
      }
    );
  }
  
  deleteTenant(tenantId: number): void {
    Swal.fire({
      title: 'Are you sure?',
      text: 'You won\'t be able to revert this!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'Cancel'
    }).then((result) => {
      if (result.isConfirmed) {
        // Call the delete tenant API if confirmed
        this.tenantsService.deleteTenant(tenantId).subscribe(
          response => {
            console.log('Tenant deleted successfully:', response);
            // Remove the tenant from the list locally
            this.tenants = this.tenants.filter(tenant => tenant.id !== tenantId);
            Swal.fire(
              'Deleted!',
              'The tenant has been deleted.',
              'success'
            );
          },
          error => {
            console.error('Error deleting tenant:', error);
            Swal.fire(
              'Error!',
              'There was an issue deleting the tenant. Please try again.',
              'error'
            );
          }
        );
      }
    });
  }
  

  onTenantUpdated(updatedTenant: any): void {
    const index = this.tenants.findIndex(tenant => tenant.id === updatedTenant.id);
    if (index !== -1) {
      this.tenants[index] = updatedTenant;  // Update the tenant in the list
      Swal.fire('Success', 'Tenant updated successfully', 'success');
    }
  }

  onPageChange(page: number): void {
    this.config.currentPage = page; // Update the currentPage when the page changes
  }
}
