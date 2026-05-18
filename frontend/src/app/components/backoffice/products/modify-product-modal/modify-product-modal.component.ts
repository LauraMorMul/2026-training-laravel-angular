import {
  Component,
  ElementRef,
  inject,
  Input,
  OnInit,
  ViewChild,
} from '@angular/core';
import {
  FormControl,
  FormGroup,
  ReactiveFormsModule,
  Validators,
} from '@angular/forms';
import {
  IonButton,
  IonButtons,
  IonCol,
  IonContent,
  IonGrid,
  IonHeader,
  IonIcon,
  IonImg,
  IonInput,
  IonLabel,
  IonRow,
  IonSelect,
  IonSelectOption,
  IonToggle,
  IonTitle,
  IonToolbar,
  LoadingController,
  ModalController,
  ToastController,
} from '@ionic/angular/standalone';
import { addIcons } from 'ionicons';
import { image } from 'ionicons/icons';
import { IFamilies } from 'src/app/models/family';
import { IProduct } from 'src/app/models/product';
import { ITaxes } from 'src/app/models/tax';
import { ApiResponse } from 'src/app/services/api/base-api.service';
import { ImageFormatter } from 'src/app/services/helper/image-formatter';
import { FamilyService } from 'src/app/services/HTTPRequests/family-service';
import { ProductService } from 'src/app/services/HTTPRequests/product-service';
import { TaxService } from 'src/app/services/HTTPRequests/tax-service';
import { numberFormatter } from 'src/app/shared/utils/number-formatter';

@Component({
  selector: 'app-modify-product-modal',
  templateUrl: './modify-product-modal.component.html',
  styleUrls: ['./modify-product-modal.component.scss'],
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
    IonToggle,
    IonButton,
    ReactiveFormsModule,
    IonIcon,
    IonImg,
    IonButtons,
  ],
})
export class ModifyProductModalComponent implements OnInit {
  @Input() product!: IProduct;
  @ViewChild('fileUpload') fileUpload!: ElementRef<HTMLInputElement>;

  private productService = inject(ProductService);
  private familyService = inject(FamilyService);
  private taxService = inject(TaxService);
  private loadingController = inject(LoadingController);
  private toastController = inject(ToastController);
  private modalController = inject(ModalController);
  public imageService = inject(ImageFormatter);

  families: IFamilies = [];
  taxes: ITaxes = [];
  selectedFile: File | null = null;

  constructor() {
    addIcons({ image });
  }

  formulario = new FormGroup({
    name: new FormControl(''),
    family_id: new FormControl(''),
    tax_id: new FormControl(''),
    price: new FormControl('', [
      Validators.pattern('^[0-9]+([,][0-9]{0,2})?$'),
    ]),
    stock: new FormControl('', [Validators.pattern('^[0-9]*$')]),
    active: new FormControl(true),
    image: new FormControl<File | null>(null),
  });

  openFileDialog(): void {
    this.fileUpload.nativeElement.click();
  }

  setImage(event: Event): void {
    const input = event.target as HTMLInputElement;
    this.selectedFile = input.files?.[0] || null;

    if (this.selectedFile) {
      this.formulario.controls.image.setValue(this.selectedFile);
    }
  }

  async updateProduct() {
    if (this.formulario.invalid) {
      this.formulario.markAllAsTouched();
      return;
    }

    const loading = await this.loadingController.create({
      message: 'Actualizando producto.',
    });
    const toast = await this.toastController.create({
      duration: 1500,
      position: 'bottom',
    });

    await loading.present();

    const formData = new FormData();
    const valores = this.formulario.getRawValue();

    if (valores.name) formData.append('name', valores.name);
    if (valores.family_id) formData.append('family_id', valores.family_id);
    if (valores.tax_id) formData.append('tax_id', valores.tax_id);
    if (valores.price)
      formData.append(
        'price',
        numberFormatter.calculatePriceInInteger(valores.price!).toString(),
      );
    if (valores.stock) formData.append('stock', valores.stock);
    formData.append('active', valores.active ? '1' : '0');
    if (valores.image) formData.append('image', valores.image);

    this.productService.update(this.product.id, formData).subscribe({
      next: (_response: ApiResponse) => {
        loading.remove();
        toast.message = 'Producto actualizado';
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
      name: this.product.name,
      family_id: this.product.family.uuid,
      tax_id: this.product.tax.uuid,
      price: String(
        numberFormatter.calculatePriceWithDecimals(this.product.price).toString().replace('.', ','),
      ),
      stock: String(this.product.stock),
      active: this.product.active,
    });

    this.familyService.getAll().subscribe({
      next: (response: IFamilies) => {
        this.families = [...response];
      },
    });

    this.taxService.getAll().subscribe({
      next: (response: ITaxes) => {
        this.taxes = [...response];
      },
    });
  }
}
