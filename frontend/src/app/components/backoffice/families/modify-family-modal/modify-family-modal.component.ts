import { Component, inject, Input, OnInit } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import {
  IonContent,
  IonHeader,
  IonToolbar,
  IonTitle,
  IonRow,
  IonCol,
  IonLabel,
  IonInput,
  IonToggle,
  IonButton,
  LoadingController,
  ModalController,
  ToastController,
} from '@ionic/angular/standalone';
import { IFamily } from 'src/app/models/family';
import { FamilyService } from 'src/app/services/entity/family-service';
import { ApiResponse } from 'src/app/services/api/base-api.service';

@Component({
  selector: 'app-modify-family-modal',
  templateUrl: './modify-family-modal.component.html',
  styleUrls: ['./modify-family-modal.component.scss'],
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
    IonToggle,
    IonButton,
    ReactiveFormsModule,
  ],
})
export class ModifyFamilyModalComponent implements OnInit {
  @Input() family!: IFamily;

  private familyService = inject(FamilyService);
  private loadingController = inject(LoadingController);
  private toastController = inject(ToastController);
  private modalController = inject(ModalController);

  formulario = new FormGroup({
    name: new FormControl('', Validators.required),
    active: new FormControl(true),
  });

  ngOnInit() {
    this.formulario.patchValue({
      name: this.family.name,
      active: this.family.active,
    });
  }

  async updateFamily() {
    if (this.formulario.invalid) {
      this.formulario.markAllAsTouched();
      return;
    }

    const loading = await this.loadingController.create({
      message: 'Actualizando familia.',
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

    this.familyService.update(this.family.id, formData).subscribe({
      next: (_response: ApiResponse) => {
        loading.remove();
        toast.message = 'Familia actualizada';
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
}
