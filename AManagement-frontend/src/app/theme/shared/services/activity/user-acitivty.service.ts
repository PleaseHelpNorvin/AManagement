import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { AuthenticationService } from '../authentication/authentication.service';
import { UpdateAcitivtyService } from '../activity/emit/update-acitivty.service'; // Import the new service
import { tap } from 'rxjs/operators';

@Injectable({
  providedIn: 'root',
})
export class UserActivtyService {
  private apiUrl = 'http://localhost:8000/api';

  constructor(
    private http: HttpClient,
    private authenticationService: AuthenticationService,
    private updateAcitivtyService: UpdateAcitivtyService // Inject the new service
  ) {}

  updateActivity() {
    const token = this.authenticationService.getToken();
    const headers = new HttpHeaders({
      Authorization: `Bearer ${token}`,
    });

    return this.http.post(`${this.apiUrl}/check-activity`, {}, { headers }).pipe(
      tap(() => {
        this.updateAcitivtyService.notifyActivityUpdate();
      })
    );
  }
}
