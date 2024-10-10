import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { interval, Observable, of, Subscription } from 'rxjs';
import { catchError, map, switchMap, takeUntil } from 'rxjs/operators';
import { IddleTimeoutService } from '../iddle-timeout/iddle-timeout.service';

@Injectable({
  providedIn: 'root'
})

export class AuthenticationService {
  private apiURL = 'http://localhost:8000/api';
  private tokenKey = 'authToken';
  private userRole = 'userRole';
  private isLoggeIn = 'is_login';
  private idleTimeoutService: IddleTimeoutService;
  private pingSubscription: Subscription | null = null;
  // authService: any;

  constructor(private http: HttpClient, idleTimeoutService: IddleTimeoutService) {
    this.idleTimeoutService = idleTimeoutService;
  }

  login(email: string, password: string): Observable<any> {
    const body = { email, password };
    return this.http.post(`${this.apiURL}/login`, body).pipe(
      map((response: any) => {
        // Store token and other session information
        this.storeToken(response.token);
        sessionStorage.setItem('userRole', response.role);
        sessionStorage.setItem('isLoggedIn', response.is_logged_in ? 'true' : 'false');
        this.startPing();
        return response;
      })
    );
  }
  

  // Unsubscribe from ping server
  public unsubscribeFromPing(): void {
    if (this.pingSubscription) {
      this.pingSubscription.unsubscribe(); // Unsubscribe from the ping observable
      this.pingSubscription = null; // Clear the reference
    }
  }

  isAuthenticated(): boolean {
    const token = this.getToken();
    // You might want to implement token validation logic here
    return !!token; // Return true if token exists
  }

  // Logout method
  logout(): Observable<void> {
    const token = this.getToken();

    // Unsubscribe from ping before making the logout call
    this.unsubscribeFromPing(); // Stop the ping operation

    return this.http.post<void>(`${this.apiURL}/logout`, {}, {
      headers: { 'Authorization': `Bearer ${token}` }
    }).pipe(
      map(() => {
        this.clearToken(); // Clear the token from storage
        window.location.href = '/login'; // Navigate to login page on logout
        this.idleTimeoutService.resetTimer();
        // this.clearToken(); // No need to call clearToken() here, as it's already called above
      }),
      catchError((error) => {
        console.error('Logout failed', error);
        return of(null); // Handle logout failure
      })
    );
  }

  // Store token in local storage
  private storeToken(token: string): void {
    sessionStorage.setItem(this.tokenKey, token);
  }

  // Get token from local storage
  getToken(): string {
    return sessionStorage.getItem(this.tokenKey) || '';
  }
  getUserRole(): string {
    return sessionStorage.getItem(this.userRole) || '';
  }

  getIsLogin(): boolean {
    // Implement logic to check if the user is logged in
    // For example, check if a token exists in local storage
    return !!sessionStorage.getItem('is_login'); // Adjust based on your implementation
}
  // Clear token from local storage
  private clearToken(): void {
    sessionStorage.removeItem(this.tokenKey);
    sessionStorage.removeItem(this.userRole);
    sessionStorage.removeItem(this.isLoggeIn);
  }



  // Ping server to keep session alive
  pingServer(): Observable<any> {
    const token = this.getToken();
    if (token) {
      return this.http.post(`${this.apiURL}/admin/ping`, {}, {
        headers: { 'Authorization': `Bearer ${token}` }
      }).pipe(
        catchError((error) => {
          console.error('Ping error:', error);
          return of(error); // Pass the error to the caller to handle 401 response
        })
      );
    }
    return of(null); // Return an empty observable if no token is found
  }

  private startPing(): void {
    this.unsubscribeFromPing(); // Unsubscribe from any existing ping before starting a new one
    if (!this.pingSubscription) {
      this.pingSubscription = interval(3000).pipe(
        switchMap(() => this.pingServer()), // Directly call pingServer here
        takeUntil(this.idleTimeoutService.onTimeout()) // Stop pinging if idle timeout occurs
      ).subscribe(
        response => {
          // console.log('Ping successful:', response);
          this.idleTimeoutService.resetTimer(); // Reset idle timer on successful ping
        },
        error => {
          console.error('Ping failed:', error);
          if (error.status === 401) {
            this.logout().subscribe(() => {
              alert('Session expired due to inactivity. Please log in again.');
            });
          }
        }
      );
    }
  }



}
