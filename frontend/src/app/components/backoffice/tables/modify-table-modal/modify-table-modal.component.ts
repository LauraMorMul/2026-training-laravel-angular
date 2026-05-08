import { Component, Input, OnInit } from '@angular/core';
import {
  FormControl,
  FormGroup,
  Validators,
  ReactiveFormsModule,
} from '@angular/forms';
import {
  LoadingController,
  ToastController,
  ModalController,
} from '@ionic/angular';
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
  IonSelect,
  IonSelectOption,
} from '@ionic/angular/standalone';
import { ApiResponse } from 'src/app/services/api/base-api.service';
import { TableService } from 'src/app/services/entity/table-service';
import { ZoneService } from 'src/app/services/entity/zone-service';
import { IZone, IZones } from 'src/app/models/zone';

@Component({
  selector: 'app-modify-table-modal',
  templateUrl: './modify-table-modal.component.html',
  styleUrls: ['./modify-table-modal.component.scss'],
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
    IonSelect,
    IonSelectOption,
    IonButton,
    ReactiveFormsModule,
  ],
})
export class ModifyTableModalComponent implements OnInit {
  @Input() table!: any;

  zones: IZones = [];

  formulario = new FormGroup({
    name: new FormControl('', [Validators.required]),
    zone_id: new FormControl('', [Validators.required]),
  });

  constructor(
    private tableService: TableService,
    private zoneService: ZoneService,
    private loadingController: LoadingController,
    private toastController: ToastController,
    private modalController: ModalController,
  ) {}

  ngOnInit(): void {
    this.loadZones();
  }

  loadZones() {
    this.zoneService.getAll().subscribe({
      next: (response: IZones) => {
        this.zones = [...response];
        if (this.table) {
          this.formulario.patchValue({ name: this.table.name, zone_id: this.table.zone_id });
        }
      },
    });
  }

  async updateTable() {
    if (this.formulario.invalid) {
      this.formulario.markAllAsTouched();
      return;
    }

    const loading = await this.loadingController.create({
      message: 'Actualizando mesa.',
    });
    const toast = await this.toastController.create({
      duration: 1500,
      position: 'bottom',
    });

    await loading.present();

    const formData = new FormData();
    const valores = this.formulario.getRawValue();

    if (valores.name) formData.append('name', valores.name);
    if (valores.zone_id) formData.append('zone_id', valores.zone_id);

    this.tableService.update(this.table.id, formData).subscribe({
      next: (response: ApiResponse) => {
        loading.remove();
        toast.message = 'Mesa actualizada';
        toast.color = 'success';
        toast.present();
        this.modalController.dismiss({ updated: true });
      },
      error: () => {
        loading.remove();
        toast.message = 'Error actualizando mesa';
        toast.color = 'danger';
        toast.present();
      },
    });
  }

  async closeModal(): Promise<void> {
    await this.modalController.dismiss({ updated: false });
  }
}
