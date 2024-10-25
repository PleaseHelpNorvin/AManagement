import { Component, OnInit, NO_ERRORS_SCHEMA , Input } from '@angular/core';
import { TenantsService } from '../services/tenants.service';
import { CommonModule } from '@angular/common'; 
import { FormsModule } from '@angular/forms';
// import { PaginationComponent } from './pagination/pagination.component';
import { StringFilterPipe } from './pipe/string-filter.pipe';
import { NgxPaginationModule, PaginationInstance } from 'ngx-pagination';
import Swal from 'sweetalert2';
import { TenantModalComponent } from './tenant-modal/tenant-modal.component';

@Component({
  selector: 'app-tenant-table',
  standalone: true,
  imports: [CommonModule, FormsModule, TenantModalComponent, StringFilterPipe, NgxPaginationModule],
  templateUrl: './tenant-table.component.html',
  styleUrls: ['./tenant-table.component.scss'],
  schemas: [NO_ERRORS_SCHEMA],
})
export class TenantTableComponent implements OnInit {
  // tenants = [];
  // filter: string = '';
  isModalVisible: boolean = false;  // Control modal visibility
  @Input() tenants: any[] = [];
  @Input() config: PaginationInstance = {
    id: 'advanced',
    itemsPerPage: 10,
    currentPage: 1,
  };

  public maxSize: number = 7;
  public directionLinks: boolean = true;
  public autoHide: boolean = false;
  public responsive: boolean = false; 
  public labels: any = { 
    previousLabel: 'Previous',
    nextLabel: 'Next',
    screenReaderPaginationLabel: 'page',
    screenReaderCurrentLabel: 'youre on the page'
  };
filter: string;

  constructor(private tenantsService: TenantsService) {}
  
  ngOnInit(): void {
    this.fetchData();
  }

  fetchData(): void {
    this.tenants = [
      { id: 1, firstname: 'John', lastname: 'Doe', email: 'john.doe@example.com', phone: '123-456-7890' },
      { id: 2, firstname: 'Jane', lastname: 'Smith', email: 'jane.smith@example.com', phone: '234-567-8901' },
      { id: 3, firstname: 'Michael', lastname: 'Johnson', email: 'michael.johnson@example.com', phone: '345-678-9012' },
      { id: 4, firstname: 'Michael', lastname: 'Johnson', email: 'michael.johnson@example.com', phone: '345-678-9012' },
      { id: 5, firstname: 'Michael', lastname: 'Johnson', email: 'michael.johnson@example.com', phone: '345-678-9012' },
      { id: 6, firstname: 'Michael', lastname: 'Johnson', email: 'michael.johnson@example.com', phone: '345-678-9012' },
      { id: 7, firstname: 'Michael', lastname: 'Johnson', email: 'michael.johnson@example.com', phone: '345-678-9012' },
      { id: 8, firstname: 'Michael', lastname: 'Johnson', email: 'michael.johnson@example.com', phone: '345-678-9012' },
      { id: 9, firstname: 'Michael', lastname: 'Johnson', email: 'michael.johnson@example.com', phone: '345-678-9012' },
      { id: 10, firstname: 'Michael', lastname: 'Johnson', email: 'michael.johnson@example.com', phone: '345-678-9012' },
      { id: 11, firstname: 'Michael', lastname: 'Johnson', email: 'michael.johnson@example.com', phone: '345-678-9012' },
      { id: 12, firstname: 'Michael', lastname: 'Johnson', email: 'michael.johnson@example.com', phone: '345-678-9012' },
      { id: 13, firstname: 'Michael', lastname: 'Johnson', email: 'michael.johnson@example.com', phone: '345-678-9012' },
      { id: 14, firstname: 'Michael', lastname: 'Johnson', email: 'michael.johnson@example.com', phone: '345-678-9012' },
      { id: 15, firstname: 'Michael', lastname: 'Johnson', email: 'michael.johnson@example.com', phone: '345-678-9012' },
      { id: 16, firstname: 'Michael', lastname: 'Johnson', email: 'michael.johnson@example.com', phone: '345-678-9012' },
      { id: 17, firstname: 'Michael', lastname: 'Johnson', email: 'michael.johnson@example.com', phone: '345-678-9012' },
      { id: 18, firstname: 'Michael', lastname: 'Johnson', email: 'michael.johnson@example.com', phone: '345-678-9012' },
      { id: 19, firstname: 'Michael', lastname: 'Johnson', email: 'michael.johnson@example.com', phone: '345-678-9012' },
      { id: 20, firstname: 'Michael', lastname: 'Johnson', email: 'michael.johnson@example.com', phone: '345-678-9012' },
      { id: 21, firstname: 'Michael', lastname: 'Johnson', email: 'michael.johnson@example.com', phone: '345-678-9012' },
      { id: 22, firstname: 'Michael', lastname: 'Johnson', email: 'michael.johnson@example.com', phone: '345-678-9012' },

      // Add more tenants...
    ];
    
    // Uncomment when your backend is ready
    // this.tenantsService.fetchTenants().subscribe(
    //   (data) => this.tenants = data,
    //   (error) => console.error('Error fetching tenants:', error)
    // );
  }

  showTenantModal(): void {
    this.isModalVisible = true;
  }

  onTenantAdded(): void {
    this.fetchData(); // Refresh tenant list
  }

  closeTenantModal(): void {
    this.isModalVisible = false;  // Close modal
  }

  onPageChange(number: number): void {
    this.config.currentPage = number;
  }

  onPageBoundsCorrection(number: number) {
    this.config.currentPage = number;
  }
}

