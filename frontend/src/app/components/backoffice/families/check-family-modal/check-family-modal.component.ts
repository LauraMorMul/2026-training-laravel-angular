import { Component, inject, Input, OnInit } from '@angular/core';
import { IonContent, IonHeader, IonToolbar, IonTitle, IonButtons, IonButton, ModalController, IonList, IonItem, IonThumbnail, IonLabel, IonListHeader } from '@ionic/angular/standalone';
import { IFamily } from 'src/app/models/family';
import { IProducts } from 'src/app/models/product';
import { FilterProductByFamilyPipe } from 'src/app/pipes/product/filter-by-family-pipe';
import { ImageFormatter } from 'src/app/services/helper/image-formatter';
import { ProductService } from 'src/app/services/HTTPRequests/product-service';
import { MoneyFormatterPipe } from "../../../../pipes/money-formatter-pipe";
import { CurrencyPipe } from '@angular/common';

@Component({
  selector: 'app-check-family-modal',
  templateUrl: './check-family-modal.component.html',
  styleUrls: ['./check-family-modal.component.scss'],
  imports: [IonContent, IonHeader, IonToolbar, IonTitle, IonButtons, IonButton, FilterProductByFamilyPipe, IonList, IonItem, IonThumbnail, IonLabel, MoneyFormatterPipe, CurrencyPipe, IonListHeader],
})
export class CheckFamilyModalComponent implements OnInit{
  private modalCtrl = inject(ModalController);
  private productService = inject(ProductService);
  public imageService = inject(ImageFormatter);

  products: IProducts = [];

  @Input()
  family!: IFamily;

  ngOnInit(): void {
    this.getProducts();
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

  closeModal() {
    this.modalCtrl.dismiss();
  }
}

