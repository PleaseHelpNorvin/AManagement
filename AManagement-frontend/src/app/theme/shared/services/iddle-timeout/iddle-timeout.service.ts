// src/app/theme/shared/services/idle-timeout/idle-timeout.service.ts

import { Injectable, NgZone } from '@angular/core';
import { Subject } from 'rxjs';
import { AuthStateService } from '../authentication/state/authe-state-service.service';
import { ActivityService } from '../activity/user-acitivty.service'; // Import the ActivityService

@Injectable({
  providedIn: 'root',
})
export class IdleTimeoutService {
  private idleTime = 0;
  private timeout: any;
  private countdownInterval: any;
  private activityUpdateTimeout: any; 
  private readonly IDLE_LIMIT = 600000; 
  private timeoutSubject = new Subject<void>();
  private eventListenerAdded = false; // Ensure this is correctly managed
  private watchingStarted = false; // Flag to prevent multiple starts

  constructor(private ngZone: NgZone, private authStateService: AuthStateService, private activityService: ActivityService) {}

  private startListening(): void {
    this.ngZone.runOutsideAngular(() => {
      if (!this.eventListenerAdded) {
        window.addEventListener('keypress', this.resetIdleTime.bind(this));
        window.addEventListener('click', this.resetIdleTime.bind(this));
        this.eventListenerAdded = true; // Track that listeners are added
      }
    });
  }

  private stopListening(): void {
    if (!this.eventListenerAdded) return;
    window.removeEventListener('keypress', this.resetIdleTime.bind(this));
    window.removeEventListener('click', this.resetIdleTime.bind(this));
    this.eventListenerAdded = false; // Reset the flag
  }

  private resetIdleTime(): void {
    if (!this.authStateService.isAuthenticated()) {
      return; // Prevent idle time reset if the user is not authenticated
    }
    console.log('Resetting idle time for authenticated user');

    clearTimeout(this.timeout); // Clear previous timeout
    clearInterval(this.countdownInterval); // Clear previous countdown

      // Debounce the activity update call
  const updateDebounceTime = 5000; // Adjust as necessary
  if (this.activityUpdateTimeout) {
    clearTimeout(this.activityUpdateTimeout); // Clear the previous debounce timeout
  }

  this.activityUpdateTimeout = setTimeout(() => {
    this.activityService.updateActivity().subscribe({
      next: (response) => {
        console.log('User activity updated:', response);
      },
      error: (error) => {
        console.error('Failed to update user activity:', error);
      },
    });
  }, updateDebounceTime);

    let remainingTime = this.IDLE_LIMIT; // Initialize remaining time

    // Start the countdown interval
    this.countdownInterval = setInterval(() => {
      remainingTime -= 1000; // Decrease the remaining time by 1000 ms (1 second)
      console.log(`Time remaining until timeout: ${remainingTime / 1000} seconds`);

      if (remainingTime <= 0) {
        clearInterval(this.countdownInterval); // Stop the countdown when it reaches zero
      }
    }, 10000); // Update every second

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
    if (this.watchingStarted) return; 
    console.log('Start watching');
    this.watchingStarted = true;
    this.startListening();
    this.resetIdleTime(); // Start tracking immediately
  }

  public stopWatching(): void {
    this.stopListening();
    clearTimeout(this.timeout); // Stop tracking
    clearInterval(this.countdownInterval); // Stop countdown
    this.watchingStarted = false; // Reset the flag
    this.idleTime = 0;
  }
}
