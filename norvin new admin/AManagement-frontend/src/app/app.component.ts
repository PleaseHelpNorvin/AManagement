import { Component } from '@angular/core';
// import { RouterOutlet } from '@angular/router';
import { MatButtonModule } from '@angular/material/button';

import { AdminLayoutComponent } from "./shared/admin-layout/admin-layout.component";

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [ MatButtonModule, AdminLayoutComponent],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent {
  title = 'AManagement-frontend';
}
