import { Component, inject, Input, OnInit } from '@angular/core';
import { IOrderLines } from 'src/app/models/order_line';
import { IProducts } from 'src/app/models/product';
import { OrderLineManagerService } from 'src/app/services/tpv/order-line-manager-service';
import { IonCardHeader, IonCard, IonCardTitle, IonCardSubtitle, IonCardContent, IonList, IonItem, IonLabel, IonButton, IonIcon } from "@ionic/angular/standalone";
import { FindProductNamePipe } from 'src/app/pipes/helper/find-product-name-pipe';
import { OrderManagerService } from 'src/app/services/tpv/order-manager-service';
import { MoneyFormatterPipe } from 'src/app/pipes/money-formatter-pipe';
import { CurrencyPipe } from '@angular/common';
import { addIcons } from 'ionicons';
import { addOutline, removeOutline, trashOutline } from 'ionicons/icons';

@Component({
  selector: 'app-order-lines',
  templateUrl: './order-lines.component.html',
  styleUrls: ['./order-lines.component.scss'],
  imports: [IonCardHeader, IonCard, IonCardTitle, IonCardSubtitle, IonCardContent, IonList, IonItem, IonLabel, FindProductNamePipe, IonButton, MoneyFormatterPipe, CurrencyPipe, IonIcon],
})
export class OrderLinesComponent implements OnInit {
  public orderLineManager = inject(OrderLineManagerService);
  private orderManager = inject(OrderManagerService);

  orderLines: IOrderLines = [];
  @Input() products: IProducts = [];
  @Input() tableName: string = 'Ninguna';
  @Input() diners: number = 0;
  total: number = 0;

  constructor() {
      addIcons({ trashOutline, removeOutline, addOutline });
    }

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

  changeQuantity(amount: number, index: number) {
    this.orderLineManager.updateQuantity(index, amount);
  }

  confirmOrder() {

  }
}
