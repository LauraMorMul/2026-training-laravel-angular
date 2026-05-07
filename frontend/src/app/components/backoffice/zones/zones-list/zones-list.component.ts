import { Component, inject, OnInit } from '@angular/core';
import {
  IonCard,
  IonCardHeader,
  IonCardTitle,
  IonCardContent,
  IonItem,
  IonList,
  IonAvatar,
  IonLabel,
  IonButton,
  AlertController,
  ToastController,
  ModalController,
} from '@ionic/angular/standalone';
import { CheckZoneModalComponent } from '../check-zone-modal/check-zone-modal.component';
import { ModifyZoneModalComponent } from '../modify-zone-modal/modify-zone-modal.component';
import { ZoneService } from 'src/app/services/entity/zone-service';
import { IZone, IZones } from 'src/app/models/zone';

@Component({
  selector: 'app-zones-list',
  templateUrl: './zones-list.component.html',
  styleUrls: ['./zones-list.component.scss'],
  imports: [
    IonCard,
    IonCardHeader,
    IonCardTitle,
    IonCardContent,
    IonList,
    IonItem,
    IonLabel,
    IonButton
  ],
})
export class ZonesListComponent implements OnInit {
  private zoneService = inject(ZoneService);
  private alertController = inject(AlertController);
  private toastController = inject(ToastController);
  private modalCtrl = inject(ModalController);

  zones: IZones = [];
  zoneID: string | null = '';

  ngOnInit() {
    this.getZones();
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
      next:(response: any) => {
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
