import { Component, inject, Input, OnInit } from '@angular/core';
import { IProducts } from 'src/app/models/product';
import {
  IonThumbnail,
  IonLabel,
  IonButton,
} from '@ionic/angular/standalone';
import { ImageFormatter } from 'src/app/services/helper/image-formatter';
import { CurrencyPipe } from '@angular/common';
import { MoneyFormatterPipe } from 'src/app/pipes/money-formatter-pipe';
import { OrderLineManagerService } from 'src/app/services/tpv/order-line-manager-service';
import { IOrderLine } from 'src/app/models/order_line';
import { FamilyService } from 'src/app/services/HTTPRequests/family-service';
import { IFamilies } from 'src/app/models/family';
import { FilterByStatePipe } from 'src/app/pipes/shared/filter-by-state-pipe';
import { FilterProductByFamilyPipe } from 'src/app/pipes/product/filter-by-family-pipe';

@Component({
  selector: 'app-product-list',
  templateUrl: './product-list.component.html',
  styleUrls: ['./product-list.component.scss'],
  imports: [
    IonThumbnail,
    IonLabel,
    CurrencyPipe,
    MoneyFormatterPipe,
    IonButton,
    FilterByStatePipe,
    FilterProductByFamilyPipe
  ],
})
export class ProductListComponent implements OnInit {
  public imageService = inject(ImageFormatter);
  private familyService = inject(FamilyService);
  private orderLineManager = inject(OrderLineManagerService);
  @Input() products: IProducts = [];
  families: IFamilies = [];
  selectedFamily: string = '';

  ngOnInit(): void {
    this.getFamilies();
  }

  addToOrder(id: string, price: number) {
    const orderLine: IOrderLine = {
      product_id: id,
      quantity: 1,
      price: price,
    };

    this.orderLineManager.addOrderLine(orderLine);
  }

  getFamilies() {
    this.familyService.getAll().subscribe({
      next: (response: IFamilies) => {
        this.families = [...response];
      },
      error() {
        console.log('Error loading families');
      },
    });
  }

  selectFamily(family: string) {
    this.selectedFamily = family;
  }
}
