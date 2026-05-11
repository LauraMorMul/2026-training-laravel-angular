import { Component, Input, Output, EventEmitter, inject, OnInit } from '@angular/core';
import {
  AbstractControl,
  FormControl,
  FormGroup,
  ValidationErrors,
  ValidatorFn,
  Validators,
  ReactiveFormsModule,
} from '@angular/forms';
import {
  IonButton,
  IonCol,
  IonContent,
  IonGrid,
  IonHeader,
  IonInput,
  IonLabel,
  IonRow,
  IonTitle,
  IonToolbar,
  LoadingController,
  ToastController,
  ModalController,
  IonButtons,
} from '@ionic/angular/standalone';
import { ApiResponse } from 'src/app/services/api/base-api.service';
import { ZoneService } from 'src/app/services/entity/zone-service';

@Component({
  selector: 'app-modify-zone-modal',
  templateUrl: './modify-zone-modal.component.html',
  styleUrls: ['./modify-zone-modal.component.scss'],
  standalone: true,
  imports: [
    IonContent,
    IonHeader,
    IonToolbar,
    IonTitle,
    IonGrid,
    IonRow,
    IonCol,
    IonLabel,
    IonInput,
    IonButton,
    ReactiveFormsModule,
    IonButtons,
  ],
})
export class ModifyZoneModalComponent implements OnInit{
  @Input() zone!: any;

  private zoneService = inject(ZoneService);
  private loadingController = inject(LoadingController);
  private toastController = inject(ToastController);
  private modalController = inject(ModalController);

  formulario = new FormGroup({
    name: new FormControl(''),
  });

  ngOnInit() {
    this.formulario.patchValue({
      name: this.zone.name,
    });
  }

  async updateZone() {
    if (this.formulario.invalid) {
      this.formulario.markAllAsTouched();
      return;
    }

    const loading = await this.loadingController.create({
      message: 'Actualizando zona.',
    });
    const toast = await this.toastController.create({
      duration: 1500,
      position: 'bottom',
    });

    loading.present();

    const formData = new FormData();
    const valores = this.formulario.getRawValue();

    if (valores.name) formData.append('name', valores.name);

    this.zoneService.update(this.zone.id, formData).subscribe({
      next: (response: ApiResponse) => {
        loading.remove();
        toast.message = 'Zona actualizada';
        toast.color = 'success';
        toast.present();
        this.modalController.dismiss({ updated: true });
      }
    })
  }

  async closeModal(): Promise<void> {
    await this.modalController.dismiss({ updated: false });
  }
}
