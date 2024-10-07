import { TestBed } from '@angular/core/testing';
import { ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import { Router } from '@angular/router';

import { GuestGuard } from './guest.guard';
import { AuthenticationService } from '../../services/authentication/authentication.service';

// Create a mock service
class MockAuthenticationService {
  // Mock the getToken method
  getToken() {
    return null; // Change this to return a token for testing logged-in scenario
  }
}

describe('GuestGuard', () => {
  let guard: GuestGuard;
  let authService: MockAuthenticationService;
  let router: Router;

  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [
        GuestGuard,
        { provide: AuthenticationService, useClass: MockAuthenticationService },
        { provide: Router, useValue: { navigate: jasmine.createSpy('navigate') } } // Mock Router
      ]
    });

    // Instantiate the guard
    guard = TestBed.inject(GuestGuard);
    authService = TestBed.inject(AuthenticationService);
    router = TestBed.inject(Router);
  });

  it('should allow access if user is not logged in', () => {
    const result = guard.canActivate({} as ActivatedRouteSnapshot, {} as RouterStateSnapshot);
    
    expect(result).toBeTrue(); // Should return true for guests
    expect(router.navigate).not.toHaveBeenCalled(); // Router should not navigate
  });

  it('should redirect to dashboard if user is logged in', () => {
    // Change the mock to return a token indicating the user is logged in
    const mockToken = 'mocked.jwt.token';
    spyOn(authService, 'getToken').and.returnValue(mockToken);

    const result = guard.canActivate({} as ActivatedRouteSnapshot, {} as RouterStateSnapshot);
    
    expect(result).toBeFalse(); // Should return false for logged-in users
    expect(router.navigate).toHaveBeenCalledWith(['/dashboard']); // Router should navigate to dashboard
  });

  it('should be created', () => {
    expect(guard).toBeTruthy();
  });
});
