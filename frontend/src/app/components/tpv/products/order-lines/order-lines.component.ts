import { Component, inject, OnInit } from '@angular/core';
import { IOrderLines } from 'src/app/models/order_line';
import { OrderLineManagerService } from 'src/app/services/tpv/order-line-manager-service';

@Component({
  selector: 'app-order-lines',
  templateUrl: './order-lines.component.html',
  styleUrls: ['./order-lines.component.scss'],
})
export class OrderLinesComponent implements OnInit {
  private orderLineManager = inject(OrderLineManagerService);

  orderLines: IOrderLines = [];

  ngOnInit() {
    this.getOrderLines();
  }

  getOrderLines() {
    this.orderLineManager.lines$.subscribe(lines => {
      this.orderLines = lines;
    });
  }

  removeLine(index: number) {
    this.orderLineManager.removeOrderLine(index);
  }
}
