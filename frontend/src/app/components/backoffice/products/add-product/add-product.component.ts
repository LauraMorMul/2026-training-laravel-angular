import {
  Component,
  ElementRef,
  EventEmitter,
  inject,
  OnInit,
  Output,
  ViewChild,
} from '@angular/core';
import {
  FormControl,
  FormGroup,
  ReactiveFormsModule,
  Validators,
} from '@angular/forms';
import {
  AlertController,
  IonButton,
  IonCard,
  IonCardContent,
  IonCardHeader,
  IonCardTitle,
  IonCol,
  IonGrid,
  IonIcon,
  IonInput,
  IonLabel,
  IonRow,
  IonSelect,
  IonSelectOption,
  IonToggle,
  LoadingController,
  ToastController,
} from '@ionic/angular/standalone';
import { addIcons } from 'ionicons';
import { image } from 'ionicons/icons';
import { IFamilies } from 'src/app/models/family';
import { ITaxes } from 'src/app/models/tax';
import { ApiResponse } from 'src/app/services/api/base-api.service';
import { FamilyService } from 'src/app/services/HTTPRequests/family-service';
import { ProductService } from 'src/app/services/HTTPRequests/product-service';
import { TaxService } from 'src/app/services/HTTPRequests/tax-service';
import { numberFormatter } from 'src/app/shared/utils/number-formatter';

@Component({
  selector: 'app-add-product',
  templateUrl: './add-product.component.html',
  styleUrls: ['./add-product.component.scss'],
  imports: [
    IonCard,
    IonCardHeader,
    IonCardContent,
    IonCardTitle,
    IonGrid,
    IonRow,
    IonCol,
    IonLabel,
    IonInput,
    IonSelect,
    IonSelectOption,
    IonToggle,
    IonButton,
    IonIcon,
    ReactiveFormsModule,
  ],
})
export class AddProductComponent implements OnInit {
  @Output() productCreated = new EventEmitter<void>();
  @ViewChild('fileUpload') fileUpload!: ElementRef<HTMLInputElement>;

  private productService = inject(ProductService);
  private familyService = inject(FamilyService);
  private taxService = inject(TaxService);
  private loadingController = inject(LoadingController);
  private toastController = inject(ToastController);
  private alertController = inject(AlertController);

  families: IFamilies = [];
  taxes: ITaxes = [];
  selectedFile: File | null = null;

  constructor() {
    addIcons({ image });
  }

  formulario = new FormGroup({
    name: new FormControl('', Validators.required),
    family_id: new FormControl('', Validators.required),
    tax_id: new FormControl('', Validators.required),
    price: new FormControl('', [
      Validators.required,
      Validators.pattern('^[0-9]+([,][0-9]{0,2})?$'),
    ]),
    stock: new FormControl('', [
      Validators.required,
      Validators.pattern('^[0-9]*$'),
    ]),
    active: new FormControl(true),
    image: new FormControl<File | null>(null, Validators.required),
  });

  ngOnInit() {
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

  public familyAlertInputs = [
    {
      name: 'name',
      placeholder: 'Nombre de la zona',
    },
  ];

  public familyAlertButtons = [
    {
      text: 'Cancel',
      role: 'cancel',
    },
    {
      text: 'OK',
      role: 'confirm',
      //No tengo ni idea de que tipo de dato es este
      handler: (alertData: any) => {
        this.createFamily(alertData.name);
      },
    },
  ];

  public taxAlertInputs = [
    {
      name: 'name',
      placeholder: 'Nombre del impuesto',
    },
    {
      name: 'percentage',
      placeholder: 'Porcentaje',
    },
  ];

  public taxAlertButtons = [
    {
      text: 'Cancel',
      role: 'cancel',
    },
    {
      text: 'OK',
      role: 'confirm',
      //No tengo ni idea de que tipo de dato es este
      handler: (alertData: any) => {
        this.createTax(alertData.name, alertData.percentage);
      },
    },
  ];

  async openCreateFamilyAlert() {
    const alert = await this.alertController.create({
      header: 'Crear familia',
      subHeader: 'Activa por defecto',
      inputs: this.familyAlertInputs,
      buttons: this.familyAlertButtons,
    });
    await alert.present();
  }

  async openCreateTaxAlert() {
    const alert = await this.alertController.create({
      header: 'Crear impuesto',
      inputs: this.taxAlertInputs,
      buttons: this.taxAlertButtons,
    });
    await alert.present();
  }

  async createFamily(name: string) {
    const familyForm = new FormData();
    familyForm.append('name', name);
    familyForm.append('active', '1');
    this.familyService.add(familyForm).subscribe({});
  }

  async createTax(name: string, percentage: number) {
    const taxForm = new FormData();
    taxForm.append('name', name);
    taxForm.append('percentage', percentage.toString());
    this.taxService.add(taxForm).subscribe({});
  }

  async addProduct() {
    if (this.formulario.invalid) {
      this.formulario.markAllAsTouched();
      return;
    }

    const loading = await this.loadingController.create({
      message: 'Creando producto.',
    });
    const toast = await this.toastController.create({
      duration: 1500,
      position: 'bottom',
    });

    await loading.present();

    const formData = new FormData();
    const valores = this.formulario.getRawValue();

    formData.append('name', valores.name!);
    formData.append('family_id', valores.family_id!);
    formData.append('tax_id', valores.tax_id!);
    formData.append(
      'price',
      numberFormatter.calculatePriceInInteger(valores.price!).toString(),
    );
    formData.append('stock', valores.stock!);
    formData.append('active', valores.active ? '1' : '0');
    formData.append('image', valores.image!);

    this.productService.add(formData).subscribe({
      next: (_response: ApiResponse) => {
        loading.remove();
        toast.message = 'Producto creado';
        toast.color = 'success';
        toast.present();
        this.productCreated.emit();
        this.formulario.reset({ active: true });
        this.selectedFile = null;
      },
      error: () => {
        loading.remove();
        toast.message = 'Ha habido un error.';
        toast.color = 'danger';
        toast.present();
      },
    });
  }

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
}
