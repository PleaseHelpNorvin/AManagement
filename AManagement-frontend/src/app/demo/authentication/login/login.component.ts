// angular import
import { Component } from '@angular/core';
import { RouterModule, Router } from '@angular/router';
import { AuthService } from './auth.service';
import { NgForm } from '@angular/forms';
import { CommonModule } from '@angular/common'; // Import CommonModule
import { FormsModule } from '@angular/forms'; // Import FormsModule



@Component({
  selector: 'app-login',
  standalone: true,
  imports: [RouterModule, FormsModule, CommonModule],
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export default class LoginComponent {
  email: string = '';
  password: string = '';
  errorMessage: string | null = null;

  constructor(private authService: AuthService, private router: Router) {
    window.addEventListener('storage', (event) => {
      if (event.key === 'authToken' && event.newValue === null) {
        // Token removed from another tab or browser
        this.handleLogout();
      }
    });
  }

  onSubmit(form: NgForm) {
    if (form.valid) {
      const { email, password } = form.value;
  
      this.authService.login(email, password).subscribe(
        response => {
          console.log('API response:', response);
  
          // Directly access token and role without `data`
          const token = response.token;
          const role = response.role;
  
          if (token && role) {
            this.authService.saveToken(token);
            this.authService.saveRole(role);
  
            if (role === 'admin') {
              alert("Admin Logged successfully!");
              console.log('Admin successfully logged in', response);
              this.router.navigate(['/dashboard/default']);
            } else {
              alert("Please Log in on your mobile device");
              // Uncomment if there's a route for regular users
              // this.router.navigate(['/user-dashboard']);
            }
          } else {
            console.error('Token or role not found in the response');
            this.errorMessage = 'Login failed. Invalid response from server.';
          }
        },
        error => {
          console.error('Login failed', error);
          this.errorMessage = 'Login failed. Please check your credentials and try again.';
        }
      );
    }
  }
  
  handleLogout() {
    alert('You have been logged out from another tab or browser.');
    this.router.navigate(['/login']);
  }
}
