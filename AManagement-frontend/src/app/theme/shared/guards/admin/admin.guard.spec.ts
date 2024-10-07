import { TestBed } from '@angular/core/testing';
import { ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import { Router } from '@angular/router';

import { AdminGuard } from './admin.guard';
import { AuthenticationService } from '../../services/authentication/authentication.service';

// Create a mock service
class MockAuthenticationService {
  // Mock the getToken method
  getToken() {
    return 'mocked.jwt.token'; // Provide a sample token for testing
  }

  // Mock the getUserRole method (assuming this exists)
  getUserRole() {
    return 'admin'; // Set to admin for testing
  }
}

describe('AdminGuard', () => {
  let guard: AdminGuard;
  let authService: MockAuthenticationService;
  let router: Router;

  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [
        AdminGuard,
        { provide: AuthenticationService, useClass: MockAuthenticationService },
        { provide: Router, useValue: { navigate: jasmine.createSpy('navigate') } } // Mock Router
      ]
    });

    // Instantiate the guard
    guard = TestBed.inject(AdminGuard);
    authService = TestBed.inject(AuthenticationService);
    router = TestBed.inject(Router);
  });

  it('should allow activation if user is an admin', () => {
    // Assuming the mocked token corresponds to an admin
    spyOn(guard as any, 'isAdmin').and.returnValue(true); // Mock isAdmin method

    const result = guard.canActivate({} as ActivatedRouteSnapshot, {} as RouterStateSnapshot);
    
    expect(result).toBeTrue(); // Should return true for admin access
    expect(router.navigate).not.toHaveBeenCalled(); // Router should not navigate
  });

  it('should redirect to login if user is not an admin', () => {
    // Mock isAdmin to return false
    spyOn(guard as any, 'isAdmin').and.returnValue(false); // Mock isAdmin method

    const result = guard.canActivate({} as ActivatedRouteSnapshot, {} as RouterStateSnapshot);
    
    expect(result).toBeFalse(); // Should return false for non-admin access
    expect(router.navigate).toHaveBeenCalledWith(['/login']); // Router should navigate to login
  });

  it('should be created', () => {
    expect(guard).toBeTruthy();
  });
});
