import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders  } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { catchError, map, tap } from 'rxjs/operators';
import { throwError } from 'rxjs';
import { AuthService } from 'src/app/demo/authentication/login/auth.service';
import { error } from 'console';
import { env } from 'process';

@Injectable({
  providedIn: 'root'
})
export class DashboardService {

  
  private adminStatusUrl = `${environment.apiUrl}/home/admin`;

  constructor(private http: HttpClient, private authService: AuthService) { }

  getAdminStatus() {
    const token = this.authService.getToken();
    
    // Headers: Authorization token sent in headers
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`,
      'Content-Type': 'application/json', // Optional, depends on your API
      'Accept': 'application/json' // Ensures you accept JSON responses
    });
    
    return this.http.get(this.adminStatusUrl, { headers }).pipe(
      tap(response => {
        console.log('Response Body:', response); // Logs the response body for debugging
      }),
      catchError(error => {
        console.error('Failed to fetch admin status', error);
        return throwError(error);
      })
    );
  }

  getServerPing() {
    const token = this.authService.getToken();
    // const token = '';
    // Set up the headers
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`,
      'Content-Type': 'application/json', // Optional, depends on your API
      'Accept': 'application/json' // Ensures you accept JSON responses
    });
  
    // Make the POST request with headers
    return this.http.post(`${environment.apiUrl}/admin/ping`, {}, { headers }).pipe(
      tap(response => {
        // console.log('Ping response:', response); // Logs the response body for debugging
      }),
      catchError(error => {
        console.error('Failed to ping server', error);
        return throwError(error);
      })
    );
  }
  
}
