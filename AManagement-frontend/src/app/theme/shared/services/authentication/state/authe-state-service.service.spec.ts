import { TestBed } from '@angular/core/testing';
import { AuthStateService } from '../state/authe-state-service.service'; // Ensure this path is correct

describe('AuthStateService', () => { // Use the correct name in the describe block
  let service: AuthStateService; // Use the correct type for the service

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(AuthStateService); // Use the correct service here
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
