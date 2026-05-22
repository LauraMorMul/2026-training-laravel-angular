import { Component, inject, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-product-container',
  templateUrl: './product-container.component.html',
  styleUrls: ['./product-container.component.scss'],
})
export class ProductContainerComponent  implements OnInit {
private route = inject(ActivatedRoute);

  private tableId = this.route.snapshot.paramMap.get('tableId');

  constructor() { }

  ngOnInit() {
    console.log(this.tableId)
  }

}
