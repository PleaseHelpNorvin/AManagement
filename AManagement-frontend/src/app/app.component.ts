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
    this.initializeAuthState();
    
    if (this.authService.getIsLogin()) {
      this.idleTimeoutService.startWatching();
    }

    this.idleTimeoutSubscription = this.idleTimeoutService.onTimeout().subscribe(() => {
      console.log('ontimeout in appcomponent');
      this.handleIdleTimeout();
    });
  }

  ngOnDestroy(): void {
    this.idleTimeoutSubscription?.unsubscribe();
  }

  private initializeAuthState(): void {
    const token = this.authService.getToken();
    if (token) {
      this.authStateService.setAuthenticated(true);
    } else {
      this.authStateService.setAuthenticated(false);
    }
  }

  private handleIdleTimeout(): void {
    console.log('Idle timeout detected, attempting to log out...');
  
    this.authService.logout().subscribe({
      next: () => {
        console.log('Logout successful. Displaying alert and clearing token.');
        // Clear the token from storage
        // sessionStorage.removeItem('authToken'); // Or localStorage.removeItem('authToken');
        this.authStateService.setAuthenticated(false); // Update the authentication state
        this.authService.clearToken();
        Swal.fire({
          title: 'Session Timeout',
          text: 'You have been logged out due to inactivity. Please log in again.',
          icon: 'warning',
          confirmButtonText: 'OK'
        }).then(() => {
          this.reloadPage();
        });
      },
      error: (err) => {
        console.error('Logout failed:', err);
        Swal.fire({
          title: 'Error',
          text: 'Logout failed. You may need to refresh the page.',
          icon: 'error',
          confirmButtonText: 'OK'
        }).then(() => {
          this.reloadPage();
        });
      }
    });
  }
  

  private reloadPage(): void {
    window.location.reload();
  }
}
