import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { catchError } from 'rxjs/operators';
import { throwError } from 'rxjs';
import * as CryptoJS from 'crypto-js';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  private apiUrl = `${environment.apiUrl}/login`;
  private tokenKey = 'authToken';
  constructor(private http: HttpClient) { }

  login(email: string, password: string) {
    return this.http.post<any>(this.apiUrl, { email, password }).pipe(
      catchError(error => {
        console.error('Login failed', error);
        return throwError(error);
      })
    );
  }

  // hashToken(token: string) {
  //   return CryptoJS.SHA256(token).toString(CryptoJS.enc.Hex); // Hashing the token
  // }

  // saveToken(token: string) {
  //   const hashedToken = this.hashToken(token);
  //   localStorage.setItem('authToken', hashedToken);
  // }

  // getToken(): string | null {
  //   const encryptedToken = localStorage.getItem('authToken');
  //   if (encryptedToken) {
  //     const bytes = CryptoJS.AES.decrypt(encryptedToken, 'your-secret-key');
  //     return bytes.toString(CryptoJS.enc.Utf8); // Decrypt and return the real token
  //   }
  //   return null;
  // }

  // getToken(): string | null {
  //   return localStorage.getItem(this.tokenKey);
  // }

  saveToken(token: string) {
    localStorage.setItem('authToken', token); // Save the plain token for testing
  }
  
  getToken(): string | null {
    return localStorage.getItem('authToken'); // Get the plain token for testing
  }

  saveRole(role: string) {
    localStorage.setItem('userRole', role);
  }

  getRole(): string | null {
    return localStorage.getItem('userRole');
  }

  // isLoggedIn(): boolean {
  //   return !!this.getToken();
  // }

  isLoggedIn(): boolean {
    const token = this.getToken();
    // Assuming a valid token is not null
    return token !== null;
  }
  
  isAdmin(): boolean {
    return this.getRole() === 'admin';
  }

  logout() {
    const token = this.getToken();
    if (token) {
      this.http.post(`${environment.apiUrl}/logout`, {}, {
        headers: {
          'Authorization': `Bearer ${token}`
        }
      }).subscribe(
        () => {
          // Invalidate tokens in the backend
          localStorage.removeItem('authToken');
          localStorage.removeItem('userRole');
    
          // Redirect to login after logout
          window.location.href = '/login';
        },
        error => {
          console.error('Logout failed', error);
        }
      );
    }
  }
  
}
