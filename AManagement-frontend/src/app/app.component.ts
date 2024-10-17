// src/app/app.component.ts

import { Component, OnInit, OnDestroy } from '@angular/core';
import { AuthenticationService } from './theme/shared/services/authentication/authentication.service';
import { AuthStateService } from './theme/shared/services/authentication/state/authe-state-service.service';
import { IdleTimeoutService } from './theme/shared/services/iddle-timeout/iddle-timeout.service';
import { Subscription } from 'rxjs';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit, OnDestroy {
  title = 'mantis-free-version';
  private idleTimeoutSubscription: Subscription;

  constructor(
    private authService: AuthenticationService,
    private authStateService: AuthStateService,
    private idleTimeoutService: IdleTimeoutService
  ) {}

  ngOnInit(): void {
    console.log('AppComponent: ngOnInit called');
    this.initializeAuthState();
    
    if (this.authService.getIsLogin()) {
      console.log('User is logged in. Starting idle timeout service.');
      this.idleTimeoutService.startWatching();
    } else {
      console.log('User is not logged in. Not starting idle timeout service.');
    }

    this.idleTimeoutSubscription = this.idleTimeoutService.onTimeoutObservable().subscribe(() => {
      console.log('AppComponent: Idle timeout detected.');
      this.handleIdleTimeout();
    });
  }

  ngOnDestroy(): void {
    console.log('AppComponent: ngOnDestroy called. Unsubscribing from idle timeout service.');
    this.idleTimeoutSubscription?.unsubscribe();
  }

  private initializeAuthState(): void {
    const token = this.authService.getToken();
    console.log(`AppComponent: Token found: ${!!token}`);
    this.authStateService.setAuthenticated(!!token);
  }

  private handleIdleTimeout(): void {
    console.log('Idle timeout detected, showing alert for logout...');
  
    Swal.fire({
      title: 'Session Timeout',
      text: 'You have been logged out due to inactivity. Please log in again.',
      icon: 'warning',
      showCancelButton: false, // Set to false for no cancel button during inactivity
      confirmButtonText: 'OK',
      backdrop: true, // Disable interaction with the background
      allowOutsideClick: false // Prevent closing the alert by clicking outside
    }).then((result) => {
      if (result.isConfirmed) {
        console.log('Swal confirmed, logging out...');
        this.authService.logout().subscribe({
          next: () => {
            console.log('Logout successful. Clearing token and redirecting to login.');
            this.authStateService.setAuthenticated(false); // Update authentication state
            window.location.href = '/login'; // Redirect to login after logout
          },
          error: (err) => {
            console.error('Logout failed:', err);
            Swal.fire({
              title: 'Error',
              text: 'Logout failed. You may need to refresh the page.',
              icon: 'error',
              confirmButtonText: 'OK'
            }).then(() => {
              console.log('Swal confirmed after logout failure, reloading page.');
              // this.authStateService.setAuthenticated(false); // Update authentication state
              // window.location.href = '/login';
              this.reloadPage();
            });
          }
        });
      }
    });
  }
  
  
  private reloadPage(): void {
    window.location.reload();
  }

  private showAlert(title: string, text: string, icon: 'warning' | 'error' | 'info' | 'success' | 'question') {
    return Swal.fire({
      title,
      text,
      icon,
      confirmButtonText: 'OK'
    });
  }

  private redirectToLogin(): void {
    window.location.href = '/login'; // Adjust this path as needed
  }
}
