import { Component, inject, OnInit } from '@angular/core';
import {
  AlertController,
  IonButton,
  IonCard,
  IonCardContent,
  IonCardHeader,
  IonCardTitle,
  IonIcon,
  IonSearchbar,
  ModalController,
  ToastController,
  IonCol,
  IonRow,
  IonGrid,
} from '@ionic/angular/standalone';
import { addIcons } from 'ionicons';
import { createOutline, eyeOutline, trashOutline } from 'ionicons/icons';
import { ITaxes } from 'src/app/models/tax';
import { TaxService } from 'src/app/services/HTTPRequests/tax-service';
import { CheckTaxModalComponent } from '../check-tax-modal/check-tax-modal.component';
import { ModifyTaxComponentComponent } from '../modify-tax-component/modify-tax-component.component';
import { FormsModule } from '@angular/forms';
import { FilterBySearchBarPipe } from 'src/app/pipes/shared/filter-by-search-bar-pipe';

@Component({
  selector: 'app-tax-list',
  templateUrl: './tax-list.component.html',
  styleUrls: ['./tax-list.component.scss'],
  imports: [
    IonCard,
    IonCardHeader,
    IonCardTitle,
    IonCardContent,
    IonSearchbar,
    IonButton,
    IonIcon,
    IonCol,
    IonRow,
    IonGrid,
    FormsModule,
    FilterBySearchBarPipe,
  ],
})
export class TaxListComponent implements OnInit {
  private taxService = inject(TaxService);
  private alertController = inject(AlertController);
  private toastController = inject(ToastController);
  private modalCtrl = inject(ModalController);

  taxes: ITaxes = [];
  taxID: string | null = '';
  nameFilter: string = '';

  constructor() {
    addIcons({ trashOutline, createOutline, eyeOutline });
  }

  ngOnInit() {
    this.getTaxes();
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
        this.deleteTax(this.taxID!);
      },
    },
  ];

  getTaxes() {
    this.taxService.getAll().subscribe({
      next: (response: ITaxes) => {
        this.taxes = [...response];
      },
      error() {
        console.log('Ni de coña jeje');
      },
    });
  }

  async showDeleteAlert(id: string, name: string) {
    const alert = await this.alertController.create({
      header: 'Eliminar impuesto',
      subHeader: 'Esta acción es irreversible.',
      message: '¿Eliminar el impuesto ' + name + '?',
      buttons: this.actionButtons,
    });

    await alert.present();

    this.taxID = id;
  }

  async abrirModalModificar(selectedTax: object) {
    const modal = await this.modalCtrl.create({
      component: ModifyTaxComponentComponent,
      componentProps: {
        tax: selectedTax,
      },
    });

    await modal.present();

    const { data } = await modal.onDidDismiss();

    if (data?.updated) {
      this.getTaxes();
    }
  }

  async deleteTax(id: string) {
    const toast = await this.toastController.create({
      duration: 1500,
      position: 'bottom',
    });

    this.taxService.delete(id).subscribe({
      next: () => {
        toast.message = 'Impuesto eliminado correctamente.';
        toast.color = 'success';
        toast.present();
      },
      error: (err) => {
        switch (err.status) {
          case 500:
            toast.message = 'No se encuentra el impuesto.';
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
              'No se puede eliminar el impuesto, tiene productos relacionados.';
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

  async abrirModalTax(selectedTax: any) {
    const modal = await this.modalCtrl.create({
      component: CheckTaxModalComponent,
      componentProps: {
        tax: selectedTax,
      },
    });

    await modal.present();
  }
}
