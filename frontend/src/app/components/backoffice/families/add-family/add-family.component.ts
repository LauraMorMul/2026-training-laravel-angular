import { Component, inject } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import {
  IonCard,
  IonCardHeader,
  IonCardTitle,
  IonCardContent,
  IonGrid,
  IonRow,
  IonCol,
  IonLabel,
  IonInput,
  IonToggle,
  IonButton,
  LoadingController,
  ToastController,
} from '@ionic/angular/standalone';
import { FamilyService } from 'src/app/services/entity/family-service';
import { ApiResponse } from 'src/app/services/api/base-api.service';

@Component({
  selector: 'app-add-family',
  templateUrl: './add-family.component.html',
  styleUrls: ['./add-family.component.scss'],
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
    IonToggle,
    IonButton,
    ReactiveFormsModule,
  ],
})
export class AddFamilyComponent {
  private familyService = inject(FamilyService);
  private loadingController = inject(LoadingController);
  private toastController = inject(ToastController);

  formulario = new FormGroup({
    name: new FormControl('', Validators.required),
    active: new FormControl(true),
  });

  async addFamily() {
    if (this.formulario.invalid) {
      this.formulario.markAllAsTouched();
      return;
    }

    const loading = await this.loadingController.create({
      message: 'Creando familia.',
    });
    const toast = await this.toastController.create({
      duration: 1500,
      position: 'bottom',
    });

    await loading.present();

    const formData = new FormData();
    const valores = this.formulario.getRawValue();

    if (valores.name) formData.append('name', valores.name);
    formData.append('active', valores.active ? '1' : '0');

    this.familyService.add(formData).subscribe({
      next: (_response: ApiResponse) => {
        loading.remove();
        toast.message = 'Familia creada';
        toast.color = 'success';
        toast.present();
        this.formulario.reset({ active: true });
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