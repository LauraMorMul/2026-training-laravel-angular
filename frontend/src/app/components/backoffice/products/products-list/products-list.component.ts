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
  IonToggle,
  IonThumbnail,
  IonCol,
  IonRow,
  IonGrid,
  IonSelect,
  IonSelectOption,
} from '@ionic/angular/standalone';
import { addIcons } from 'ionicons';
import {
  addCircleOutline,
  createOutline,
  eyeOutline,
  trashOutline,
} from 'ionicons/icons';
import { IProduct, IProducts } from 'src/app/models/product';
import { ProductService } from 'src/app/services/HTTPRequests/product-service';
import { CheckProductModalComponent } from '../check-product-modal/check-product-modal.component';
import { ModifyProductModalComponent } from '../modify-product-modal/modify-product-modal.component';
import { FamilyService } from 'src/app/services/HTTPRequests/family-service';
import { TaxService } from 'src/app/services/HTTPRequests/tax-service';
import { ITaxes } from 'src/app/models/tax';
import { IFamilies } from 'src/app/models/family';
import { ImageFormatter } from 'src/app/services/helper/image-formatter';
import { MoneyFormatterPipe } from 'src/app/pipes/money-formatter-pipe';
import { CurrencyPipe } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { FilterByTaxPipe } from 'src/app/pipes/product/filter-by-tax-pipe';
import { FilterBySearchBarPipe } from 'src/app/pipes/shared/filter-by-search-bar-pipe';
import { FilterByStatePipe } from 'src/app/pipes/shared/filter-by-state-pipe';
import { FilterProductByFamilyPipe } from 'src/app/pipes/product/filter-by-family-pipe';

@Component({
  selector: 'app-products-list',
  templateUrl: './products-list.component.html',
  styleUrls: ['./products-list.component.scss'],
  imports: [
    IonCard,
    IonCardHeader,
    IonCardTitle,
    IonCardContent,
    IonSearchbar,
    IonButton,
    IonIcon,
    IonToggle,
    IonThumbnail,
    IonCol,
    IonRow,
    IonGrid,
    IonSelect,
    IonSelectOption,
    MoneyFormatterPipe,
    CurrencyPipe,
    FilterProductByFamilyPipe,
    FormsModule,
    FilterByTaxPipe,
    FilterBySearchBarPipe,
    FilterByStatePipe,
  ],
})
export class ProductsListComponent implements OnInit {
  private productService = inject(ProductService);
  private alertController = inject(AlertController);
  private toastController = inject(ToastController);
  private modalCtrl = inject(ModalController);
  private familyService = inject(FamilyService);
  private taxService = inject(TaxService);
  public imageService = inject(ImageFormatter);

  products: IProducts = [];
  productID: string | null = '';
  families: IFamilies = [];
  taxes: ITaxes = [];
  familyUuid: string = '';
  taxUuid: string = '';
  nameFilter: string = '';
  state: string | undefined = undefined;

  constructor() {
    addIcons({ trashOutline, createOutline, eyeOutline, addCircleOutline });
  }

  ngOnInit() {
    this.getProducts();
    this.getFamilies();
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
        this.deleteProduct(this.productID!);
      },
    },
  ];

  async changeActive(event: Event, product: IProduct) {
    const target = event?.target as HTMLIonToggleElement;
    target.disabled = true;
    const formData = new FormData();
    formData.append('active', target.checked ? '1' : '0');
    this.productService.update(product.id, formData).subscribe({
      next: () => {
        target.disabled = false;
      },
      error() {
        console.log('Cambiar esto por un toast, vaga 2.0');
      },
    });
  }

  getProducts() {
    this.productService.getAll().subscribe({
      next: (response: IProducts) => {
        this.products = [...response];
      },
      error() {
        console.log('Ni de coña jeje');
      },
    });
  }

  getFamilies() {
    this.familyService.getAll().subscribe({
      next: (response: IFamilies) => {
        this.families = [...response];
      },
    });
  }

  getTaxes() {
    this.taxService.getAll().subscribe({
      next: (response: ITaxes) => {
        this.taxes = [...response];
      },
    });
  }

  async showDeleteAlert(id: string, name: string) {
    const alert = await this.alertController.create({
      header: 'Eliminar producto',
      subHeader: 'Esta acción es irreversible.',
      message: '¿Eliminar el producto ' + name + '?',
      buttons: this.actionButtons,
    });

    await alert.present();

    this.productID = id;
  }

  async abrirModalModificar(selectedProduct: object) {
    const modal = await this.modalCtrl.create({
      component: ModifyProductModalComponent,
      componentProps: {
        product: selectedProduct,
      },
      cssClass: 'modal-modify__product'
    });

    await modal.present();

    const { data } = await modal.onDidDismiss();

    if (data?.updated) {
      this.getProducts();
    }
  }

  async deleteProduct(id: string) {
    const toast = await this.toastController.create({
      duration: 1500,
      position: 'bottom',
    });

    this.productService.delete(id).subscribe({
      next: () => {
        toast.message = 'Producto eliminado correctamente.';
        toast.color = 'success';
        toast.present();
      },
      error: (err) => {
        switch (err.status) {
          case 500:
            toast.message = 'No se encuentra el producto.';
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
              'No se puede eliminar el producto, tiene líneas de venta relacionadas.';
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

  async abrirModalProducto(selectedProduct: any) {
    const modal = await this.modalCtrl.create({
      component: CheckProductModalComponent,
      componentProps: {
        product: selectedProduct,
      },
      cssClass: 'modal-check__product'
    });

    await modal.present();
  }
}
