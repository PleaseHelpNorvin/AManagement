import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';

//service
import { AuthService } from '../../core/service/auth/auth.service';

@Component({
  selector: 'app-signin',
  standalone: true,
  imports: [ReactiveFormsModule,CommonModule],  // Import ReactiveFormsModule here for standalone components
  templateUrl: './signin-page.component.html',
  styleUrls: ['./signin-page.component.css'],
})
export class SigninPageComponent {
  loginForm: FormGroup;
  email: string = '';
  password: string = '';
  errorMessage: string = '';

  constructor(private fb: FormBuilder, private authService: AuthService, private router: Router) {
    this.loginForm = this.fb.group({
      email: ['', [Validators.required, Validators.email]],
      password: ['', [Validators.required]]
    });
  }

  onLogin(): void {
    // Get the form values
    const { email, password } = this.loginForm.value;
  
    this.authService.adminLogin(email, password).subscribe(
      (response) => {
        // Check if response and token exist
        if (response && response.data && response.data.token) {
          // On success, save the token and navigate
          this.authService.saveToken(response.data.token); // Access token inside data
          console.log('Response:', response);
          this.authService.redirectAfterLogin();
        } else {
          this.errorMessage = 'No token received in the response.';
        }
      },
      (error) => {
        // On error, display an error message
        this.errorMessage = 'Invalid credentials or not an admin.';
        console.error('Login error:', error);
      }
    );
  }
  // Handle logout
  onLogout(): void {
    this.authService.logout();
    this.router.navigate(['/login']); // Redirect to login page after logout
  }
}
