import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

// Project imports
import { AdminComponent } from './theme/layouts/admin-layout/admin-layout.component';
import { GuestComponent } from './theme/layouts/guest/guest.component';
import { AdminGuard } from './theme/shared/guards/admin/admin.guard';
import { GuestGuard } from './theme/shared/guards/guest/guest.guard';
// import { AdminGuard } from './shared/guards/admin/admin.guard'; // Adjust the path as needed
// import { GuestGuard } from './shared/guards/guest/guest.guard'; // Adjust the path as needed


const routes: Routes = [
  {
    path: '',
    component: AdminComponent,
    canActivate: [AdminGuard], // Protect admin routes
    children: [
      {
        path: '',
        redirectTo: '/dashboard/default',
        pathMatch: 'full'
      },
      {
        path: 'dashboard/default',
        loadComponent: () => import('./demo/default/dashboard/dashboard.component').then((c) => c.DefaultComponent)
      },
      {
        path: 'pages/tenant',
        loadComponent: () => import('./demo/pages/tenants/tenantspage/tenantspage.component')
      },
      {
        path: 'pages/qr-code',
        loadComponent: () => import ('./demo/pages/qrcode/qrcodepage/qrcodepage.component')
      },
      {
        path: 'typography',
        loadComponent: () => import('./demo/ui-component/typography/typography.component')
      },
      {
        path: 'color',
        loadComponent: () => import('./demo/ui-component/ui-color/ui-color.component')
      },
      {
        path: 'sample-page',
        loadComponent: () => import('./demo/other/sample-page/sample-page.component')
      }
    ]
  },
  {
    path: '',
    component: GuestComponent,
    canActivate: [GuestGuard], // Protect guest routes
    children: [
      {
        path: 'login',
        loadComponent: () => import('./demo/authentication/login/login.component')
      },
      {
        path: 'register',
        loadComponent: () => import('./demo/authentication/register/register.component')
      }
    ]
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule {}
