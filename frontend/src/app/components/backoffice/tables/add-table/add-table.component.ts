import { Component, OnInit, inject } from '@angular/core';
import {
  FormControl,
  FormGroup,
  ReactiveFormsModule,
  Validators,
} from '@angular/forms';
import { AlertController, IonButton, IonCard, IonCardContent, IonCardHeader, IonCardTitle, IonCol, IonGrid, IonInput, IonLabel, IonRow, IonSelect, IonSelectOption, LoadingController, ToastController, IonIcon } from '@ionic/angular/standalone';
import { addIcons } from 'ionicons';
import { addCircleOutline } from 'ionicons/icons';
import { IZones } from 'src/app/models/zone';
import { ApiResponse } from 'src/app/services/api/base-api.service';
import { TableService } from 'src/app/services/HTTPRequests/table-service';
import { ZoneService } from 'src/app/services/HTTPRequests/zone-service';

@Component({
  selector: 'app-add-table',
  templateUrl: './add-table.component.html',
  styleUrls: ['./add-table.component.scss'],
  imports: [
    IonCard,
    IonCardHeader,
    IonCardTitle,
    IonCardContent,
    IonGrid,
    IonRow,
    IonCol,
    IonLabel,
    IonInput,
    IonButton,
    ReactiveFormsModule,
    IonSelectOption,
    IonSelect,
    IonIcon
],
})
export class AddTableComponent implements OnInit {
  private tableService = inject(TableService);
  private loadingController = inject(LoadingController);
  private toastController = inject(ToastController);
  private zoneService = inject(ZoneService);
  private alertController = inject(AlertController);

  constructor() {
      addIcons({ addCircleOutline });
    }

  formulario = new FormGroup({
    name: new FormControl('', [Validators.required]),
    zone: new FormControl('', Validators.required),
  });
  zones: IZones = [];
  name: any;

  ngOnInit(): void {
    this.getZones();
  }

  async getZones() {
    this.zoneService.getAll().subscribe({
      next: (response: IZones) => {
        this.zones = [...response];
      },
      error(err) {
        console.log('Ni de coña jeje');
      },
    });
  }

  public zoneAlertInputs = [
    {
      name: 'name',
      placeholder: 'Nombre de la zona',
    },
  ];

  public zoneAlertButtons = [
    {
      text: 'Cancel',
      role: 'cancel',
    },
    {
      text: 'OK',
      role: 'confirm',
      //No tengo ni idea de que tipo de dato es este
      handler: (alertData: any) => {
        this.createZone(alertData.name);
      },
    },
  ];

  async openCreateZoneAlert() {
    const alert = await this.alertController.create({
      header: 'Crear zona',
      inputs: this.zoneAlertInputs,
      buttons: this.zoneAlertButtons,
    });
    await alert.present();
  }

  async createZone(name: string) {
    const zoneForm = new FormData();
    zoneForm.append('name', name);
    this.zoneService.add(zoneForm).subscribe({});
  }

  async addTable() {
    if (this.formulario.invalid) {
      this.formulario.markAllAsTouched();
      return;
    }

    const loading = await this.loadingController.create({
      message: 'Creando mesa.',
    });
    const toast = await this.toastController.create({
      duration: 1500,
      position: 'bottom',
    });

    loading.present();

    const formData = new FormData();
    const valores = this.formulario.getRawValue();
    formData.append('name', valores.name!);
    formData.append('zone_id', valores.zone!);

    this.tableService.add(formData).subscribe({
      next: (response: ApiResponse) => {
        loading.remove();
        toast.message = 'Mesa creada';
        toast.color = 'success';
        toast.present();
        this.formulario.reset();
      },
      error: () => {
        loading.remove();
        toast.message = 'Ha habido un error.';
        toast.color = 'danger';
        toast.present();
      },
    });
  }
}
