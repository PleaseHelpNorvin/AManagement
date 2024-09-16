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

  constructor(private authService: AuthService, private router: Router) { }

  onSubmit(form: NgForm) {
    if (form.valid) {
      const { email, password } = form.value;

      this.authService.login(email, password).subscribe(
        response => {
          // Store token and user role if needed
          localStorage.setItem('authToken', response.token);
          localStorage.setItem('userRole', response.role);

          // Redirect based on role or other logic
          if (response.role === 'admin') {
            this.router.navigate(['/dashboard/default']);
          } else {
            this.router.navigate(['/user-dashboard']); // Adjust path as necessary
          }
        },
        error => {
          // Handle login error
          console.error('Login failed', error);
          this.errorMessage = 'Login failed. Please check your credentials and try again.';
        }
      );
    }
  }
}
