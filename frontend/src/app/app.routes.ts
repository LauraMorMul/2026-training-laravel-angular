import { Routes } from '@angular/router';

export const routes: Routes = [
  {
    path: 'home',
    loadComponent: () =>
      import('./pages/core/home/home.page').then((m) => m.HomePage),
  },
  {
    path: '',
    redirectTo: 'restaurant-login',
    pathMatch: 'full',
  },
  {
    path: 'restaurant-login',
    loadComponent: () =>
      import('./pages/restaurant-login/restaurant-login.page').then(
        (m) => m.RestaurantLoginPage,
      ),
  },
  {
    path: 'login',
    loadComponent: () =>
      import('./pages/login/login.page').then((m) => m.LoginPage),
  },
  {
    path: 'backoffice',
    loadComponent: () =>
      import('./pages/backoffice/backoffice.page').then(
        (m) => m.BackofficePage,
      ),
  },
  {
    path: 'tpv',
    loadComponent: () => import('./pages/tpv/tpv.page').then((m) => m.TpvPage),
  },
];
