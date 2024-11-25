import { Injectable } from '@angular/core';
import { AuthService } from '../auth/auth.service';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs'; // to work with Observables

@Injectable({
  providedIn: 'root'
})
export class TenantsService {
  private apiUrl = 'http://127.0.0.1:8000/api/admin/tenants';  // Your endpoint URL

  constructor(private authservice: AuthService, private http: HttpClient) { }

  // Function to fetch tenants
  getTenants(): Observable<any> {
    const token = sessionStorage.getItem('token'); // Assuming token is stored in localStorage
    return this.http.get<any>(this.apiUrl, {
      headers: {
        'Authorization': `Bearer ${token}` // Add token to the headers for authorization
      }
    });
  }

  getTenantById(id: number): Observable<any> {
    return this.http.get<any>(`${this.apiUrl}/${id}`);
  }
}
