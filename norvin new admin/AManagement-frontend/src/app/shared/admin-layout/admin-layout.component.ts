import { Component } from '@angular/core';
import { NavbarComponent } from './navbar/navbar.component';
import { SidebarComponent } from './sidebar/sidebar.component';
import { RouterModule } from '@angular/router';  
import { MatButtonModule } from '@angular/material/button';
import { MatSidenavModule } from '@angular/material/sidenav';

@Component({
  selector: 'app-admin-layout',
  standalone: true,
  imports: [MatButtonModule, SidebarComponent, NavbarComponent, RouterModule, MatSidenavModule],
  templateUrl: './admin-layout.component.html',
  styleUrls: ['./admin-layout.component.css']
})
export class AdminLayoutComponent {
  showSidebar = false;  // Boolean to toggle sidebar visibility
  
  toggleSidebar() {
    this.showSidebar = !this.showSidebar;  // Toggle sidebar visibility
  }
}