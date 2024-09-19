import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders  } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { catchError, map } from 'rxjs/operators';
import { throwError } from 'rxjs';
import { AuthService } from 'src/app/demo/authentication/login/auth.service';

@Injectable({
  providedIn: 'root'
})
export class DashboardService {

  private adminStatusUrl = `${environment.apiUrl}/home/admin`;

  constructor(private http: HttpClient, private authService: AuthService) { }

  getAdminStatus() {
    const token = this.authService.getToken();
    console.log('Retrieved Token:', token); // Add this line for debugging
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });
  
    console.log('Request Headers:', headers); // Add this line for debugging
  
    return this.http.get(this.adminStatusUrl, { headers }).pipe(
      catchError(error => {
        console.error('Failed to fetch admin status', error);
        return throwError(error);
      })
    );
  }
  
}
