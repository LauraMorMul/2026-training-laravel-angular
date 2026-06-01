import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';
import { IOrder } from 'src/app/models/order';

@Injectable({
  providedIn: 'root',
})
export class OrderManagerService {
  private orderSubject = new BehaviorSubject<IOrder | null>(null);
  public order$ = this.orderSubject.asObservable();
  private cantidad: number = 0;

  
}
