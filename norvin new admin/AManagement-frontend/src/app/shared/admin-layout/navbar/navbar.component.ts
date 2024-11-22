import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import {MatToolbarModule} from '@angular/material/toolbar';
import { MatIcon } from '@angular/material/icon';

@Component({
  selector: 'app-navbar',
  imports: [MatIcon,CommonModule,MatToolbarModule],
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css'],
})
export class NavbarComponent {
  menuOpen = false; // To track if the dropdown menu is open

  toggleMenu() {
    this.menuOpen = !this.menuOpen; // Toggle menu visibility
  }

  logout() {
    console.log('Logging out...');
    // Add your logout logic here
  }

  profile() {
    console.log('Opening profile...');
    // Navigate to the profile page or show profile modal
  }

  settings() {
    console.log('Opening settings...');
    // Navigate to settings page or show settings modal
  }
}
