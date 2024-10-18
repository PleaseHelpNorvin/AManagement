// src/app/theme/shared/services/idle-timeout/idle-timeout.service.ts

import { Injectable, NgZone } from '@angular/core';
import { throws } from 'assert';
import { Subject } from 'rxjs';
import { AuthStateService } from '../authentication/state/authe-state-service.service';

@Injectable({
  providedIn: 'root'
})
export class IdleTimeoutService {
  private idleTime = 0;
  private timeout: any;
  private readonly IDLE_LIMIT = 10000; // 1 minute
  private timeoutSubject = new Subject<void>();
  private eventListenerAdded = false;

  constructor(private ngZone: NgZone, private authStateService: AuthStateService ) {
    this.startListening();
  }

  private startListening(): void {
    // Reset the idle time on user activity
    this.ngZone.runOutsideAngular(() => {
      // window.addEventListener('mousemove', this.resetIdleTime.bind(this));
      window.addEventListener('keypress', this.resetIdleTime.bind(this));
      window.addEventListener('click', this.resetIdleTime.bind(this));
      // window.addEventListener('scroll', this.resetIdleTime.bind(this));
    });
  }
  
  private stopListening(): void {
    if(!this.eventListenerAdded) return;
    window.removeEventListener('keypress', this.resetIdleTime.bind(this));
    window.removeEventListener('click', this.resetIdleTime.bind(this));

    this.eventListenerAdded = false;
  }

  private resetIdleTime(): void {
    if (!this.authStateService.isAuthenticated()) {
      return; // Prevent idle time reset if the user is not authenticated
    }
    console.log('Resetting idle time for authenticated user');

    clearTimeout(this.timeout); // Clear previous timeout

    this.timeout = setTimeout(() => {
      this.onTimeout();
    }, this.IDLE_LIMIT);
  }

  private onTimeout(): void {
    if (this.authStateService.isAuthenticated()) {
      console.log('User is idle and authenticated, triggering timeout...');
      this.timeoutSubject.next(); // Notify subscribers
    } else {
      console.log('User is not authenticated, ignoring idle timeout...');
    }
  }

  public onTimeoutObservable() {
    return this.timeoutSubject.asObservable();
  }

  public startWatching(): void {
    console.log('start watching')
    this.resetIdleTime(); // Start tracking immediately
  }

  public stopWatching(): void {
    this.stopListening();
    clearTimeout(this.timeout); // Stop tracking
    this.idleTime = 0;
  }
}
