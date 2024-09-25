import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Component } from '@angular/core';
import { environment } from 'src/environments/environment';
import { AuthService } from '../login/auth.service';
import { Router } from '@angular/router';


@Component({
  selector: 'app-logout',
  standalone: true,
  imports: [],
  templateUrl: './logout.component.html',
  styleUrl: './logout.component.scss'
})
export default class LogoutComponent {
  constructor(
    private http: HttpClient,
    private authService: AuthService,
    private router: Router
  ){}

  ngOnInit(){
    // this.onPreventTemplate();
    this.onLogout();
  }

  onPreventTemplate(){
    this.router.navigate(['.login'])
  }

  onLogout() {
    const token = sessionStorage.getItem('authToken'); // Correct token key
    const headers = new HttpHeaders().set('Authorization', `Bearer ${token}`);
    
    this.http.post(`${environment.apiUrl}/logout`, {}, { headers })
        .subscribe(
            response => {
                console.log('Logout successful', response);
                this.authService.clearAuth();
            },
            error => {
                console.error('Logout failed:', error);
                // Handle logout failure
            }
        );
  }
}
