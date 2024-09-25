import { CanActivateFn, Router } from '@angular/router';
import { AuthService } from './auth.service';
import { inject } from '@angular/core';

export const authGuard: CanActivateFn = (route, state) => {
  const authService = inject(AuthService);
  const router = inject(Router);
  const isLoggedIn = authService.isLoggedIn();

  if (isLoggedIn) {
    if (route.routeConfig?.path === 'login') {
      router.navigate(['/home']); // Redirect to login page if not authenticated\
      return false;
    }
    return true;
  } else {
    router.navigate(['/login']);
    return false; // Or redirect to login
  }
};
