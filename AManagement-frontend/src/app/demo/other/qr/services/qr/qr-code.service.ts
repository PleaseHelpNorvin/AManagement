import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class QrCodeService {
  private apiUrl = 'http://your-laravel-api-url/api/generate-qr-code'; // Update with your API URL

  constructor(private http: HttpClient) {}

  generateQrCode(data: string): Observable<Blob> {
    return this.http.post(this.apiUrl, { data }, { responseType: 'blob' });
  }
}
