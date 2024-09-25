import { CanActivateFn, Router } from '@angular/router';
import { AuthService } from '../auth.service';
import { inject } from '@angular/core';

export const authGuard: CanActivateFn = (route, state) => {
  const authService = inject(AuthService);
  const router = inject(Router);
  const islogin = authService.isLoggedIn();

  if (islogin) {
    if (route.routeConfig?.path === 'login' || route.routeConfig?.path === 'register') {
      router.navigate(['/dashboard/default']); // Redirect to login page if not authenticated\
      return false;
    }
    return true;
  } else {
    alert("please login first");
    router.navigate(['/login']);
    return false; // Or redirect to login
  }
  
};
