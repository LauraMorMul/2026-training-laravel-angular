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
}
