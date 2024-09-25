import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { catchError, tap, switchMap } from 'rxjs/operators';
import { throwError, Observable } from 'rxjs';
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private apiUrl = `${environment.apiUrl}`;

  constructor(private http: HttpClient, private router: Router) { }

  login(email: string, password: string): Observable<any> {
    if (this.isLoggedIn()) {
      console.warn('User is already logged in. Logging out the current session.');
      this.clearAuth(); // Clear current auth
      
      return this.logout().pipe(
        switchMap(() => {
          console.log('Successfully logged out the previous session.');
          return this.http.post<any>(`${this.apiUrl}/login`, { email, password }).pipe(
            tap(response => {
              this.saveToken(response.token);
              this.saveRole(response.role);
            }),
            catchError(error => {
              const errorMessage = error.error?.message || 'Login failed. Please try again.';
              console.error('Login failed', errorMessage);
              return throwError(errorMessage);
            })
          );
        }),
        catchError(err => {
          console.error('Logout failed', err);
          return throwError('Failed to log out the previous session. Please try again.');
        })
      );
    } else {
      return this.http.post<any>(`${this.apiUrl}/login`, { email, password }).pipe(
        tap(response => {
          this.saveToken(response.token);
          this.saveRole(response.role);
        }),
        catchError(error => {
          const errorMessage = error.error?.message || 'Login failed. Please try again.';
          console.error('Login failed', errorMessage);
          return throwError(errorMessage);
        })
      );
    }
  }

  logout(): Observable<any> {
    const token = sessionStorage.getItem('authToken');
    const headers = new HttpHeaders().set('Authorization', `Bearer ${token}`);

    return this.http.post(`${this.apiUrl}/logout`, {}, { headers });
  }

  saveToken(token: string) {
    sessionStorage.setItem('authToken', token); // Change to sessionStorage
  }

  getToken() {
    return sessionStorage.getItem('authToken') || ''; // Change to sessionStorage
  }

  saveRole(role: string) {
    sessionStorage.setItem('userRole', role); // Change to sessionStorage
  }

  getRole() {
    return sessionStorage.getItem('userRole'); // Change to sessionStorage
  }

  isLoggedIn(): boolean {
    return !!this.getToken();
  }

  isAdmin(): boolean {
    return this.getRole() === 'admin';
  }

  clearAuth() {
    sessionStorage.removeItem('authToken'); // Change to sessionStorage
    sessionStorage.removeItem('userRole'); // Change to sessionStorage
    this.router.navigate(['/login']);
  }
}
