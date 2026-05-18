import { CurrencyPipe } from '@angular/common';
import { Component, inject, Input } from '@angular/core';
import {
  IonButton,
  IonButtons,
  IonContent,
  IonHeader,
  IonImg,
  IonTitle,
  IonToolbar,
  ModalController,
} from '@ionic/angular/standalone';
import { IProduct } from 'src/app/models/product';
import { ProductStatusPipe } from 'src/app/pipes/product-status-pipe';
import { ImageFormatter } from 'src/app/services/helper/image-formatter';

@Component({
  selector: 'app-check-product-modal',
  templateUrl: './check-product-modal.component.html',
  styleUrls: ['./check-product-modal.component.scss'],
  imports: [
    IonContent,
    IonHeader,
    IonToolbar,
    IonTitle,
    IonButtons,
    IonButton,
    IonImg,
    ProductStatusPipe,
    CurrencyPipe
  ],
})
export class CheckProductModalComponent {
  private modalCtrl = inject(ModalController);
  public imageService = inject(ImageFormatter);

  calculatePriceWithDecimals(price: number) {
    return price/100;
  }

  @Input()
  product!: IProduct;

  confirm() {
    return this.modalCtrl.dismiss();
  }

  closeModal() {
    this.modalCtrl.dismiss();
  }

}
