// angular import
import { Component } from '@angular/core';
import { FormBuilder, FormGroup, Validators, ReactiveFormsModule } from '@angular/forms';
import { RouterModule, Router } from '@angular/router';
import { AuthenticationService } from 'src/app/theme/shared/services/authentication/authentication.service';
import { HttpErrorResponse } from '@angular/common/http';
import { NotificationComponent } from '../../../theme/shared/components/notification/notification.component';
import { NotificationService} from '../../../theme/shared/services/notifications/notification.service';
import { OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
@Component({
  selector: 'app-login',
  standalone: true,
  imports: [RouterModule, ReactiveFormsModule, NotificationComponent, CommonModule ],
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export default class LoginComponent {
  // public method
  // SignInOptions = [
  //   {
  //     image: 'assets/images/authentication/google.svg',
  //     name: 'Google'
  //   },
  //   {
  //     image: 'assets/images/authentication/twitter.svg',
  //     name: 'Twitter'
  //   },
  //   {
  //     image: 'assets/images/authentication/facebook.svg',
  //     name: 'Facebook'
  //   }
  // ];

  loginForm: FormGroup;

  constructor(
    private fb: FormBuilder,
    private authService: AuthenticationService,
    private router: Router,
    private notificationService: NotificationService
  ) {
    // Initialize the form
    this.loginForm = this.fb.group({
      email: ['', [Validators.required, Validators.email]],
      password: ['', Validators.required],
    });
  }

  // NgOnInit(): void {
  //   this.inputValidator();
  // }
 
  onLogin() {
    if (this.loginForm.valid) {
      const { email, password } = this.loginForm.value;
      this.authService.login(email, password).subscribe({
        next: (response) => {
          if (response && response.success === false) {
            this.notificationService.showNotification(response.message);
          } else if (response) {
            console.log('Login successful', response);
            this.router.navigate(['/dashboard/default']);
          }
        },
        error: (error: HttpErrorResponse) => {
          // Handle errors in the component
          let errorMessage = error.error.message;

          if (error.error && error.error.message) {
            errorMessage = error.error.message;
          } else if (error.status === 403) {
            errorMessage = 'Forbidden: You do not have permission to access this resource.';
          } else if (error.status === 500) {
            errorMessage = 'Internal server error. Please try again later.';
          } else if (error.status === 0) {
            errorMessage = 'Network error: Unable to reach the server.';
          }
          this.notificationService.showNotification(errorMessage); 
        },
      });
    }
  }


  // inputValidator() {
  // var email = document.getElementById('email');
  // var password = document.getElementById('password')

  //   if(email == null || password == null) {
  //     return
  //   }
  // }
}
