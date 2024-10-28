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
import Swal from 'sweetalert2';

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
      rememberMe: [false]
    });
  }

  // NgOnInit(): void {
  //   this.inputValidator();
  // }
 
  onLogin() {
    if (this.loginForm.valid) {
      const { email, password, rememberMe } = this.loginForm.value;
      this.authService.login(email, password, rememberMe).subscribe({
        next: (response) => {
          if (response && response.token) {
            Swal.fire({
              title: `Login successful`,
              text: 'Welcome back!',
              icon: 'success',
              confirmButtonText: 'OK'
            }).then(() => {
              this.router.navigate(['/dashboard/default']);
            });
          } else {
            // This is where you check the error message
            Swal.fire({
              title: `${response.message}`,
              text: 'Wrong Credentials, Please Try login again',
              icon: 'error',
              confirmButtonText: 'OK'
            });
          }
        },
        error: (error) => {
          // Handle any additional errors if needed
          Swal.fire({
            title: 'asdasd',
            text: error.message || 'An unknown error occurred. Please try again.',
            icon: 'error',
            confirmButtonText: 'OK'
          });
        },
      });
    }
  }
  
  
}
