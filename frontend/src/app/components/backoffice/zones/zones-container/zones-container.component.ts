import { Component, ViewChild } from '@angular/core';
import { ZonesListComponent } from "../zones-list/zones-list.component";
import { AddZoneComponent } from '../add-zone/add-zone.component';

@Component({
  selector: 'app-zones-container',
  templateUrl: './zones-container.component.html',
  styleUrls: ['./zones-container.component.scss'],
  imports: [ZonesListComponent, AddZoneComponent],
})
export class ZonesContainerComponent {
  @ViewChild('zoneListRef') zoneListRef!: ZonesListComponent;

  refreshList() {
    this.zoneListRef.getZones();
  }

}
