import { Injectable } from '@angular/core';
import { CanActivate, Router, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import { AuthService } from '../service/auth/auth.service';

@Injectable({
  providedIn: 'root',
})
export class AuthGuard implements CanActivate {
  constructor(private authService: AuthService, private router: Router) {}

 canActivate(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): boolean {
  const isLoggedIn = this.authService.isLoggedIn();
  console.log('Guard check:', isLoggedIn); // Debugging log

  if (isLoggedIn) {
    return true;
  } else {
    // If not logged in, redirect to the login page
    this.router.navigate(['/']); // Redirect to SignInPageComponent
    return false;
  }
}
}
