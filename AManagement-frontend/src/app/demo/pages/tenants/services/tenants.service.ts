import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class TenantsService {
  private tenantBaseUrl = 'http://127.0.0.1:8000/api/admin/tenants';
  // private tenantFetchedByIdUrl = 'http://127.0.0.1:8000/api/admin/get-tenants-by'

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

  fetchTenantById(tenantId: number): Observable<any> {
    const headers = this.createAuthorizationHeader();
    return this.http.get<any>(`${this.tenantBaseUrl}/${tenantId}`, { headers });
  }
  

  // Fetch tenant by ID
  // fetchTenantById(tenantId: number): Observable<any> {
  //   const headers = this.createAuthorizationHeader();
  //   return this.http.get<any>(`${this.tenantBaseUrl}/${tenantId}`, { headers });
  // }

  // Delete tenant by ID with Authorization header
  deleteTenant(tenantId: number): Observable<any> {
    const headers = this.createAuthorizationHeader();
    return this.http.delete<any>(`${this.tenantBaseUrl}/delete/${tenantId}`, { headers });
  }
  

  // Update tenant by ID with Authorization header
  updateTenant(tenantId: number, tenantData: any): Observable<any> {
    console.log(tenantId);
    console.log(tenantData);
    const headers = this.createAuthorizationHeader();  // Make sure to add auth headers
    return this.http.put(`${this.tenantBaseUrl}/update/${tenantId}`, tenantData, { headers });
  }
  
  

}