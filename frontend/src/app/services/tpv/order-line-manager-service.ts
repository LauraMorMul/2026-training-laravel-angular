import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';
import { IOrderLine, IOrderLines } from 'src/app/models/order_line';

@Injectable({
  providedIn: 'root',
})
export class OrderLineManagerService {
  private linesSubject = new BehaviorSubject<IOrderLines>([]);
  public lines$ = this.linesSubject.asObservable();

  addOrderLine(newLine: IOrderLine) {
    const current = this.linesSubject.value;
    const existingIndex = current.findIndex(line => line.product_id === newLine.product_id);

    if (existingIndex !== -1) {
      current[existingIndex].quantity += 1;
      this.linesSubject.next([...current]);
    } else {
      this.linesSubject.next([...current, { ...newLine, quantity: 1 }]);
    }
  }

  removeOrderLine(index: number) {
    const current = this.linesSubject.value;
    current.splice(index, 1);
    this.linesSubject.next([...current]);
  }

  clear() {
    this.linesSubject.next([]);
  }

  getLines() {
    return this.linesSubject.value;
  }
}