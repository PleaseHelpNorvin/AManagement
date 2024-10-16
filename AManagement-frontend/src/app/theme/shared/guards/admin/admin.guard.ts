import { Injectable } from '@angular/core';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot, Router } from '@angular/router';
import { AuthenticationService } from '../../services/authentication/authentication.service';
import { IdleTimeoutService } from '../../services/iddle-timeout/iddle-timeout.service';

@Injectable({
  providedIn: 'root'
})
export class AdminGuard implements CanActivate {
  constructor(
    private authService: AuthenticationService, 
    private router: Router,
    private idleTimeoutService: IdleTimeoutService
  ) {}

  canActivate(
    next: ActivatedRouteSnapshot,
    state: RouterStateSnapshot
  ): boolean {
    const token = this.authService.getToken();
    
    if (token && this.isAdmin()) {
      this.idleTimeoutService.startWatching();
      return true;
    }

    this.authService.logout();
    this.router.navigate(['/login']);
    return false;
  }

  private isAdmin(): boolean {
    const userRole = this.authService.getUserRole();
    return userRole === 'admin';
  }
}
