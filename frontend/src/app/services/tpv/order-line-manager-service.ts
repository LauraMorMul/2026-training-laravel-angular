import { Injectable } from '@angular/core';
import { BehaviorSubject, Observable } from 'rxjs';
import { IOrderLine, IOrderLines } from 'src/app/models/order_line';

@Injectable({
  providedIn: 'root',
})
export class OrderLineManagerService {
  private linesMap = new Map<string, BehaviorSubject<IOrderLines>>();

  private getSubject(tableId: string): BehaviorSubject<IOrderLines> {
    if (!this.linesMap.has(tableId)) {
      this.linesMap.set(tableId, new BehaviorSubject<IOrderLines>([]));
    }
    return this.linesMap.get(tableId)!;
  }

  addOrderLine(tableId: string, newLine: IOrderLine) {
    const subject = this.getSubject(tableId);
    const current = subject.value;
    const existingIndex = current.findIndex(
      (line) => line.product_id === newLine.product_id,
    );

    if (existingIndex !== -1) {
      this.updateQuantity(tableId, existingIndex, 1);
    } else {
      subject.next([...current, { ...newLine, quantity: 1 }]);
    }
  }

  calcLinePrice(tableId: string, index: number): number {
    const current = this.getSubject(tableId).value;
    return current[index].price * current[index].quantity;
  }

  updateQuantity(tableId: string, index: number, delta: number) {
    const subject = this.getSubject(tableId);
    const current = subject.value;
    const newQuantity = current[index].quantity + delta;

    if (newQuantity <= 0) {
      current.splice(index, 1);
      subject.next([...current]);
    } else {
      current[index].quantity = newQuantity;
      subject.next([...current]);
    }
  }

  prepareLinesForBackend(tableId: string): IOrderLines {
    const current = this.getSubject(tableId).value;
    return current.map((line) => ({
      ...line,
      price: line.price * line.quantity,
    }));
  }

  removeOrderLine(tableId: string, index: number) {
    const subject = this.getSubject(tableId);
    const current = subject.value;
    current.splice(index, 1);
    subject.next([...current]);
  }

  clear(tableId: string) {
    this.getSubject(tableId).next([]);
  }

  getLinesForTable(tableId: string): Observable<IOrderLines> {
    return this.getSubject(tableId).asObservable();
  }

  getLines(tableId: string): IOrderLines {
    return this.getSubject(tableId).value;
  }
}
