import { Routes } from '@angular/router';
import { AdminLayoutComponent } from './shared/admin-layout/admin-layout.component';
import { SigninPageComponent } from './views/signin-page/signin-page.component';
import { HomePageComponent } from './views/home-page/home-page/home-page.component';
import { TenantsPageComponent } from './views/tenants-page/tenants-page.component';
import { ChatPageComponent } from './views/chat-page/chat-page.component';
import { AuthGuard } from './core/guard/auth.guard';

export const routes: Routes = [
  {
    path: '', 
    component: SigninPageComponent,  // Independent SignIn page
    data: { breadcrumb: 'Sign In' }
  },
  {
    path: 'admin',  // Admin routes protected by AuthGuard
    component: AdminLayoutComponent, 
    children: [
      {
        path: 'dashboard',
        component: HomePageComponent,
        data: { breadcrumb: 'Dashboard' }
      },
      {
        path: 'tenants',
        component: TenantsPageComponent,
        data: { breadcrumb: 'Tenants' }
      },
      {
        path: 'chat',
        component: ChatPageComponent,
        data: { breadcrumb: 'Chat' }
      }
    ],
    canActivate: [AuthGuard],  // Protect admin routes
  }
];
