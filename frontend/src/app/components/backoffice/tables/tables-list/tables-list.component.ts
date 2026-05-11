import { Component, inject, OnInit } from '@angular/core';
import { IonCard, IonCardHeader, IonCardTitle, IonCardContent, IonItem, IonList, IonLabel, IonButton, AlertController, ToastController, ModalController, IonModal, IonGrid, IonCol, IonRow, IonSearchbar, IonSelect, IonSelectOption } from '@ionic/angular/standalone';
import { CheckTableModalComponent } from '../check-table-modal/check-table-modal.component';
import { ModifyTableModalComponent } from '../modify-table-modal/modify-table-modal.component';
import { TableService } from 'src/app/services/entity/table-service';
import { ZoneService } from 'src/app/services/entity/zone-service';
import { ITable, ITables } from 'src/app/models/table';
import { IZones } from 'src/app/models/zone';

@Component({
  selector: 'app-tables-list',
  templateUrl: './tables-list.component.html',
  styleUrls: ['./tables-list.component.scss'],
  imports: [
    IonCard,
    IonCardHeader,
    IonCardTitle,
    IonCardContent,
    IonList,
    IonItem,
    IonLabel,
    IonButton,
    IonGrid,
    IonCol,
    IonRow,
    IonSearchbar,
    IonSelect,
    IonSelectOption
],
})
export class TablesListComponent implements OnInit {
  private tableService = inject(TableService);
  private zoneService = inject(ZoneService);
  private alertController = inject(AlertController);
  private toastController = inject(ToastController);
  private modalCtrl = inject(ModalController);

  tables: ITables = [];
  zones: IZones = [];
  tableID: string | null = '';
  results = [...this.tables];

  ngOnInit() {
    this.getTables();
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
        this.deleteTable(this.tableID!);
      },
    },
  ];

  getTables() {
    this.tableService.getAll().subscribe({
      next: (response: ITables) => {
        this.tables = [...response];
        this.results = [...response];
      },
      error(err) {
        console.log('Error fetching tables', err);
      },
    });
  }

  getZones() {
    this.zoneService.getAll().subscribe({
      next: (response: IZones) => {
        this.zones = [...response];
      },
    });
  }

  handleInput(event: Event) {
    const target = event.target as HTMLIonSearchbarElement;
    const query = target.value?.toLowerCase() || '';
    this.results = this.tables.filter((d) => d.name.toLowerCase().includes(query));
  }

  handleChange(event: Event) {
    const target = event.target as HTMLIonSelectElement;
    const query = target.value || '';
    this.results = this.tables.filter((d) => d.zone_id.includes(query));
  }
  

  async showDeleteAlert(id: string, name: string) {
    const alert = await this.alertController.create({
      header: 'Eliminar mesa',
      subHeader: 'Esta acción es irreversible.',
      message: '¿Eliminar la mesa ' + name + '?',
      buttons: this.actionButtons,
    });

    await alert.present();

    this.tableID = id;
  }

  async abrirModalModificar(selectedTable: ITable) {
    const modal = await this.modalCtrl.create({
      component: ModifyTableModalComponent,
      componentProps: {
        table: selectedTable,
      },
    });

    await modal.present();

    const { data } = await modal.onDidDismiss();

    if (data?.updated) {
      this.getTables();
    }
  }

  async deleteTable(id: string) {
    const toast = await this.toastController.create({
      duration: 1500,
      position: 'bottom',
    });
    this.tableService.delete(id).subscribe({
      next: (response: any) => {
        toast.message = 'Mesa eliminada correctamente.';
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

  async abrirModalTable(selectedTable: ITable) {
    const modal = await this.modalCtrl.create({
      component: CheckTableModalComponent,
      componentProps: {
        table: selectedTable,
      },
    });
    modal.present();
  }

  getZoneName(zoneId: string) {
    const z = this.zones.find((item) => item.id === zoneId);
    return z ? z.name : zoneId;
  }
}
