import { Component, inject, OnInit } from '@angular/core';
import { ITable, ITables } from 'src/app/models/table';
import { TableService } from 'src/app/services/HTTPRequests/table-service';
import { LocalStorageService } from 'src/app/services/storage/local-storage-service';
import {
  IonCardContent,
  ModalController,
  IonSegment,
  IonSegmentButton,
  IonLabel,
} from '@ionic/angular/standalone';
import { Router } from '@angular/router';
import { LoginModalComponent } from '../user/login-modal/login-modal.component';
import { NumpadComponent } from '../numpad/numpad.component';
import { FilterByZonePipe } from 'src/app/pipes/table/filter-by-zone-pipe';
import { ZoneService } from 'src/app/services/HTTPRequests/zone-service';
import { IZones } from 'src/app/models/zone';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-tables',
  templateUrl: './tables.component.html',
  styleUrls: ['./tables.component.scss'],
  imports: [
    IonCardContent,
    FilterByZonePipe,
    IonSegment,
    IonSegmentButton,
    IonLabel,
    FormsModule,
  ],
})
export class TablesComponent implements OnInit {
  private tablesService = inject(TableService);
  private zoneService = inject(ZoneService);
  private localService = inject(LocalStorageService);
  private router = inject(Router);
  private modalCtrl = inject(ModalController);

  tables: ITables = [];
  zones: IZones = [];
  selectedZone: string = '';

  constructor() {}

  ngOnInit() {
    this.getTables();
    this.getZones();
  }

  ionViewDidEnter() {
    this.getTables();
    this.tables.forEach((element) => {
      console.log(element.__occupied);
    });
  }

  getTables() {
    this.tablesService.getAll().subscribe({
      next: (response: ITables) => {
        this.tables = response;
      },
      error(err) {
        console.log('Error fetching tables restaurante', err);
      },
    });
  }

  getZones() {
    this.zoneService.getAll().subscribe({
      next: (response: IZones) => {
        this.zones = response;
      },
      error(err) {
        console.log('Error fetching zones restaurante', err);
      },
    });
  }

  openProducts(table: ITable) {
    if (this.localService.isThereUserToken()) {
      if (this.localService.checkOrderByTable(table.id)) {
        this.router.navigate([`/tpv/products/${table.id}`]);
      } else {
        this.openDinersModal(table.id);
      }
    } else {
      this.openLoginModal(table);
    }
  }

  async openLoginModal(table: ITable) {
    const modal = await this.modalCtrl.create({
      component: LoginModalComponent,
      componentProps: {
        tableId: table.id,
      },
    });

    await modal.present();

    const { data } = await modal.onDidDismiss();
    if (data?.success) {
      if (this.localService.checkOrderByTable(table.id)) {
        this.router.navigate([`/tpv/products/${table.id}`]);
      } else {
        this.openDinersModal(table.id);
      }
    }
  }

  async openDinersModal(table: string) {
    const modal = await this.modalCtrl.create({
      component: NumpadComponent,
      componentProps: {
        tableId: table,
      },
    });

    await modal.present();

    const { data } = await modal.onDidDismiss();
    if (data?.success) {
      this.router.navigate([`/tpv/products/${data.tableId}`], {
        state: { diners: data.diners },
      });
    }
  }
}
