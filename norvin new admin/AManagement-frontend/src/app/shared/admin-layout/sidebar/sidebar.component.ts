import { Component, ViewEncapsulation } from '@angular/core';
import { MatIconModule } from '@angular/material/icon';
import { MatListModule } from '@angular/material/list';

@Component({
  selector: 'app-sidebar',
  standalone:true,
  imports: [MatListModule, MatIconModule],
  templateUrl: './sidebar.component.html',
  styleUrls: ['./sidebar.component.css'],  // Use styleUrls, not styleUrl
  encapsulation: ViewEncapsulation.None,  // To ensure styles are not encapsulated
})
export class SidebarComponent {

}
