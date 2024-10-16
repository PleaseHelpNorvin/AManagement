import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { catchError, map } from 'rxjs/operators';
// import { IdleTimeoutService } from '../iddle-timeout/iddle-timeout.service';
import { AuthStateService } from './state/authe-state-service.service';

@Injectable({
  providedIn: 'root'
})
export class AuthenticationService {
  private apiURL = 'http://localhost:8000/api';
  private tokenKey = 'authToken';
  private userRole = 'userRole';
  private isLoggeIn = 'isLoggedIn';

  constructor(private http: HttpClient, private authStateService: AuthStateService) {}

  login(email: string, password: string, rememberMe: boolean): Observable<any> {
    const body = { email, password, rememberMe };
    return this.http.post(`${this.apiURL}/login`, body).pipe(
      map((response: any) => {
        this.storeToken(response.token);
        this.authStateService.setAuthenticated(true); 
        sessionStorage.setItem('userRole', response.role);
        sessionStorage.setItem('isLoggedIn', response.is_logged_in ? 'true' : 'false');
        return response;
      })
    );
  }

  isAuthenticated(): boolean {
    const token = this.getToken();
    return !!token;
  }

  logout(): Observable<void> {
    const token = this.getToken();

    return this.http.post<void>(`${this.apiURL}/logout`, {}, {
      headers: { 'Authorization': `Bearer ${token}` }
    }).pipe(
      map(() => {
        this.clearToken();
        // window.location.href = '/login';
        window.location.reload();
        // this.idleTimeoutService.resetTimer();
        this.authStateService.setAuthenticated(false);
      }),
      catchError((error) => {
        console.error('Logout failed', error);
        return of(null);
      })
    );
  }

  private storeToken(token: string): void {
    sessionStorage.setItem(this.tokenKey, token);
  }

  getToken(): string {
    return sessionStorage.getItem(this.tokenKey) || '';
  }

  getUserRole(): string {
    return sessionStorage.getItem(this.userRole) || '';
  }

  getIsLogin(): boolean {
    return !!sessionStorage.getItem('isLoggedIn');
  }

  private clearToken(): void {
    sessionStorage.removeItem(this.tokenKey);
    sessionStorage.removeItem(this.userRole);
    sessionStorage.removeItem(this.isLoggeIn);
  }
}
