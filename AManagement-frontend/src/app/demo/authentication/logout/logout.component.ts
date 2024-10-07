import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { AuthenticationService } from 'src/app/theme/shared/services/authentication/authentication.service';


@Component({
  selector: 'app-logout',
  standalone: true,
  imports: [],
  templateUrl: './logout.component.html',
  styleUrl: './logout.component.scss'
})
export class LogoutComponent {
  constructor(
    private authService: AuthenticationService, 
    private router: Router) {}

  logout(): void{
    this.authService.logout().subscribe(() => {
      alert('Logout Successfully');
    });
    }
}
