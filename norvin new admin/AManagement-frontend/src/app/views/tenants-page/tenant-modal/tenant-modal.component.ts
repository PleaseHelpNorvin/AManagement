import { Component, Inject } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog'; // Import MatDialogRef for closing the dialog
import { CommonModule } from '@angular/common'; // Import CommonModule for *ngFor
import { MatTableModule } from '@angular/material/table'; // Import MatTableModule for mat-table
import { MatButtonModule } from '@angular/material/button'; // Import MatButtonModule for buttons

@Component({
  selector: 'app-tenant-modal',
  standalone: true,
  imports: [CommonModule, MatTableModule, MatButtonModule], // Add the necessary modules
  templateUrl: './tenant-modal.component.html',
  styleUrls: ['./tenant-modal.component.css']
})
export class TenantModalComponent {
  // constructor(
  //   @Inject(MAT_DIALOG_DATA) public tenant: any,
  //   private dialogRef: MatDialogRef<TenantModalComponent> // Inject MatDialogRef to close the dialog
  // ) {}

  // close() {
  //   this.dialogRef.close(); // Close the dialog when the method is called
  // }
}
