import { Component, Inject } from '@angular/core';
import {MatDialogModule  } from 'angular/material/dialog';
// import { MatDialogRef } from '@angular/material/dialog';


@Component({
  selector: 'app-tenant-modal',
  standalone: true,
  templateUrl: './tenant-modal.component.html',
  styleUrls: ['./tenant-modal.component.scss'],
})
export class TenantModalComponent {
  // constructor(public dialogRef: MatDialogRef<TenantModalComponent>) {}

  onNoClick(): void {
    // this.dialogRef.close(); // Close the modal
  }
}
