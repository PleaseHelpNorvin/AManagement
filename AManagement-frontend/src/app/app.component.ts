import { Component, OnInit, OnDestroy } from '@angular/core';
import { AuthenticationService } from './theme/shared/services/authentication/authentication.service';
import { AuthStateService } from './theme/shared/services/authentication/state/authe-state-service.service';
import { IdleTimeoutService } from './theme/shared/services/iddle-timeout/iddle-timeout.service';
import { Subscription } from 'rxjs';

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
    this.authService.logout().subscribe({
      next: () => {
        alert('Session expired due to inactivity. Please log in again.');
        this.reloadPage();
      },
      error: (err) => {
        console.error('Logout failed:', err);
        alert('Logout failed. You may need to refresh the page.');
        this.reloadPage();
      }
    });
  }

  private reloadPage(): void {
    window.location.reload();
  }
}
