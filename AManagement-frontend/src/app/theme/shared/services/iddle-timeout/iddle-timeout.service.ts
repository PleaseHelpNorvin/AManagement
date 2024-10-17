// src/app/theme/shared/services/idle-timeout/idle-timeout.service.ts

import { Injectable, NgZone } from '@angular/core';
import { Subject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class IdleTimeoutService {
  private idleTime = 0;
  private timeout: any;
  private readonly IDLE_LIMIT = 10000; // 1 minute
  private timeoutSubject = new Subject<void>();

  constructor(private ngZone: NgZone) {
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

  private resetIdleTime(): void {
    this.idleTime = 0; // Reset the idle time

    // Clear previous timeout
    clearTimeout(this.timeout);

    // Start a new timeout
    this.timeout = setTimeout(() => {
      this.onTimeout();
    }, this.IDLE_LIMIT);
  }

  private onTimeout(): void {
    this.timeoutSubject.next(); // Notify subscribers
  }

  public onTimeoutObservable() {
    return this.timeoutSubject.asObservable();
  }

  public startWatching(): void {
    this.resetIdleTime(); // Start tracking immediately
  }

  public stopWatching(): void {
    clearTimeout(this.timeout); // Stop tracking
    this.idleTime = 0;
  }
}
