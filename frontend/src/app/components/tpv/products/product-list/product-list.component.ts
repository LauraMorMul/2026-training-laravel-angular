import { Component, inject, Input, OnInit } from '@angular/core';
import { IProducts } from 'src/app/models/product';
import { ProductService } from 'src/app/services/HTTPRequests/product-service';
import { IonCard, IonCardContent, IonThumbnail, IonLabel } from "@ionic/angular/standalone";
import { ImageFormatter } from 'src/app/services/helper/image-formatter';
import { CurrencyPipe } from '@angular/common';
import { MoneyFormatterPipe } from 'src/app/pipes/money-formatter-pipe';
import { OrderLineManagerService } from 'src/app/services/tpv/order-line-manager-service';
import { IOrderLine } from 'src/app/models/order_line';

@Component({
  selector: 'app-product-list',
  templateUrl: './product-list.component.html',
  styleUrls: ['./product-list.component.scss'],
  imports: [IonCard, IonCardContent, IonThumbnail, IonLabel, CurrencyPipe, MoneyFormatterPipe],
})
export class ProductListComponent {
  private productService = inject(ProductService);
  public imageService = inject(ImageFormatter);
  private orderLineManager = inject(OrderLineManagerService);
  @Input() products: IProducts = [];

  addToOrder(id: string, price: number) {
    const orderLine: IOrderLine = {
      product_id: id,
      quantity: 1,
      price: price
    };

    this.orderLineManager.addOrderLine(orderLine);
  }
}
