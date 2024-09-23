import { Injectable } from '@angular/core';
import { HttpClient,HttpHeaders  } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { catchError, tap ,switchMap  } from 'rxjs/operators';
import { throwError, Observable ,  } from 'rxjs';
import { Router } from '@angular/router';
// import { tap } from 'rxjs/operators';
 

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private apiUrl = `${environment.apiUrl}`;
  // private logoutSubject = new Subject<void>();
  // logoutEvent$ = this.logoutSubject.asObservable();

  constructor(private http: HttpClient, private router: Router) { }

  // login(email: string, password: string) {
  //   return this.http.post<any>(`${this.apiUrl}/login`, { email, password }).pipe(
  //     catchError(error => {
  //       const errorMessage = error.error?.message || 'Login failed. Please try again.';
  //       console.error('Login failed', errorMessage);
  //       return throwError(errorMessage); 
  //       // console.error('Login failed', error);
  //       // return throwError(error);
  //     })
  //   );
  // }

  login(email: string, password: string): Observable<any> {
    if (this.isLoggedIn()) {
      console.warn('User is already logged in. Logging out the current session.');
      this.clearAuth(); // Clear current auth
      
      return this.logout().pipe(
        switchMap(() => {
          console.log('Successfully logged out the previous session.');
          // Proceed with new login attempt
          return this.http.post<any>(`${this.apiUrl}/login`, { email, password }).pipe(
            tap(response => {
              this.saveToken(response.token);
              this.saveRole(response.role);
              // localStorage.setItem('isLoggedIn', response.is_logged_in); // Save is_logged_in
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
      // Proceed with normal login attempt
      return this.http.post<any>(`${this.apiUrl}/login`, { email, password }).pipe(
        tap(response => {
          this.saveToken(response.token);
          this.saveRole(response.role);
          // localStorage.setItem('isLoggedIn', response.is_logged_in); // Save is_logged_in
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
    const token = localStorage.getItem('token'); // or from wherever you store your token
    const headers = new HttpHeaders().set('Authorization', `Bearer ${token}`);

    return this.http.post(`${this.apiUrl}/logout`, {}, { headers });
  }

  saveToken(token: string) {
    localStorage.setItem('authToken', token);
  }

  getToken() {
    return localStorage.getItem('authToken') || '';
  }

  saveRole(role: string) {
    localStorage.setItem('userRole', role);
  }

  getRole() {
    return localStorage.getItem('userRole');
  }

  isLoggedIn(): boolean {
    return !!this.getToken();
  }

  isAdmin(): boolean {
    return this.getRole() === 'admin';
  }

  clearAuth() {
    localStorage.removeItem('authToken');
    localStorage.removeItem('userRole');
    localStorage.removeItem('isloggedIn');
    // this.logoutSubject.next(); 
    this.router.navigate(['/login']);
  }

   
}
