import { Injectable } from '@angular/core';
import { ApiResponse, BaseApiService } from '../api/base-api.service';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class ZoneService extends BaseApiService{
  getAll(): Observable<ApiResponse> {
    return this.httpCall('/zones/restaurant', null, 'get');
  }

  add(formData: FormData): Observable<ApiResponse> {
    return this.httpCall('/zones', formData, 'post');
  }

  delete(id: string): Observable<ApiResponse> {
    return this.httpCall(`/zones/${id}`, null, 'delete');
  }

  update(id: string, formData: FormData): Observable<ApiResponse> {
    return this.httpCall(`/zones/${id}`, formData, 'patch');
  }
}