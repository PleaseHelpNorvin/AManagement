import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { catchError } from 'rxjs/operators';

@Injectable({
  providedIn: 'root',
})
export class ChatService {
  private apiUrl = 'http://localhost:8000/api'; // Replace with your backend API URL

  constructor(private http: HttpClient) {}

  // Fetch tenants from backend (example endpoint)
  getTenants(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/tenants`).pipe(
      catchError(this.handleError<any[]>('getTenants', []))
    );
  }

  // Fetch messages for a specific tenant (example endpoint)
  getMessages(tenantId: number): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/tenants/${tenantId}/messages`).pipe(
      catchError(this.handleError<any[]>('getMessages', []))
    );
  }

  // Send message to backend (example endpoint)
  sendMessage(tenantId: number, message: string): Observable<any> {
    return this.http.post<any>(`${this.apiUrl}/tenants/${tenantId}/messages`, { message }).pipe(
      catchError(this.handleError<any>('sendMessage'))
    );
  }

  // Handle any error that occurs during HTTP requests
  private handleError<T>(operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {
      console.error(error); // Log to console instead
      return of(result as T);
    };
  }
}
