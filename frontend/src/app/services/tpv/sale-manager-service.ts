import { Injectable } from '@angular/core';
import { ApiResponse, BaseApiService } from '../api/base-api.service';
import { Observable } from 'rxjs';
import { ISale } from 'src/app/models/sale';

@Injectable({
  providedIn: 'root',
})
export class SaleManagerService extends BaseApiService{
  add(sale: ISale): Observable<ApiResponse> {
    return this.httpCall('/sale', sale, 'post');
  }
}
