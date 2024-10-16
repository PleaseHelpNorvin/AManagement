import { Injectable } from '@angular/core';
import { Subject, Observable, fromEvent, merge, timer, Subscription } from 'rxjs';
import { switchMap, takeUntil } from 'rxjs/operators';
import { HttpClient, HttpHeaders } from '@angular/common/http';
// import { AuthStateService } from '../auth-state.service'; // Import your AuthStateService
import { AuthStateService } from '../authentication/state/authe-state-service.service';


@Injectable({
  providedIn: 'root'
})
export class IdleTimeoutService {
  private idleTimeLimit = 30 * 1000; // 30 seconds for testing purposes
  private timeout$ = new Subject<void>();
  private activitySubscription: Subscription | null = null;
  private isCountingBackend = false;
  private apiUrl = 'http://localhost:8000/api';
  private isUpdatingActivity = false; // Flag to prevent duplicate requests

  constructor(private http: HttpClient, private authStateService: AuthStateService) {}

  // Start watching user activity and notify when idle timeout is reached
  startWatching(): void {
    console.log('Idle timeout service started.');

    if (this.activitySubscription) {
      this.activitySubscription.unsubscribe();
    }

    const activityEvents$ = merge(
      fromEvent(document, 'keydown'),
      fromEvent(document, 'click')
    );

    this.authStateService.isAuthenticated$.subscribe(isAuthenticated => {
      activityEvents$
        .pipe(takeUntil(this.timeout$)) // Stop watching when timeout occurs
        .subscribe(() => {
          if (isAuthenticated) { // Use the observable value
            this.updateLastActive(); // Call updateLastActive directly
          }
        });
    });
  }

  // Update last active time in backend
  private updateLastActive(): void {
    if (this.isUpdatingActivity) {
      return; // Exit if an update is already in progress
    }

    this.isUpdatingActivity = true; // Set the flag to true
    const token = this.getAuthToken();
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });

    this.http.post(`${this.apiUrl}/update-activity`, {}, { headers })
      .subscribe({
        next: () => {
          console.log('Activity updated in backend');
          this.isUpdatingActivity = false; // Reset the flag on success
        },
        error: (error) => {
          console.error('Error updating activity:', error);
          this.isUpdatingActivity = false; // Reset the flag on error
        }
      });
  }
  
  //for checkingActivity
  private checkActivity(): void {
    const token = this.getAuthToken();
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });
  
    this.http.get(`${this.apiUrl}/check-activity`, { headers })
      .subscribe({
        next: (response) => {
          // Handle the response here
          console.log('Activity check response:', response);
          // You can also update any state or perform additional logic based on the response
        },
        error: (error) => {
          console.error('Error checking activity:', error);
          // Handle error appropriately (e.g., show a notification, log out user, etc.)
        }
      });
  }

  // Method to retrieve auth token
  private getAuthToken(): string | null {
    return sessionStorage.getItem('authToken'); // Replace 'authToken' with your actual token key
  }

  // Observable to notify about timeout
  onTimeout(): Observable<void> {
    return this.timeout$.asObservable();
  }

  // Reset the idle timer manually (useful for actions like login)
  resetTimer(): void {
    this.startWatching();
  }

  // Stop watching user activity
  stopWatching(): void {
    console.log('Idle timeout service stopped');
    if (this.activitySubscription) {
      this.activitySubscription.unsubscribe();
      this.activitySubscription = null; // Clear the subscription
    }
  }
}
