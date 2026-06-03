import { Component, inject, OnInit } from '@angular/core';
import { ITables } from 'src/app/models/table';
import { TableService as TableRestService } from 'src/app/services/HTTPRequests/table-service';
import { TableService as TableUserService } from 'src/app/services/HTTPRequests/tpv/table-service';
import { LocalStorageService } from 'src/app/services/storage/local-storage-service';
import {
  IonCardContent,
  IonCard,
  ModalController,
} from '@ionic/angular/standalone';
import { Router } from '@angular/router';
import { LoginModalComponent } from '../user/login-modal/login-modal.component';
import { NumpadComponent } from '../numpad/numpad.component';

@Component({
  selector: 'app-tables',
  templateUrl: './tables.component.html',
  styleUrls: ['./tables.component.scss'],
  imports: [IonCardContent, IonCard],
})
export class TablesComponent implements OnInit {
  private tablesRestaurantService = inject(TableUserService);
  private tablesUserService = inject(TableRestService);
  private localService = inject(LocalStorageService);
  private router = inject(Router);
  private modalCtrl = inject(ModalController);

  tables: ITables = [];

  constructor() {}

  ngOnInit() {
    this.getTables();
    this.tables.forEach(element => {
      console.log(element.__occupied)
    });
  }

  ionViewDidEnter() {
    this.tables.forEach(element => {
      console.log(element.__occupied)
    });
  }

  getTables() {
    if (this.localService.isThereUserToken()) {
      this.tablesUserService.getAll().subscribe({
        next: (response: ITables) => {
          this.tables = [...response];
        },
        error(err) {
          console.log('Error fetching tables usuario', err);
        },
      });
    } else {
      this.tablesRestaurantService.getAll().subscribe({
        next: (response: ITables) => {
          this.tables = [...response];
        },
        error(err) {
          console.log('Error fetching tables restaurante', err);
        },
      });
    }
  }

  openProducts(table: string) {
    if (this.localService.isThereUserToken()) {
      //this.router.navigate([`/tpv/products/${table}`]);
      this.openDinersModal(table);
    } else {
      this.openLoginModal(table);
    }
  }

  async openLoginModal(table: string) {
    const modal = await this.modalCtrl.create({
      component: LoginModalComponent,
      componentProps: {
        tableId: table,
      },
    });

    await modal.present();

    const { data } = await modal.onDidDismiss();
    if (data?.success) {
      this.openDinersModal(table);
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
        state: { diners: data.diners }
      });
    }
  }
}
