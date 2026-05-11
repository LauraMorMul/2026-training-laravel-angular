import { Component, OnInit } from '@angular/core';
import { FamilyListComponent } from "../family-list/family-list.component";
import { AddFamilyComponent } from "../add-family/add-family.component";

@Component({
  selector: 'app-families-container',
  templateUrl: './families-container.component.html',
  styleUrls: ['./families-container.component.scss'],
  imports: [FamilyListComponent, AddFamilyComponent],
})
export class FamiliesContainerComponent  implements OnInit {

  constructor() { }

  ngOnInit() {}

}
