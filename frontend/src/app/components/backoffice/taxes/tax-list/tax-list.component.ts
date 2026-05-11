import { Component, inject, OnInit } from '@angular/core';
import {
  AlertController,
  IonAvatar,
  IonButton,
  IonCard,
  IonCardContent,
  IonCardHeader,
  IonCardTitle,
  IonCol,
  IonGrid,
  IonIcon,
  IonItem,
  IonLabel,
  IonList,
  IonRow,
  IonSearchbar,
  ModalController,
  ToastController,
} from '@ionic/angular/standalone';
import { addIcons } from 'ionicons';
import { createOutline, trashOutline } from 'ionicons/icons';
import { ITaxes } from 'src/app/models/tax';
import { TaxService } from 'src/app/services/entity/tax-service';
import { CheckTaxModalComponent } from '../check-tax-modal/check-tax-modal.component';
import { ModifyTaxComponentComponent } from '../modify-tax-component/modify-tax-component.component';

@Component({
  selector: 'app-tax-list',
  templateUrl: './tax-list.component.html',
  styleUrls: ['./tax-list.component.scss'],
  imports: [
    IonCard,
    IonCardHeader,
    IonCardTitle,
    IonCardContent,
    IonGrid,
    IonRow,
    IonCol,
    IonSearchbar,
    IonList,
    IonItem,
    IonLabel,
    IonButton,
    IonIcon
  ],
})
export class TaxListComponent implements OnInit {
  private taxService = inject(TaxService);
  private alertController = inject(AlertController);
  private toastController = inject(ToastController);
  private modalCtrl = inject(ModalController);

  taxes: ITaxes = [];
  results = [...this.taxes];
  taxID: string | null = '';

  constructor() {
    addIcons({ trashOutline, createOutline });
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
        this.results = [...response];
      },
      error() {
        console.log('Ni de coña jeje');
      },
    });
  }

  handleInput(event: Event) {
    const target = event.target as HTMLIonSearchbarElement;
    const query = target.value?.toLowerCase() || '';
    this.results = this.taxes.filter((tax) =>
      tax.name.toLowerCase().includes(query),
    );
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
      error() {
        toast.message = 'Ha habido un error.';
        toast.color = 'danger';
        toast.present();
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
