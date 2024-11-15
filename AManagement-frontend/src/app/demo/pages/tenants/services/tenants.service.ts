import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class TenantsService {
  private tenantBaseUrl = 'http://127.0.0.1:8000/api/admin/tenants';

  constructor(private http: HttpClient) { }

  private getAuthToken(): string | null {
    return sessionStorage.getItem('authToken'); // Adjust this if your token is stored elsewhere
  }
  private createAuthorizationHeader(): HttpHeaders {
    const token = this.getAuthToken();
    return new HttpHeaders({
      'Authorization': `Bearer ${token}`,
    });
  }

  // Fetch tenants with Authorization header
  fetchTenants(): Observable<any> {
    const headers = this.createAuthorizationHeader();
    return this.http.get<any>(this.tenantBaseUrl, { headers });
  }

  // Delete tenant by ID with Authorization header
  deleteTenant(id: number): Observable<any> {
    const headers = this.createAuthorizationHeader();
    return this.http.delete<any>(`${this.tenantBaseUrl}/${id}`, { headers });
  }

  // Update tenant by ID with Authorization header
  updateTenant(id: number, updatedTenant: { firstname?: string; lastname?: string }): Observable<any> {
    const headers = this.createAuthorizationHeader();
    return this.http.put<any>(`${this.tenantBaseUrl}/${id}`, updatedTenant, { headers });
  }

}