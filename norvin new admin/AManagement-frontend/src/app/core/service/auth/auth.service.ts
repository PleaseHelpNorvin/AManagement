import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  private apiUrl = 'https://yourapi.com/api'; // Your API base URL
  private tokenKey = 'auth_token'; // Key for storing the token in localStorage
  private staticToken = '123123asdasdasdas'; // Static token

  constructor(private http: HttpClient) {}

  // Check if the user is logged in (based on the static token)
  isLoggedIn(): boolean {
    // Use the static token directly
    return !!this.staticToken; // Returns true if static token exists
  }

  // Log in the user by sending credentials to the API
  login(username: string, password: string): Observable<any> {
    const body = { username, password };
    return this.http.post<any>(`${this.apiUrl}/login`, body);
  }

  // Log out the user by removing the static token
  logout(): void {
    // Invalidate the static token
    this.staticToken = ''; // Remove the static token
  }

  // Save the static token (can be used if you want to "set" a static token later)
  saveToken(token: string): void {
    this.staticToken = token;
  }

  // Get the static token (not using localStorage here)
  getToken(): string {
    return this.staticToken; // Return the static token directly
  }
}
