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
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${this.authService.getToken()}`
    });
  
    return this.http.get(`${environment.apiUrl}/home/admin`, { headers }).pipe(
      catchError(error => {
        console.error('Failed to fetch admin status', error);
        return throwError(error);
      })
    );
  }  
  
}
