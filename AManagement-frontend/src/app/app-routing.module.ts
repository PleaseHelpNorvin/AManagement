// angular import
import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { FormsModule } from '@angular/forms';


// Project import
import { AdminComponent } from './theme/layouts/admin-layout/admin-layout.component';
import { GuestComponent } from './theme/layouts/guest/guest.component';
import { authGuard } from './demo/authentication/login/guards/admin.guard';
import { guestGuard } from './demo/authentication/login/guards/guest.guard';

const routes: Routes = [
  {
    path: '',
    component: GuestComponent, // Container for unauthenticated views
    children: [
      {
        path: '', // Default path
        redirectTo: '/login', // Redirect to login page
        pathMatch: 'full'
      },
      {
        path: 'login',
        loadComponent: () => import('./demo/authentication/login/login.component'),
        canActivate: [guestGuard] 
      },
      {
        path: 'register',
        loadComponent: () => import('./demo/authentication/register/register.component'),
        canActivate: [guestGuard] 
      }
    ]
  },
  {
    path: '',
    component: AdminComponent, // Container for authenticated views
    canActivate: [authGuard],
    children: [
      // Define routes for authenticated views here
      {
        path: 'dashboard/default',
        loadComponent: () => import('./demo/default/dashboard/dashboard.component').then(c => c.DefaultComponent)
      },
      {
        path: 'tenants',
        loadComponent: () => import('./demo/other/tenants/tenants.component')
      },
      {
        path: 'qr',
        loadComponent: () => import('./demo/other/qr/qr.component')
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
      },
      {
        path: 'test-file',
        loadComponent: () => import('./demo/other/test-file/test-file.component')
      },
      {
        path: 'test',
        loadComponent: () => import('./demo/other/test/test.component')
      },
      {
        path: 'logout',
        loadComponent: () => import('./demo/authentication/logout/logout.component'),
        canActivate: [authGuard]
      }
    ]
  },
  {
    path: '**',
    redirectTo: '/login', // Redirect unknown routes to login page
    pathMatch: 'full'
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes),
  FormsModule
  ],
  exports: [RouterModule]
})
export class AppRoutingModule {}
