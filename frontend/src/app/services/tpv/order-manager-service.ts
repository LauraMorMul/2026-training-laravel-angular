import { Injectable } from '@angular/core';
import { BehaviorSubject, Observable } from 'rxjs';
import { IOrder } from 'src/app/models/order';
import { ApiResponse, BaseApiService } from '../api/base-api.service';

@Injectable({
  providedIn: 'root',
})
export class OrderManagerService extends BaseApiService {
  private orderSubject = new BehaviorSubject<IOrder | null>(null);
  public order$ = this.orderSubject.asObservable();

  add(order: IOrder): Observable<ApiResponse> {
    return this.httpCall('/order', order, 'post');
  }
}
