import { Routes } from '@angular/router';
import { AdminLayoutComponent } from './shared/admin-layout/admin-layout.component';
import { SigninPageComponent } from './views/signin-page/signin-page.component';
import { HomePageComponent } from './views/home-page/home-page/home-page.component';
import { TenantsPageComponent } from './views/tenants-page/tenants-page.component';
import { ChatPageComponent } from './views/chat-page/chat-page.component';
import { PaymentPageComponent } from './views/payment-page/payment-page.component';
import { MaintenancePageComponent } from './views/maintenance-page/maintenance-page.component';
import { SettingsPageComponent } from './views/settings-page/settings-page.component';
import { TenantsDetailsComponent } from './views/tenants-page/tenants-details/tenants-details.component';
import { TenantsEditComponent } from './views/tenants-page/tenants-edit/tenants-edit.component';
import { AuthGuard } from './core/guard/auth.guard';
import { NoAuthGuard } from './core/guard/noauth.guard';


export const routes: Routes = [
  {
    path: '', 
    component: SigninPageComponent,  // Independent SignIn page
    data: { breadcrumb: 'Sign In' },
    canActivate: [NoAuthGuard],
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
        path: 'tenants/:id',  // This is the child route for tenant details
        component: TenantsDetailsComponent,
        data: { breadcrumb: 'Tenant Details' }
      },
      {
        path: 'tenants-edit/:id',
        component: TenantsEditComponent,
        data: { breadcrumb: 'Tenant Edit'}
      },
      {
        path: 'chat',
        component: ChatPageComponent,
        data: { breadcrumb: 'Messages' }
      },
      {
        path: 'payment',
        component: PaymentPageComponent,
        data: { breadcrumb: 'Payment' }
      },
      {
        path: 'maintenance',
        component: MaintenancePageComponent,
        data: { breadcrumb: 'Maintenance Requests'},
      },
      {
        path: 'settings',
        component: SettingsPageComponent,
        data: { breadcrumb: 'Settings'},
      }
      
    ],
    canActivate: [AuthGuard],  // Protect admin routes
  }
];
