import { Component } from '@angular/core';
import { TablesListComponent } from "../tables-list/tables-list.component";
import { AddTableComponent } from "../add-table/add-table.component";

@Component({
  selector: 'app-tables-container',
  templateUrl: './tables-container.component.html',
  styleUrls: ['./tables-container.component.scss'],
  imports: [TablesListComponent, AddTableComponent],
})
export class TablesContainerComponent {

  constructor() { }

}
