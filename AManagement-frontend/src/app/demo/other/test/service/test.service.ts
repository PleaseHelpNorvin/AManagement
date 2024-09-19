import { HttpClient,HttpHeaders  } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';


export interface Apartment{
  apartment_id : number;
  apartment_name : string;
  address : string;
  number_of_units :number;
  manager_id: number;
  created_at: string;
  updated_at: string;
}
 
@Injectable({
  providedIn: 'root'
})
export class TestService {
  private apiUrl = 'http://localhost:8000/api/apartments';

  constructor(private httpClient: HttpClient) {}

  // Read (Get all apartments)
  getApartments(): Observable<Apartment[]> {
    return this.httpClient.get<Apartment[]>(this.apiUrl);
  }

  // Read (Get a single apartment by ID)
  getApartment(id: number): Observable<Apartment> {
    return this.httpClient.get<Apartment>(`${this.apiUrl}/${id}`);
  }

  // Create (Add a new apartment)
  addApartment(apartment: Apartment): Observable<Apartment> {
    return this.httpClient.post<Apartment>(this.apiUrl, apartment, this.httpOptions);
  }

  // Update (Edit an existing apartment)
  updateApartment(id: number, apartment: Apartment): Observable<Apartment> {
    return this.httpClient.put<Apartment>(`${this.apiUrl}/${id}`, apartment, this.httpOptions);
  }

  // Delete (Remove an apartment)
  deleteApartment(id: number): Observable<void> {
    return this.httpClient.delete<void>(`${this.apiUrl}/${id}`);
  }

  private httpOptions = {
    headers: new HttpHeaders({
      'Content-Type': 'application/json',
    }),
  };
}
