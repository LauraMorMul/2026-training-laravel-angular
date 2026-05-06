import { Component, OnInit } from '@angular/core';
import { ZonesListComponent } from "../zones-list/zones-list.component";

@Component({
  selector: 'app-zones-container',
  templateUrl: './zones-container.component.html',
  styleUrls: ['./zones-container.component.scss'],
  imports: [ZonesListComponent],
})
export class ZonesContainerComponent  implements OnInit {

  constructor() { }

  ngOnInit() {}

}
