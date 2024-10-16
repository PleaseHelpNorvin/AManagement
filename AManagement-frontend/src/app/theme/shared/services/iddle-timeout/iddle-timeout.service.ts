import { Injectable } from '@angular/core';
import { Subject, Observable, fromEvent, merge, timer, Subscription, of } from 'rxjs';
import { switchMap, takeUntil, catchError } from 'rxjs/operators';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { AuthStateService } from '../authentication/state/authe-state-service.service';
import { AuthenticationService } from '../authentication/authentication.service';


interface CheckActivityResponse {
  error?: string; // Optional property if it exists in the response
  last_active_at?: string;
}

@Injectable({
  providedIn: 'root'
})
export class IdleTimeoutService {
  private idleTimeLimit = 10 * 1000; // 30 seconds for testing
  private timeout$ = new Subject<void>();
  private activitySubscription: Subscription | null = null;
  private isUpdatingActivity = false;
  private apiUrl = 'http://localhost:8000/api';

  constructor(private http: HttpClient,
              private authStateService: AuthStateService,
              private authService: AuthenticationService) {}

  startWatching(): void {
    console.log('Idle timeout service started.');

    if (this.activitySubscription) {
      this.activitySubscription.unsubscribe();
    }

    const activityEvents$ = merge(
      fromEvent(document, 'keydown'),
      fromEvent(document, 'click'),
      // fromEvent(document, 'mousemove') // Add more events as needed
    );

    this.authStateService.isAuthenticated$.subscribe(isAuthenticated => {
      if (isAuthenticated) {
        activityEvents$
          .pipe(takeUntil(this.timeout$))
          .subscribe(() => {
            this.updateLastActive();
            this.idleTimeoutCheck();
          });
      }
    });
  }

  private updateLastActive(): void {
    if (this.isUpdatingActivity) {
      return;
    }

    this.isUpdatingActivity = true;
    const token = this.getAuthToken();
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });

    this.http.post(`${this.apiUrl}/update-activity`, {}, { headers })
      .pipe(catchError(error => {
        console.error('Error updating activity:', error);
        return of(null);
      }))
      .subscribe(() => {
        console.log('Activity updated in backend');
        this.isUpdatingActivity = false;
      });
  }

  // private idleTimeoutCheck(): void {
  //   timer(this.idleTimeLimit).subscribe(() => {
  //     this.checkActivity();
  //   });
  // }
  private idleTimeoutCheck(): void {
    timer(this.idleTimeLimit).subscribe(() => {
      console.log('Idle timeout reached, checking activity...');
      this.checkActivity();
    });
  }

  private checkActivity(): void {
    const token = this.getAuthToken();
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });
  
    this.http.get<CheckActivityResponse>(`${this.apiUrl}/check-activity`, { headers })
      .pipe(catchError(error => {
        console.error('Error checking activity:', error);
        this.triggerLogout();
        return of(null);
      }))
      .subscribe(response => {
        if (response && response.error) {
          console.error('Error in response:', response.error);
          this.triggerLogout();
        } else {
          console.log('Last active at:', response?.last_active_at);
        }
      });
  }
  
  private triggerLogout(): void {
    // Emit the timeout event and perform logout
    this.timeout$.next();
    this.authService.logout().subscribe();
  }
  
  private getAuthToken(): string | null {
    return sessionStorage.getItem('authToken');
  }

  onTimeout(): Observable<void> {
    return this.timeout$.asObservable();
  }

  resetTimer(): void {
    this.startWatching();
  }

  stopWatching(): void {
    console.log('Idle timeout service stopped');
    if (this.activitySubscription) {
      this.activitySubscription.unsubscribe();
      this.activitySubscription = null;
    }
  }
}
