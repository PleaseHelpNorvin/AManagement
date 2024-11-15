import { Component, EventEmitter, Output, Input } from '@angular/core';
import { TenantsService } from '../../services/tenants.service';
import { FormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-tenant-modal',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './tenant-modal.component.html',
  styleUrls: ['./tenant-modal.component.scss']
})
export class TenantModalComponent {

  @Input() isVisible: boolean = false; // Input to control modal visibility
  @Output() tenantAdded = new EventEmitter<void>(); // Emits when tenant is added
  @Output() closeModal = new EventEmitter<void>();  // Emits when modal is closed

  fade: boolean = false;  // Control the fade effect
  tenantObj: { firstname: string; lastname: string } = { firstname: '', lastname: '' };

  constructor(private tenantsService: TenantsService) {}

  // Method to add a new tenant
  // addNewTenant(): void {
  //   this.tenantsService.addTenant(this.tenantObj).subscribe(
  //     (response) => {
  //       console.log('Tenant added successfully:', response);
  //       this.tenantAdded.emit();  // Emit to parent
  //       this.onCloseHandled();    // Close modal after adding tenant
  //     },
  //     (error) => {
  //       console.error('Error adding tenant:', error);
  //     }
  //   );
  // }

  // Close the modal and notify the parent component
onCloseHandled(): void {
    this.fade = true; // Start fade-out transition
    setTimeout(() => {
        this.isVisible = false; // Hide modal after the fade-out completes
        this.fade = false; // Reset fade state
        this.closeModal.emit(); // Notify parent to close the modal
        this.resetForm(); // Reset the form after closing
    }, 150); // Matches Bootstrap's transition duration
}

  // Reset the form
  private resetForm(): void {
    this.tenantObj = { firstname: '', lastname: '' };
  }

  onAnimationEnd(): void {
    // Optionally handle something at the end of the animation
  }
}
