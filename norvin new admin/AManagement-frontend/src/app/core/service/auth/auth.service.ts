import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  private apiUrl = 'http://127.0.0.1:8000/api'; // Your API base URL
  private tokenKey = 'token';  // Key for storing the token in sessionStorage
  // private staticToken = '123123asdasdasdas'; // Static token

  constructor(private http: HttpClient, private router:Router) {}


  // Check if the user is logged in (based on the static token)
  isLoggedIn(): boolean {
    return !!sessionStorage.getItem(this.tokenKey); // Returns true if token exists in localStorage
  }

  // Log in the user by sending credentials to the API
  adminLogin(email: string, password: string): Observable<any> {
    const body = { email, password };
    console.log('adminLogin',body);
    return this.http.post<any>(`${this.apiUrl}/admin/login`, body);
  }

  // Log out the user by removing the static token
  logout(): void {
    localStorage.removeItem(this.tokenKey); // Remove the token from localStorage
  }

  // Save the static token (can be used if you want to "set" a static token later)
  saveToken(token: string): void {
    sessionStorage.setItem(this.tokenKey, token);
    console.log('Token saved in sessionStorage:', sessionStorage.getItem(this.tokenKey)); // Debugging log

  } 


  // Get the static token (not using localStorage here)
  getToken(): string | null {
    return sessionStorage.getItem(this.tokenKey);
  }

  redirectAfterLogin(): void {
    const returnUrl = this.router.url.split('?returnUrl=')[1] || '/admin/dashboard';
    this.router.navigate([returnUrl]);
  }
}
