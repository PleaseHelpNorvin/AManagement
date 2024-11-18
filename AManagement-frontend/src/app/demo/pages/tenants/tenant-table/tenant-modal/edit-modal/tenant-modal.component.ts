import { Component, EventEmitter, Output, Input, OnInit, OnChanges, SimpleChanges } from '@angular/core';
import { TenantsService } from '../../../services/tenants.service';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-tenant-modal',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './tenant-modal.component.html',
  styleUrls: ['./tenant-modal.component.scss']
})
export class TenantModalComponent implements OnInit, OnChanges {
  @Input() tenant: any;  // The tenant object passed from the parent component
  @Output() tenantUpdated = new EventEmitter<any>();  // Event to notify parent component when tenant is updated
  @Output() closeModal = new EventEmitter<void>();  // Event to notify parent component when modal should be closed

  // Form data
  firstName: string = '';
  middleName: string = '';
  lastName: string = '';
  gender: string = '';
  email: string = '';
  address: string = '';
  username: string = '';

  constructor(private tenantsService: TenantsService) {}

  ngOnInit(): void {
    this.updateFormFields();
  }

  ngOnChanges(changes: SimpleChanges): void {
    if (changes['tenant'] && !changes['tenant'].firstChange) {
      console.log('Tenant data onChanges:', this.tenant);
      this.updateFormFields();
    }
  }

  // Update the form fields with tenant data
  updateFormFields() {
    if (this.tenant && this.tenant.client_information) {
      this.firstName = this.tenant.client_information.name || '';
      this.middleName = this.tenant.client_information.middlename || '';
      this.lastName = this.tenant.client_information.lastname || '';
      this.gender = this.tenant.client_information.gender || '';
      this.email = this.tenant.email || '';
      this.username = this.tenant.username ||'';
      this.address = this.tenant.client_information.address || '';
    }
  }

  // This method is triggered by the parent when the modal is closed
  closeModalHandler() {
    this.closeModal.emit();
  }

  // Method to handle form submission and update tenant information
  submitEdit() {
    if (this.tenant && this.tenant.id) {  // Check for tenant data and ID
      const tenantData = this.tenant;  // Use tenant directly, assuming tenant has the correct structure.
  
      // Update tenant data with form values
      tenantData.client_information.name = this.firstName;
      tenantData.client_information.middlename = this.middleName;
      tenantData.client_information.lastname = this.lastName;
      tenantData.client_information.gender = this.gender;
      tenantData.email = this.email;
      tenantData.client_information.address = this.address;
  
      console.log(`submitEdit ${tenantData}`);
  
      // Call the service to update the tenant
      this.tenantsService.updateTenant(tenantData.id, tenantData).subscribe(
        (response) => {
          Swal.fire('Success', 'Tenant updated successfully', 'success');
          this.tenantUpdated.emit(response);  // Emit the updated tenant data to parent
          this.closeModalHandler();  // Close the modal
          location.reload();
        },
        (error) => {
          Swal.fire('Error', error.error?.message || 'Failed to update tenant', 'error');
        }
      );
    } else {
      Swal.fire('Error', 'Tenant ID is missing', 'error');
    }
  }
  
}
