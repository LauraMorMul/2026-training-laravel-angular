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

  add(formData: FormData): Observable<ApiResponse> {
    return this.httpCall('/users', formData, 'post');
  }

  delete(id: string): Observable<ApiResponse> {
    return this.httpCall(`/users/${id}`, null, 'delete');
  }
}
