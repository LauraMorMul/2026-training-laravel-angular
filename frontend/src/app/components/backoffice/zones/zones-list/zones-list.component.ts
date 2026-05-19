import { Component, inject, OnInit } from '@angular/core';
import {
  IonCard,
  IonCardHeader,
  IonCardTitle,
  IonCardContent,
  IonButton,
  AlertController,
  ToastController,
  ModalController,
  IonSearchbar,
  IonIcon,
  IonGrid,
  IonCol,
  IonRow,
} from '@ionic/angular/standalone';
import { CheckZoneModalComponent } from '../check-zone-modal/check-zone-modal.component';
import { ZoneService } from 'src/app/services/HTTPRequests/zone-service';
import { IZone, IZones } from 'src/app/models/zone';
import { ModifyZoneModalComponent } from '../modify-zone-modal/modify-zone-modal.component';
import { createOutline, eyeOutline, trashOutline } from 'ionicons/icons';
import { addIcons } from 'ionicons';
import { TableService } from 'src/app/services/HTTPRequests/table-service';
import { ITables } from 'src/app/models/table';
import { FilterBySearchBarPipe } from 'src/app/pipes/shared/filter-by-search-bar-pipe';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-zones-list',
  templateUrl: './zones-list.component.html',
  styleUrls: ['./zones-list.component.scss'],
  imports: [
    IonCard,
    IonCardHeader,
    IonCardTitle,
    IonCardContent,
    IonButton,
    IonSearchbar,
    IonIcon,
    IonGrid,
    IonCol,
    IonRow,
    FilterBySearchBarPipe,
    FormsModule,
  ],
})
export class ZonesListComponent implements OnInit {
  private zoneService = inject(ZoneService);
  private alertController = inject(AlertController);
  private toastController = inject(ToastController);
  private modalCtrl = inject(ModalController);
  private tableService = inject(TableService);

  zones: IZones = [];
  tables: ITables = [];
  numeroMesas: number = 0;
  zoneID: string | null = '';
  nameFilter: string = '';

  ngOnInit() {
    this.getZones();
    this.getTables();
  }

  constructor() {
    addIcons({ trashOutline, createOutline, eyeOutline });
  }

  public actionButtons = [
    {
      text: 'Cancel',
      role: 'cancel',
      handler: () => {
        console.log('Alert confirmed');
      },
    },
    {
      text: 'OK',
      role: 'confirm',
      handler: () => {
        this.deleteZone(this.zoneID!);
      },
    },
  ];

  getZones() {
    this.zoneService.getAll().subscribe({
      next: (response: IZones) => {
        this.zones = [...response];
      },
      error(err) {
        console.log('Ni de coña jeje');
      },
    });
  }

  getTables() {
    this.tableService.getAll().subscribe({
      next: (response: ITables) => {
        this.tables = [...response];
      },
      error(err) {
        console.log('No hay mesas, te jodes');
      },
    });
  }

  countTables(zoneID: string | null): number {
    let numberOfTables = this.tables.filter(
      (table) => table.zone.id === zoneID,
    ).length;
    return numberOfTables;
  }

  async showDeleteAlert(id: string, name: string) {
    const alert = await this.alertController.create({
      header: 'Eliminar zona',
      subHeader: 'Esta acción es irreversible.',
      message: '¿Eliminar la zona ' + name + '?',
      buttons: this.actionButtons,
    });

    await alert.present();

    this.zoneID = id;
  }

  async abrirModalModificar(selectedZone: IZone) {
    const modal = await this.modalCtrl.create({
      component: ModifyZoneModalComponent,
      componentProps: {
        zone: selectedZone,
      },
    });

    await modal.present();

    const { data } = await modal.onDidDismiss();

    if (data?.updated) {
      this.getZones();
    }
  }

  async deleteZone(id: string) {
    const toast = await this.toastController.create({
      duration: 1500,
      position: 'bottom',
    });
    this.zoneService.delete(id).subscribe({
      next: (response: any) => {
        toast.message = 'Zona eliminada correctamente.';
        toast.color = 'success';
        toast.present();
      },
      error(err) {
        toast.message = 'Ha habido un error.';
        toast.color = 'danger';
        toast.present();
      },
    });
  }

  async abrirModalZona(selectedZone: IZone) {
    const modal = await this.modalCtrl.create({
      component: CheckZoneModalComponent,
      componentProps: {
        zone: selectedZone,
      },
    });
    modal.present();
  }
}
