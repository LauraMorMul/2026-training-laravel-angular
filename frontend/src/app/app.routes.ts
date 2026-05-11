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
    children: [
      {
        path: '',
        redirectTo: 'users',
        pathMatch: 'full'
      },
      {
        path: 'users',
        loadComponent: () =>
          import('./components/backoffice/users/users-container/users-container.component').then(
            (m) => m.UsersContainerComponent,
          ),
      },
      {
        path: 'tables',
        loadComponent: () =>
          import('./components/backoffice/tables/tables-container/tables-container.component').then(
            (m) => m.TablesContainerComponent,
          ),
      },
      {
        path: 'zones',
        loadComponent: () =>
          import('./components/backoffice/zones/zones-container/zones-container.component').then(
            (m) => m.ZonesContainerComponent,
          ),
      },
      {
        path: 'taxes',
        loadComponent: () =>
          import('./components/backoffice/taxes/taxes-container/taxes-container.component').then(
            (m) => m.TaxesContainerComponent,
          ),
      },
      {
        path: 'families',
        loadComponent: () =>
          import('./components/backoffice/families/families-container/families-container.component').then(
            (m) => m.FamiliesContainerComponent,
          ),
      },
    ],
  },
  {
    path: 'tpv',
    loadComponent: () => import('./pages/tpv/tpv.page').then((m) => m.TpvPage),
  },
];
