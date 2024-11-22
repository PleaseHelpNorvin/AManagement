import { Component } from '@angular/core';
import { RouterOutlet } from '@angular/router';
// import {}
import { MatButtonModule } from '@angular/material/button';

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [ MatButtonModule, RouterOutlet],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent {
  title = 'AManagement-frontend';
}
