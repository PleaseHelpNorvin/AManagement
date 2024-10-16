import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { catchError, map, tap } from 'rxjs/operators';
import { AuthStateService } from './state/authe-state-service.service';

interface LoginResponse {
  token: string;
  role: string;
  is_logged_in: boolean;
  success?: boolean;
  message: string;
}

@Injectable({
  providedIn: 'root'
})
export class AuthenticationService {
  private apiURL = 'http://localhost:8000/api';
  private tokenKey = 'authToken';
  private userRole = 'userRole';
  private isLoggeIn = 'isLoggedIn';

  constructor(private http: HttpClient, private authStateService: AuthStateService) {}

  login(email: string, password: string, rememberMe: boolean): Observable<LoginResponse> {
    const body = { email, password, rememberMe };
    return this.http.post<LoginResponse>(`${this.apiURL}/login`, body).pipe(
      map((response: LoginResponse) => {
        this.storeToken(response.token);
        this.authStateService.setAuthenticated(true);
        sessionStorage.setItem('userRole', response.role);
        sessionStorage.setItem('isLoggedIn', response.is_logged_in ? 'true' : 'false');
        return response;
      }),
      catchError((error: HttpErrorResponse) => {
        console.error('Login failed', error);
        return of({ token: '', role: '', is_logged_in: false, message: 'Login failed' });
      })
    );
  }

  logout(): Observable<void> {
    const token = this.getToken();
    console.log('Logging out with token:', token);

    return this.http.post<void>(`${this.apiURL}/logout`, {}, {
      headers: { 'Authorization': `Bearer ${token}` }
    }).pipe(
      tap(() => {
        this.clearToken();
        this.authStateService.setAuthenticated(false);
        window.location.reload();
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
  getIsLogin(): string {
    return sessionStorage.getItem(this.isLoggeIn) || '';
  }

  clearToken(): void {
    sessionStorage.removeItem(this.tokenKey);
    sessionStorage.removeItem(this.userRole);
    sessionStorage.removeItem(this.isLoggeIn);
  }
}
