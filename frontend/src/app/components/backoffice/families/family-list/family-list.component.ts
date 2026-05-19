import { Component, inject, OnInit } from '@angular/core';
import {
  IonCard,
  IonCardHeader,
  IonCardTitle,
  IonCardContent,
  IonGrid,
  IonRow,
  IonCol,
  IonSearchbar,
  IonButton,
  AlertController,
  ToastController,
  ModalController,
  IonIcon,
  IonToggle,
  IonSelect,
  IonSelectOption,
} from '@ionic/angular/standalone';
import { addIcons } from 'ionicons';
import { createOutline, eyeOutline, trashOutline } from 'ionicons/icons';
import { FamilyService } from 'src/app/services/HTTPRequests/family-service';
import { IFamilies, IFamily } from 'src/app/models/family';
import { CheckFamilyModalComponent } from '../check-family-modal/check-family-modal.component';
import { ModifyFamilyModalComponent } from '../modify-family-modal/modify-family-modal.component';
import { FormsModule } from '@angular/forms';
import { FilterByStatePipe } from 'src/app/pipes/shared/filter-by-state-pipe';
import { FilterBySearchBarPipe } from 'src/app/pipes/shared/filter-by-search-bar-pipe';

@Component({
  selector: 'app-family-list',
  templateUrl: './family-list.component.html',
  styleUrls: ['./family-list.component.scss'],
  imports: [
    IonCard,
    IonCardHeader,
    IonCardTitle,
    IonCardContent,
    IonSearchbar,
    IonButton,
    IonIcon,
    IonToggle,
    IonGrid,
    IonRow,
    IonCol,
    IonSelect,
    IonSelectOption,
    FormsModule,
    FilterByStatePipe,
    FilterBySearchBarPipe,
  ],
})
export class FamilyListComponent implements OnInit {
  private familyService = inject(FamilyService);
  private alertController = inject(AlertController);
  private toastController = inject(ToastController);
  private modalCtrl = inject(ModalController);

  families: IFamilies = [];
  results = [...this.families];
  familyID: string | null = '';
  nameFilter: string = '';
  state: string | undefined = undefined;

  constructor() {
    addIcons({ trashOutline, createOutline, eyeOutline });
  }

  ngOnInit() {
    this.getFamilies();
  }

  public actionButtons = [
    {
      text: 'Cancel',
      role: 'cancel',
      handler: () => {
        console.log('Alert confirmed');
      },
    },
    {
      text: 'OK',
      role: 'confirm',
      handler: () => {
        this.deleteFamily(this.familyID!);
      },
    },
  ];

  async changeActive(event: Event, family: IFamily) {
    const target = event?.target as HTMLIonToggleElement;
    target.disabled = true;
    const formData = new FormData();
    formData.append('active', target.checked ? '1' : '0');
    this.familyService.update(family.id, formData).subscribe({
      next: () => {
        target.disabled = false;
      },
      error() {
        console.log('Cambiar esto por un toast, vaga');
      },
    });
  }

  getFamilies() {
    this.familyService.getAll().subscribe({
      next: (response: IFamilies) => {
        this.families = [...response];
        this.results = [...response];
      },
      error() {
        console.log('Error loading families');
      },
    });
  }

  async showDeleteAlert(id: string, name: string) {
    const alert = await this.alertController.create({
      header: 'Eliminar familia',
      subHeader: 'Esta acción es irreversible.',
      message: '¿Eliminar la familia ' + name + '?',
      buttons: this.actionButtons,
    });

    await alert.present();

    this.familyID = id;
  }

  async abrirModalModificar(selectedFamily: object) {
    const modal = await this.modalCtrl.create({
      component: ModifyFamilyModalComponent,
      componentProps: {
        family: selectedFamily,
      },
    });

    await modal.present();

    const { data } = await modal.onDidDismiss();

    if (data?.updated) {
      this.getFamilies();
    }
  }

  async deleteFamily(id: string) {
    const toast = await this.toastController.create({
      duration: 1500,
      position: 'bottom',
    });
    this.familyService.delete(id).subscribe({
      next: () => {
        toast.message = 'Familia eliminada correctamente.';
        toast.color = 'success';
        toast.present();
      },
      error: (err) => {
        switch (err.status) {
          case 500:
            toast.message = 'No se encuentra la familia.';
            toast.color = 'danger';
            toast.present();
            break;
          case 401:
            toast.message = 'No tienes permiso.';
            toast.color = 'danger';
            toast.present();
            break;
          case 403:
            toast.message =
              'No se puede eliminar la familia, esta tiene productos.';
            toast.color = 'warning';
            toast.present();
            break;
          default:
            toast.message = 'Ha habido un error.';
            toast.color = 'danger';
            toast.present();
            break;
        }
      },
    });
  }

  async abrirModalFamily(selectedFamily: any) {
    const modal = await this.modalCtrl.create({
      component: CheckFamilyModalComponent,
      componentProps: {
        family: selectedFamily,
      },
    });
    await modal.present();
  }
}
