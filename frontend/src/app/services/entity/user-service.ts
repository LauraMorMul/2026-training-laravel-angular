import { Injectable } from '@angular/core';
import { ApiResponse, BaseApiService } from '../api/base-api.service';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class UserService extends BaseApiService{
  getAll(): Observable<ApiResponse> {
    return this.httpCall('/users/restaurant', null, 'get');
  }

  add(name: string, email: string, password: string, password_confirmation: string, role: string, image_src: string, pin: string ): Observable<ApiResponse> {
    return this.httpCall('/users', { name, email, password, password_confirmation, role, image_src, pin}, 'post');
  }
}
