import { CanActivateFn, Router } from '@angular/router';
import { AuthService } from './auth.service';
import { inject } from '@angular/core';

export const authGuard: CanActivateFn = (route, state) => {
  const authService = inject(AuthService);
  const router = inject(Router);


  // Check if the user is logged in
  if (authService.isLoggedIn()) {
    return true;
  } else {
    router.navigate(['/login']); // Redirect to login page if not authenticated
    return false; // Or redirect to login
  }
};
