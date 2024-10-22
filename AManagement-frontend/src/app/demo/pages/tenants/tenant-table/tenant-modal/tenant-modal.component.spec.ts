import { Component, EventEmitter, Output } from '@angular/core';
import { TenantsService } from '../../services/tenants.service';
import { CommonModule, NgIf } from '@angular/common'; 

import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-tenant-modal',
  standalone: true,
  imports: [CommonModule, FormsModule ,NgIf],
  templateUrl: './tenant-modal.component.html',
  styleUrls: ['./tenant-modal.component.scss'] // Fixed the typo
})
export default class TenantModalComponent {
[x: string]: any;
onAnimationEnd() {
throw new Error('Method not implemented.');
}

  tenantObj: { firstname: string; lastname: string } = { firstname: '', lastname: '' };
  // display: 'none';
  isVisible: boolean = false; // Changed from string to boolean

  @Output() tenantAdded = new EventEmitter<void>(); // EventEmitter to notify parent component

  constructor(private tenantsService: TenantsService) {}

  addNewTenant(): void {
    this.tenantsService.addTenant(this.tenantObj).subscribe(
      (response) => {
        console.log('Tenant added successfully:', response);
        this.tenantAdded.emit(); // Notify the parent component to refresh the list
      },
      (error) => {
        console.error('Error adding tenant:', error);
      }
    );  
  }

  onCloseHandled(): void {
    // this.display = 'none';
    this.isVisible = false; // Update visibility status
  }
}
