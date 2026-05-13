import { Component, inject, Input, OnInit } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import {
  IonButton,
  IonButtons,
  IonCol,
  IonContent,
  IonHeader,
  IonInput,
  IonLabel,
  IonRow,
  IonTitle,
  IonToolbar,
  LoadingController,
  ModalController,
  ToastController,
} from '@ionic/angular/standalone';
import { ITax } from 'src/app/models/tax';
import { TaxService } from 'src/app/services/HTTPRequests/tax-service';
import { ApiResponse } from 'src/app/services/api/base-api.service';

@Component({
  selector: 'app-modify-tax-component',
  templateUrl: './modify-tax-component.component.html',
  styleUrls: ['./modify-tax-component.component.scss'],
  standalone: true,
  imports: [
    IonContent,
    IonHeader,
    IonToolbar,
    IonTitle,
    IonRow,
    IonCol,
    IonLabel,
    IonInput,
    IonButton,
    ReactiveFormsModule,
    IonButtons,
  ],
})
export class ModifyTaxComponentComponent implements OnInit {
  @Input() tax!: ITax;

  private taxService = inject(TaxService);
  private loadingController = inject(LoadingController);
  private toastController = inject(ToastController);
  private modalController = inject(ModalController);

  formulario = new FormGroup({
    name: new FormControl(''),
    percentage: new FormControl('', [Validators.pattern('^[0-9]+([.][0-9]+)?$')]),
  });

  async updateTax() {
    if (this.formulario.invalid) {
      this.formulario.markAllAsTouched();
      return;
    }

    const loading = await this.loadingController.create({
      message: 'Actualizando impuesto.',
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

    this.taxService.update(this.tax.id, formData).subscribe({
      next: (_response: ApiResponse) => {
        loading.remove();
        toast.message = 'Impuesto actualizado';
        toast.color = 'success';
        toast.present();
        this.modalController.dismiss({ updated: true });
      },
      error: () => {
        loading.remove();
        toast.message = 'Ha habido un error.';
        toast.color = 'danger';
        toast.present();
      },
    });
  }

  async closeModal(): Promise<void> {
    await this.modalController.dismiss({ updated: false });
  }

  ngOnInit() {
    this.formulario.patchValue({
      name: this.tax.name,
      percentage: String(this.tax.percentage),
    });
  }

}
