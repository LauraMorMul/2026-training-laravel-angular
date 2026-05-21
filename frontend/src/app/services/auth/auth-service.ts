import { Injectable, Injector, inject } from '@angular/core';
import { ApiResponse, BaseApiService } from '../api/base-api.service';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class AuthService extends BaseApiService {
  login(email: string, password: string): Observable<ApiResponse> {
    return this.httpCall('/login', { email, password }, 'post');
  }

  loginPin(email: string, pin: string): Observable<ApiResponse> {
    return this.httpCall('/login-pin', { email, pin }, 'post');
  }

  context(email: string, password: string): Observable<ApiResponse> {
    return this.httpCall('/context', { email, password }, 'post');
  }

  logout(): Observable<ApiResponse> {
    return this.httpCall('/users/logout', null, 'post');
  }
}
