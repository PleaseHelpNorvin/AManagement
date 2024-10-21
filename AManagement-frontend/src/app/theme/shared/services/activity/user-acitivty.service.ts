// src/app/theme/shared/services/activity/activity.service.ts

import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { AuthenticationService } from '../authentication/authentication.service';

@Injectable({
  providedIn: 'root',
})
export class ActivityService {
  private apiUrl = 'http://127.0.0.1:8000/api'; // Adjust the URL as needed
  private tokenKey = 'authToken';
 
  constructor(private http: HttpClient) {}

  updateActivity(): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json', // Specify content type if needed
      'Authorization': `Bearer ${this.getToken()}`, // Add your token here
      // Add other headers as needed
    });

    return this.http.post(`${this.apiUrl}/update-activity`, {}, { headers });
  }

  // Method to retrieve the token (modify as necessary for your implementation)
  getToken(): string {
    return sessionStorage.getItem(this.tokenKey) || '';
  }
}
