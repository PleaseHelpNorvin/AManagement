import { Routes } from '@angular/router';
import { SigninPageComponent } from './views/signin-page/signin-page/signin-page.component';
import { HomePageComponent } from './views/home-page/home-page/home-page.component';

export const routes: Routes = [
    //routes
  {
    path: '',
    component: HomePageComponent,
    data: { breadcrumb: 'Dashboard' },
  },
  {
    path: 'signin',
    component: SigninPageComponent,
    data: { breadcrumb: 'Sign In' },
  },
];
