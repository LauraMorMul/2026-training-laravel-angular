import { Component, inject, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { ProductListComponent } from "../product-list/product-list.component";
import { OrderLinesComponent } from "../order-lines/order-lines.component";
import { ProductService } from 'src/app/services/HTTPRequests/product-service';
import { IProducts } from 'src/app/models/product';
import { TableService } from 'src/app/services/HTTPRequests/tpv/table-service';

@Component({
  selector: 'app-product-container',
  templateUrl: './product-container.component.html',
  styleUrls: ['./product-container.component.scss'],
  imports: [ProductListComponent, OrderLinesComponent],
})
export class ProductContainerComponent implements OnInit {
  private productService = inject(ProductService);
  private route = inject(ActivatedRoute);
  private tableService = inject(TableService);

  private tableId = this.route.snapshot.paramMap.get('tableId');
  products: IProducts = [];
  tableName: string = '';
  diners: number = 0;

  ngOnInit() {
    this.diners = history.state?.['diners'] || 0;
    this.getProducts();
    this.tableService.getAll().subscribe(tables => {
      this.tableName = tables.find(t => t.id === this.tableId)?.name || '';
    });
  }

  getProducts() {
    this.productService.getAll().subscribe({
      next: (response: IProducts) => {
        this.products = [...response];
      },
      error() {
        console.log('Ni de coña jeje');
      },
    });
  }
}
