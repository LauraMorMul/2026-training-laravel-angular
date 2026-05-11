import { Component, EventEmitter, OnInit, Output, inject } from '@angular/core';
import {
  FormControl,
  FormGroup,
  ReactiveFormsModule,
  Validators,
} from '@angular/forms';
import { IonButton, IonCard, IonCardContent, IonCardHeader, IonCardTitle, IonCol, IonGrid, IonInput, IonLabel, IonRow, IonSelect, IonSelectOption, LoadingController, ToastController, IonModal, IonHeader, IonToolbar, IonButtons, IonTitle, IonContent, IonItem } from '@ionic/angular/standalone';
import { IonModalCustomEvent,OverlayEventDetail } from '@ionic/core';
import { IZones } from 'src/app/models/zone';
import { ApiResponse } from 'src/app/services/api/base-api.service';
import { TableService } from 'src/app/services/entity/table-service';
import { ZoneService } from 'src/app/services/entity/zone-service';

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
    IonModal,
    IonHeader,
    IonToolbar,
    IonButtons,
    IonTitle,
    IonContent,
    IonItem
],
})
export class AddTableComponent implements OnInit{
onWillDismiss($event: IonModalCustomEvent<OverlayEventDetail<any>>) {
throw new Error('Method not implemented.');
}
cancel() {
throw new Error('Method not implemented.');
}
confirm() {
throw new Error('Method not implemented.');
}
  @Output() userCreated = new EventEmitter<void>();

  private tableService = inject(TableService);
  private loadingController = inject(LoadingController);
  private toastController = inject(ToastController);
  private zoneService = inject(ZoneService);

  formulario = new FormGroup({
    name: new FormControl('', [Validators.required]),
    zone: new FormControl('', Validators.required),
  });
  zones: IZones = [];
name: any;

  ngOnInit(): void {
    this.getZones()
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
        this.userCreated.emit();
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
