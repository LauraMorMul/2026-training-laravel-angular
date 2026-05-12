import { Component, inject, OnInit } from '@angular/core';
import { IonCard, IonCardHeader, IonCardTitle, IonCardContent, IonGrid, IonRow, IonCol, IonSearchbar, IonList, IonItem, IonLabel, IonButton, AlertController, ToastController, ModalController, IonIcon, IonToggle } from '@ionic/angular/standalone';
import { addIcons } from 'ionicons';
import { createOutline, trashOutline } from 'ionicons/icons';
import { FamilyService } from 'src/app/services/entity/family-service';
import { IFamilies, IFamily } from 'src/app/models/family';
import { CheckFamilyModalComponent } from '../check-family-modal/check-family-modal.component';
import { ModifyFamilyModalComponent } from '../modify-family-modal/modify-family-modal.component';

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
    IonList,
    IonItem,
    IonLabel,
    IonButton,
    IonIcon,
    IonToggle
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

  constructor() {
    addIcons({ trashOutline, createOutline });
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
    formData.append('name', family.name);
    this.familyService.update(family.id, formData).subscribe({
      next: () => {
        target.disabled = false;
      },
      error() {
        console.log("Cambiar esto por un toast, vaga")
      }
    })
    
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

  handleInput(event: Event) {
    const target = event.target as HTMLIonSearchbarElement;
    const query = target.value?.toLowerCase() || '';
    this.results = this.families.filter((d) =>
      d.name.toLowerCase().includes(query),
    );
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
      error() {
        toast.message = 'Ha habido un error.';
        toast.color = 'danger';
        toast.present();
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
