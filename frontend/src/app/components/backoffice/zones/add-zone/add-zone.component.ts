import { Component, inject } from '@angular/core';
import {
  FormControl,
  FormGroup,
  ReactiveFormsModule,
  Validators,
} from '@angular/forms';
import {
  IonButton,
  IonCard,
  IonCardContent,
  IonCardHeader,
  IonCardTitle,
  IonCol,
  IonGrid,
  IonInput,
  IonLabel,
  IonRow,
  LoadingController,
  ToastController,
} from '@ionic/angular/standalone';
import { ApiResponse } from 'src/app/services/api/base-api.service';
import { ZoneService } from 'src/app/services/HTTPRequests/zone-service';

@Component({
  selector: 'app-add-zone',
  templateUrl: './add-zone.component.html',
  styleUrls: ['./add-zone.component.scss'],
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
  ],
})
export class AddZoneComponent {

  private zoneService = inject(ZoneService);
  private loadingController = inject(LoadingController);
  private toastController = inject(ToastController);

  formulario = new FormGroup({
    name: new FormControl('', [Validators.required]),
  });

  async addZone() {
    if (this.formulario.invalid) {
      this.formulario.markAllAsTouched();
      return;
    }

    const loading = await this.loadingController.create({
      message: 'Creando zona.',
    });
    const toast = await this.toastController.create({
      duration: 1500,
      position: 'bottom',
    });

    loading.present();

    const formData = new FormData();
    const valores = this.formulario.getRawValue();
    formData.append('name', valores.name!);

    this.zoneService.add(formData).subscribe({
      next: (response: ApiResponse) => {
        loading.remove();
        toast.message = 'Zona creada';
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
