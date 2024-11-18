import { Component, EventEmitter, Output, Input, OnInit, OnChanges, SimpleChanges } from '@angular/core';
import { TenantsService } from '../../../services/tenants.service';
import { CommonModule } from '@angular/common';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-view-tenant-modal',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './view-tenant-modal.component.html',
  styleUrls: ['./view-tenant-modal.component.scss']
})
export class ViewTenantModalComponent implements OnInit, OnChanges {
  @Input() tenant: any;  // The tenant object passed from the parent component
  @Output() closeModal = new EventEmitter<void>();  // Event to notify parent component when modal should be closed

  // Data fields for viewing tenant details
  firstName: string = '';
  middleName: string = '';
  lastName: string = '';
  gender: string = '';
  email: string = '';
  address: string = '';
  username: string = '';

  constructor(private tenantsService: TenantsService) {}

  ngOnInit(): void {
    this.viewFormFields();
  }

  ngOnChanges(changes: SimpleChanges): void {
    if (changes['tenant'] && !changes['tenant'].firstChange) {
      console.log('Tenant data onChanges:', this.tenant);
      this.viewFormFields();
    }
  }

  // Update the form fields with tenant data (for viewing only)
  viewFormFields() {
    if (this.tenant && this.tenant.client_information) {
      this.firstName = this.tenant.client_information.name || '';
      this.middleName = this.tenant.client_information.middlename || '';
      this.lastName = this.tenant.client_information.lastname || '';
      this.gender = this.tenant.client_information.gender || '';
      this.email = this.tenant.email || '';
      this.username = this.tenant.username || '';
      this.address = this.tenant.client_information.address || '';
    }
  }

  // This method is triggered by the parent when the modal is closed
  closeModalHandler() {
    // console.log('')
    // alert('this.closeModalHandler reached');
    this.closeModal.emit();
  }
}
