import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { MatToolbarModule } from '@angular/material/toolbar';
import { MatIcon } from '@angular/material/icon';

@Component({
  selector: 'app-navbar',
  standalone: true,
  imports: [MatIcon, CommonModule, MatToolbarModule],
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css'],
})
export class NavbarComponent {
  menuOpen = false; // To track if the dropdown menu is open
  unreadNotifications = 3; // Example: Number of unread notifications

  // Toggle the dropdown menu visibility
  toggleMenu() {
    this.menuOpen = !this.menuOpen;
  }

  // Handle logout action
  logout() {
    console.log('Logging out...');
    // Add your logout logic here
  }

  // Handle profile action
  profile() {
    console.log('Opening profile...');
    // Navigate to the profile page or show profile modal
  }

  // Handle settings action
  settings() {
    console.log('Opening settings...');
    // Navigate to settings page or show settings modal
  }

  // Handle notifications toggle
  toggleNotifications() {
    console.log('Notifications clicked');
    // Implement the logic for showing notifications or opening a panel
  }

  // Search logic for tenants, apartments, or requests
  search(event: any) {
    const query = event.target.value;
    console.log('Searching for: ', query);
    // Implement search functionality
  }

  // Open Help/Support section
  openHelp() {
    console.log('Help clicked');
    // Open a help modal, FAQ page, or support form
  }
}
