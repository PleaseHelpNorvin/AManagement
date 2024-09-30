// angular import
import { Component } from '@angular/core';
import { RouterModule, Router } from '@angular/router';
import { AuthService } from './services/auth.service';
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
          // console.log('API response:', response);
          // Access token and role from the response (no data object)
          const token = response.token;
          const role = response.role;
  
          if (token && role) {
            // Save token and role
            this.authService.saveToken(token);
            this.authService.saveRole(role);
  
            // Redirect based on role
            if (role === 'admin') {
              alert("Admin logged in successfully!");
              this.router.navigate(['/dashboard/default']);
            } else {
              alert("Please log in on your mobile device.");
              // this.router.navigate(['/user-dashboard']);
            }


          } else {
            console.error('Token or role not found in the response');
            this.errorMessage = 'Login failed. Invalid response from server.';
          }
        },
        error => {
          console.error('Login failed', error);
          this.errorMessage = error;
        }
      );
    }
  }
 

}
