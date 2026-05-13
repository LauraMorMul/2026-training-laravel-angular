import { Component, inject } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
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
import { TaxService } from 'src/app/services/HTTPRequests/tax-service';
import { ApiResponse } from 'src/app/services/api/base-api.service';

@Component({
  selector: 'app-add-tax',
  templateUrl: './add-tax.component.html',
  styleUrls: ['./add-tax.component.scss'],
  imports: [
    IonCard,
    IonCardHeader,
    IonCardContent,
    IonCardTitle,
    IonGrid,
    IonRow,
    IonCol,
    IonLabel,
    IonInput,
    IonButton,
    ReactiveFormsModule,
  ],
})
export class AddTaxComponent {
  private taxService = inject(TaxService);
  private loadingController = inject(LoadingController);
  private toastController = inject(ToastController);

  formulario = new FormGroup({
    name: new FormControl('', Validators.required),
    percentage: new FormControl('', [Validators.required, Validators.pattern('^[0-9]+([.][0-9]+)?$')]),
  });

  async addTax() {
    if (this.formulario.invalid) {
      this.formulario.markAllAsTouched();
      return;
    }

    const loading = await this.loadingController.create({
      message: 'Creando impuesto.',
    });
    const toast = await this.toastController.create({
      duration: 1500,
      position: 'bottom',
    });

    await loading.present();

    const formData = new FormData();
    const valores = this.formulario.getRawValue();

    if (valores.name) formData.append('name', valores.name);
    if (valores.percentage) formData.append('percentage', valores.percentage);

    this.taxService.add(formData).subscribe({
      next: (_response: ApiResponse) => {
        loading.remove();
        toast.message = 'Impuesto creado';
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
