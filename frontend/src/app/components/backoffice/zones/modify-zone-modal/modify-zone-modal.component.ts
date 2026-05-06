import { Component, Input, Output, EventEmitter, inject } from '@angular/core';
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
} from '@ionic/angular/standalone';

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
  ],
})
export class ModifyZoneModalComponent {
  @Input() zone!: any;

  private loadingController = inject(LoadingController);
  private toastController = inject(ToastController);
  private modalController = inject(ModalController);

  formulario = new FormGroup({
    name: new FormControl(''),
  });

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

    setTimeout(() => {
      loading.remove();
      toast.message = 'Zona actualizada';
      toast.color = 'success';
      toast.present();
      this.modalController.dismiss({ updated: true });
    }, 1000);
  }

  async closeModal(): Promise<void> {
    await this.modalController.dismiss({ updated: false });
  }
}
