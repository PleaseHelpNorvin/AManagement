import { Injectable } from '@angular/core';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot, Router } from '@angular/router';
import { AuthenticationService } from '../../services/authentication/authentication.service';
import { IddleTimeoutService } from '../../services/iddle-timeout/iddle-timeout.service';

@Injectable({
  providedIn: 'root'
})
export class AdminGuard implements CanActivate {
  constructor(
    private authService: AuthenticationService, 
    private router: Router,
    private idleTimeoutService :IddleTimeoutService
    ) {}

  canActivate(
    next: ActivatedRouteSnapshot,
    state: RouterStateSnapshot
  ): boolean {
    const token = this.authService.getToken();
    
    // Check if the token exists and user role is admin
    if (token && this.isAdmin(token)) {
      this.idleTimeoutService.startWatching(); // Start idle timeout when the user is authenticated
      return true;
    }   

    // Redirect to login if not authorized
    this.authService.logout();
    this.router.navigate(['/login']);
    return false;
  }

  private isAdmin(token: string): boolean {
    // Instead of decoding, just check for the role in your authService or however you determine the role
    const userRole = this.authService.getUserRole(); // You should implement this method to retrieve the user role based on your needs
    return userRole === 'admin'; // Compare with the admin role
  }
}
