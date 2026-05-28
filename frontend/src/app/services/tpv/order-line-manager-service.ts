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
    const existingIndex = current.findIndex(
      (line) => line.product_id === newLine.product_id,
    );

    if (existingIndex !== -1) {
      this.updateQuantity(existingIndex, 1);
    } else {
      this.linesSubject.next([...current, { ...newLine, quantity: 1 }]);
    }
  }

  calcLinePrice(index: number) {
    const current = this.linesSubject.value;
    let quantity = current[index].quantity;
    const unitPrice = current[index].price;
    return quantity * unitPrice;
  }

  updateQuantity(index: number, delta: number) {
    const current = this.linesSubject.value;
    current[index].quantity += delta;
    this.linesSubject.next([...current]);
    if (current[index].quantity <= 0) {
      this.removeOrderLine(index);
    }
  }

  prepareLinesForBackend(): IOrderLines {
    const current = this.linesSubject.value;
    return current.map((line) => ({
      ...line,
      price: line.price * line.quantity,
    }));
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
