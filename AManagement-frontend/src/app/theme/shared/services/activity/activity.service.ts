import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class ActivityService {
  private apiUrl = 'http://localhost:8000/api'; // Replace with your API endpoint

  constructor(private http: HttpClient) {}

  updateUserActivity(): Observable<any> {
    return this.http.post(`${this.apiUrl}/update-activity`, {}); // Corrected endpoint
  }
}
