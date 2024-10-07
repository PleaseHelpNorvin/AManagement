// angular import
import { Component } from '@angular/core';
import { FormBuilder, FormGroup, Validators, ReactiveFormsModule } from '@angular/forms';
import { RouterModule, Router } from '@angular/router';
import { AuthenticationService } from 'src/app/theme/shared/services/authentication/authentication.service';


@Component({
  selector: 'app-login',
  standalone: true,
  imports: [RouterModule, ReactiveFormsModule],
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
    private router: Router
  ) {
    // Initialize the form
    this.loginForm = this.fb.group({
      email: ['', [Validators.required, Validators.email]],
      password: ['', Validators.required],
    });
  }
 
  onLogin() {
    if (this.loginForm.valid) {
      const { email, password } = this.loginForm.value;
      this.authService.login(email, password).subscribe((response) => {
        if (response && response.success === false) {
          alert(response.message); // Display the message from the server
        } else if (response) {
          console.log('Login successful', response);
          this.router.navigate(['/dashboard/default']);
        } else {
          alert('Login failed. Please check your credentials.');
        }
      });
    }
  }
}
