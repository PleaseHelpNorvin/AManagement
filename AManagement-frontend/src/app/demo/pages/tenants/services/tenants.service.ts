import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class TenantsService {
  private tenantBaseUrl = 'http://localhost:4200/api/tenants';

  constructor(private http: HttpClient) {}

  fetchTenants(): Observable<any> {
    return this.http.get<any>(this.tenantBaseUrl);
  }

  addTenant(tenant: { firstname: string; lastname: string }): Observable<any> {
    return this.http.post<any>(this.tenantBaseUrl, tenant);
  }
}