// src/app/theme/shared/services/idle-timeout/idle-timeout.service.ts

import { Injectable, NgZone } from '@angular/core';
// import { throws } from 'assert';
import { Subject, Subscription } from 'rxjs';
import { AuthStateService } from '../authentication/state/authe-state-service.service';
import { UpdateAcitivtyService } from '../activity/emit/update-acitivty.service';


@Injectable({
  providedIn: 'root'
})
export class IdleTimeoutService {
  private idleTime = 0;
  private timeout: any;
  private countdownInterval: any;
  private readonly IDLE_LIMIT = 60000; // 1 minute
  private timeoutSubject = new Subject<void>();
  private eventListenerAdded = false; // Ensure this is correctly managed
  private watchingStarted = false; // Flag to prevent multiple starts
  private activitySubscription: Subscription | null = null; // Store subscription

  

  constructor(private ngZone: NgZone, private authStateService: AuthStateService, private updateAcitivtyService: UpdateAcitivtyService) {
      this.startListening();
      this.updateAcitivtyService.activityUpdated.subscribe(() => {
        this.resetIdleTime();
      });
      
  }

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


  // private resetIdleTime(): void {
  //   if (!this.authStateService.isAuthenticated()) {
  //     return; // Prevent idle time reset if the user is not authenticated
  //   }
  //   console.log('Resetting idle time for authenticated user');

  //   clearTimeout(this.timeout); // Clear previous timeout

  //   this.timeout = setTimeout(() => {
  //     this.onTimeout();
  //   }, this.IDLE_LIMIT);
  // }
  // with countdown interval just uncomment this and 
  // private resetIdleTime(): void {
  //     if (!this.authStateService.isAuthenticated()) {
  //         return; // Prevent idle time reset if the user is not authenticated
  //     }
  //     console.log('Resetting idle time for authenticated user');

  //     clearTimeout(this.timeout); // Clear previous timeout
  //     clearInterval(this.countdownInterval); // Clear previous countdown

  //     let remainingTime = this.IDLE_LIMIT; // Initialize remaining time

  //     // Start the countdown interval
  //     this.countdownInterval = setInterval(() => {
  //         remainingTime -= 1000; // Decrease the remaining time by 1000 ms (1 second)
  //         console.log(`Time remaining until timeout: ${remainingTime / 1000} seconds`);

  //         if (remainingTime <= 0) {
  //             clearInterval(this.countdownInterval); // Stop the countdown when it reaches zero
  //         }
  //     }, 1000); // Update every second

  //     this.timeout = setTimeout(() => {
  //         this.onTimeout();
  //     }, this.IDLE_LIMIT);

  //     // this.
  // }
  private resetIdleTime(): void {
    if (!this.authStateService.isAuthenticated()) {
        return; // Prevent idle time reset if the user is not authenticated
    }
    console.log('Resetting idle time for authenticated user');

    clearTimeout(this.timeout); // Clear previous timeout
    clearInterval(this.countdownInterval); // Clear previous countdown

    // Call the updateActivity method to notify the backend


    let remainingTime = this.IDLE_LIMIT; // Initialize remaining time

    // Start the countdown interval
    this.countdownInterval = setInterval(() => {
        remainingTime -= 1000; // Decrease the remaining time by 1000 ms (1 second)
        console.log(`Time remaining until timeout: ${remainingTime / 1000} seconds`);

        if (remainingTime <= 0) {
            clearInterval(this.countdownInterval); // Stop the countdown when it reaches zero
        }
    }, 1000); // Update every second

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
      if (this.watchingStarted) return; // Prevent multiple starts
      console.log('Start watching');
      this.watchingStarted = true;
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

 