import { Component, inject, Input, OnInit } from '@angular/core';
import { IOrderLines } from 'src/app/models/order_line';
import { IProducts } from 'src/app/models/product';
import { OrderLineManagerService } from 'src/app/services/tpv/order-line-manager-service';
import {
  IonCardHeader,
  IonCard,
  IonCardTitle,
  IonCardSubtitle,
  IonCardContent,
  IonList,
  IonItem,
  IonLabel,
  IonButton,
  IonIcon,
} from '@ionic/angular/standalone';
import { FindProductNamePipe } from 'src/app/pipes/helper/find-product-name-pipe';
import { OrderManagerService } from 'src/app/services/tpv/order-manager-service';
import { MoneyFormatterPipe } from 'src/app/pipes/money-formatter-pipe';
import { CurrencyPipe } from '@angular/common';
import { addIcons } from 'ionicons';
import { addOutline, removeOutline, trashOutline } from 'ionicons/icons';
import { IOrder } from 'src/app/models/order';
import { LocalStorageService } from 'src/app/services/storage/local-storage-service';
import { ITable } from 'src/app/models/table';
import { TableService } from 'src/app/services/HTTPRequests/table-service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-order-lines',
  templateUrl: './order-lines.component.html',
  styleUrls: ['./order-lines.component.scss'],
  imports: [
    IonCardHeader,
    IonCard,
    IonCardTitle,
    IonCardSubtitle,
    IonCardContent,
    IonList,
    IonItem,
    IonLabel,
    FindProductNamePipe,
    IonButton,
    MoneyFormatterPipe,
    CurrencyPipe,
    IonIcon,
  ],
})
export class OrderLinesComponent implements OnInit {
  public orderLineManager = inject(OrderLineManagerService);
  private orderManager = inject(OrderManagerService);
  private localService = inject(LocalStorageService);
  private tableService = inject(TableService);
  private router = inject(Router);

  order: IOrder | null = null;
  orderLines: IOrderLines = [];
  @Input() products: IProducts = [];
  @Input() diners: number = 0;
  @Input() tableId: string = '';
  @Input() table: ITable | undefined = undefined;
  total: number = 0;
  tableName: string | undefined= '';

  constructor() {
    addIcons({ trashOutline, removeOutline, addOutline });
  }

  ngOnInit() {
    this.getOrder()
    if(this.order) {
      this.diners = this.order.diners;
    }
    this.orderLineManager.getLinesForTable(this.tableId).subscribe((lines) => {
      this.orderLines = lines;
      this.total = this.calculateTotal();
      this.tableName = this.table?.name;
    });
  }

  calculateTotal(): number {
    return this.orderLines.reduce(
      (sum, line) => sum + line.price * line.quantity,
      0,
    );
  }

  getOrder() {
    this.order = this.localService.getOrderByTable(this.tableId);
  }

  getOrderLines() {
    this.orderLines = this.orderLineManager.getLines(this.tableId);
  }

  removeLine(index: number) {
    this.orderLineManager.removeOrderLine(this.tableId, index);
  }

  changeQuantity(amount: number, index: number) {
    this.orderLineManager.updateQuantity(this.tableId, index, amount);
  }

  confirmOrder() {
    const orderLines = this.orderLineManager.getLines(this.tableId);
    let orderExists = this.localService.getOrderId(this.tableId);
    if (orderExists) {
      this.orderLineManager
        .sendLinesToBackend(orderExists, orderLines)
        .subscribe({
          next: (response) => {
            console.log('Bien?');
            this.router.navigate(['/tpv/tables']);
          },
          error: (err) => {
            console.error('Mal :(');
          },
        });
    } else {
      const order: IOrder = {
        table_id: this.tableId,
        diners: this.diners,
        orderLines: orderLines,
      };

      this.orderManager.add(order).subscribe({
        next: (response: any) => {
          const newOrder: IOrder = {
            id: response.id,
            table_id: response.table_id,
            diners: response.diners,
          };
          this.localService.setOrderByTable( this.tableId ,newOrder);
          this.tableService.updateOccupied(this.tableId, true);
          this.router.navigate(['/tpv/tables']);
        },
        error: (err) => {
          console.error('Error al crear pedido', err);
        },
      });
    }
  }

  closeOrder() {
    this.localService.removeOrderByTable(this.tableId);
    this.localService.removeOrderLines(this.tableId);
    this.orderLineManager.clear(this.tableId);
    this.tableService.updateOccupied(this.tableId, false);
    this.router.navigate(['/tpv/tables']);
  }
}
