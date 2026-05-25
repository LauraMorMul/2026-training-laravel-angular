import { Component, inject, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { ProductListComponent } from "../product-list/product-list.component";
import { OrderLinesComponent } from "../order-lines/order-lines.component";

@Component({
  selector: 'app-product-container',
  templateUrl: './product-container.component.html',
  styleUrls: ['./product-container.component.scss'],
  imports: [ProductListComponent, OrderLinesComponent],
})
export class ProductContainerComponent  implements OnInit {
private route = inject(ActivatedRoute);

  private tableId = this.route.snapshot.paramMap.get('tableId');

  constructor() { }

  ngOnInit() {
  }

}
