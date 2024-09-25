import { CanActivateFn, Router } from '@angular/router';
import { AuthService } from '../auth.service';
import { inject } from '@angular/core';

export const guestGuard: CanActivateFn = (route, state) => {
  const authService = inject(AuthService);
  const router = inject(Router);
  const isLoggedIn = authService.isLoggedIn(); // Assuming this checks if session or token exists

  if (isLoggedIn) {
    // If the user is logged in, redirect them to the dashboard
    router.navigate(['/dashboard/default']);
    return false;
  }
  
  return true; // Allow access to the login/register pages if not logged in
};
