import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';
import { IdleTimeoutService } from '../../iddle-timeout/iddle-timeout.service';

@Injectable({
  providedIn: 'root'
})

export class AuthStateService {
  private isAuthenticatedSubject = new BehaviorSubject<boolean>(false);
  IdleTimeoutService 
  isAuthenticated$ = this.isAuthenticatedSubject.asObservable();

  setAuthenticated(value: boolean) {
    this.isAuthenticatedSubject.next(value);
  } 

  isAuthenticated(): boolean {
    return this.isAuthenticatedSubject.value;
  }


}
