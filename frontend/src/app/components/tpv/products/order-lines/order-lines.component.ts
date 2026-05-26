import { Component, inject, Input, OnInit } from '@angular/core';
import { IOrderLines } from 'src/app/models/order_line';
import { IProducts } from 'src/app/models/product';
import { OrderLineManagerService } from 'src/app/services/tpv/order-line-manager-service';
import { IonCardHeader, IonCard, IonCardTitle, IonCardSubtitle, IonCardContent, IonList, IonItem, IonLabel, IonButton } from "@ionic/angular/standalone";
import { FindProductNamePipe } from 'src/app/pipes/helper/find-product-name-pipe';
import { OrderManagerService } from 'src/app/services/tpv/order-manager-service';

@Component({
  selector: 'app-order-lines',
  templateUrl: './order-lines.component.html',
  styleUrls: ['./order-lines.component.scss'],
  imports: [IonCardHeader, IonCard, IonCardTitle, IonCardSubtitle, IonCardContent, IonList, IonItem, IonLabel, FindProductNamePipe, IonButton],
})
export class OrderLinesComponent implements OnInit {
  private orderLineManager = inject(OrderLineManagerService);
  private orderManager = inject(OrderManagerService);

  orderLines: IOrderLines = [];
  @Input() products: IProducts = [];
  @Input() tableName: string = 'Ninguna';
  total: number = 0;

  ngOnInit() {
    this.getOrderLines();
    console.log(this.tableName);
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
