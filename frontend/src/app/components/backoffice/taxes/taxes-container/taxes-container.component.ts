import { Component } from '@angular/core';
import { AddTaxComponent } from "../add-tax/add-tax.component";
import { TaxListComponent } from "../tax-list/tax-list.component";

@Component({
  selector: 'app-taxes-container',
  templateUrl: './taxes-container.component.html',
  styleUrls: ['./taxes-container.component.scss'],
  imports: [AddTaxComponent, TaxListComponent],
})
export class TaxesContainerComponent{
}
