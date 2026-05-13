import { Component } from '@angular/core';
import { ProductsListComponent } from "../products-list/products-list.component";
import { AddProductComponent } from "../add-product/add-product.component";

@Component({
  selector: 'app-products-container',
  templateUrl: './products-container.component.html',
  styleUrls: ['./products-container.component.scss'],
  imports: [ProductsListComponent, AddProductComponent],
})
export class ProductsContainerComponent {

}
