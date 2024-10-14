import { Component, EventEmitter, Output, Input } from '@angular/core';
import { TenantsService } from '../../services/tenants.service';
import { FormsModule } from '@angular/forms';
import { CommonModule, NgIf } from '@angular/common';
// NgIf
// CommonModule
// FormsModule
// other imports...



@Component({
  selector: 'app-tenant-modal',
  standalone: true,
  imports: [CommonModule, FormsModule, NgIf],
  templateUrl: './tenant-modal.component.html',
  styleUrls: ['./tenant-modal.component.scss'] 
})
export class TenantModalComponent {
  @Input() isVisible: boolean = false; // New input property
  tenantObj: { firstname: string; lastname: string } = { firstname: '', lastname: '' };

  @Output() tenantAdded = new EventEmitter<void>();

  constructor(private tenantsService: TenantsService) {}

  // Method to add a new tenant
  addNewTenant(): void {
    this.tenantsService.addTenant(this.tenantObj).subscribe(
      (response) => {
        console.log('Tenant added successfully:', response);
        this.tenantAdded.emit();
        this.onCloseHandled(); // Close the modal after adding the tenant
      },
      (error) => {
        console.error('Error adding tenant:', error);
      }
    );  
  }

  // Method to close the modal
  onCloseHandled(): void {
    this.isVisible = false; // Update visibility status
    this.resetForm();
  }

  // Method to reset the form fields
  private resetForm(): void {
    this.tenantObj = { firstname: '', lastname: '' }; // Resetting tenant object
  }
}
