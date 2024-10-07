// angular import
import { Component,OnInit,OnDestroy } from '@angular/core';
import { AuthenticationService } from './theme/shared/services/authentication/authentication.service';
import { IddleTimeoutService } from './theme/shared/services/iddle-timeout/iddle-timeout.service';
import { Subscription, interval } from 'rxjs';
import { switchMap, takeUntil } from 'rxjs/operators';


@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit,OnDestroy{
  // public props
  title = 'mantis-free-version';
  private idleTimeoutSubscription: Subscription;
  private pingSubscription: Subscription | null = null;
  private logoutSubscription: Subscription | null = null;
  private logoutInProgress = false;


  constructor( 
    private authService: AuthenticationService,
    private idleTimeoutService: IddleTimeoutService
  ) { }
  

  ngOnInit(): void {
    this.idleTimeoutService.startWatching();
    this.idleTimeoutSubscription = this.idleTimeoutService.onTimeout().subscribe(() => {
      this.handleIdleTimeout();
    });
  }

  ngOnDestroy(): void {
    if (this.idleTimeoutSubscription) {
      this.idleTimeoutSubscription.unsubscribe();
    }
  }

  private handleIdleTimeout(): void {
    if (this.logoutInProgress || !this.authService.isLoggedIn()) {
      return; 
  }

    this.logoutInProgress = true; 
    this.stopPing();
    this.idleTimeoutService.resetTimer(); 

    this.authService.logout().toPromise()
        .then(() => {
            if (this.logoutInProgress) {
                alert('Session expired due to inactivity. Please log in again.');
                this.reloadPage();
            }
        })
        .catch(err => {
            console.error('Logout failed:', err);
            alert('Logout failed. You may need to refresh the page.');
            this.reloadPage(); // Call the reload function here
        })
        .finally(() => {
            this.logoutInProgress = false; 
            // No need for logoutSubscription anymore
        });
}

  private reloadPage(): void {
    window.location.reload();
  }

  private stopPing(): void {
    if (this.pingSubscription) {
      this.pingSubscription.unsubscribe();
      this.pingSubscription = null;
    }
  }

}
