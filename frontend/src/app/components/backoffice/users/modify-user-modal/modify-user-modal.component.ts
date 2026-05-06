import {
  Component,
  ElementRef,
  inject,
  Input,
  OnInit,
  ViewChild,
} from '@angular/core';
import {
  AbstractControl,
  FormControl,
  FormGroup,
  ValidationErrors,
  ValidatorFn,
  Validators,
  ReactiveFormsModule,
} from '@angular/forms';
import {
  IonButton,
  IonCol,
  IonContent,
  IonGrid,
  IonHeader,
  IonIcon,
  IonImg,
  IonInput,
  IonInputPasswordToggle,
  IonLabel,
  IonRow,
  IonSelect,
  IonSelectOption,
  IonTitle,
  IonToolbar,
    ModalController,
  LoadingController,
  ToastController,
} from '@ionic/angular/standalone';
import { addIcons } from 'ionicons';
import { image } from 'ionicons/icons';
import { ImageFormatterPipePipe } from 'src/app/pipes/image-formatter-pipe-pipe';
import { UserService } from 'src/app/services/entity/user-service';

@Component({
  selector: 'app-modify-user-modal',
  templateUrl: './modify-user-modal.component.html',
  styleUrls: ['./modify-user-modal.component.scss'],
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
    IonInputPasswordToggle,
    IonSelect,
    IonSelectOption,
    IonButton,
    ReactiveFormsModule,
    IonIcon,
    IonImg,
    ImageFormatterPipePipe
  ],
})
export class ModifyUserModalComponent implements OnInit {
    @Input() user!: any;
    @ViewChild('fileUpload') fileUpload!: ElementRef<HTMLInputElement>;

    private userService = inject(UserService);
    private loadingController = inject(LoadingController);
    private toastController = inject(ToastController);
    private modalController = inject(ModalController);

    selectedFile: File | null = null;

    constructor() {
        addIcons({ image });
    }

    passwordMatchValidator: ValidatorFn = (
        form: AbstractControl,
    ): ValidationErrors | null => {
        const password = form.get('password')?.value;
        const confirmPassword = form.get('password_confirmation')?.value;

        if (confirmPassword !== password) {
            form.get('password_confirmation')?.setErrors({ notEqual: true });
        }

        return null;
    };

    passwordStrength: ValidatorFn = (
        control: AbstractControl,
    ): ValidationErrors | null => {
        const value = control.value;

        if (!value) return null;

        const regex = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>]).+$/;

        return regex.test(value) ? null : { insecure: true };
    };

    formulario = new FormGroup(
        {
            name: new FormControl(''),
            email: new FormControl('', Validators.email),
            password: new FormControl('', this.passwordStrength),
            password_confirmation: new FormControl(''),
            role: new FormControl(''),
            image: new FormControl<File | null>(null),
            pin: new FormControl(''),
        },
        { validators: [this.passwordMatchValidator] },
    );

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

    async updateUser() {
        if (this.formulario.invalid) {
            this.formulario.markAllAsTouched();
            return;
        }

        const loading = await this.loadingController.create({
            message: 'Actualizando usuario.',
        });
        const toast = await this.toastController.create({
            duration: 1500,
            position: 'bottom',
        });

        loading.present();

        const formData = new FormData();
        const valores = this.formulario.getRawValue();

        if (valores.name) formData.append('name', valores.name);
        if (valores.email) formData.append('email', valores.email);
        if (valores.password) {
            formData.append('password', valores.password);
            formData.append('password_confirmation', valores.password_confirmation!);
        }
        if (valores.role) formData.append('role', valores.role);
        if (valores.pin) formData.append('pin', valores.pin);
        if (valores.image) formData.append('image', valores.image);

        this.userService.update(this.user.id, formData).subscribe({
            next: (response: any) => {
                loading.remove();
                toast.message = 'Usuario actualizado';
                toast.color = 'success';
                toast.present();
                this.modalController.dismiss({ updated: true });
            },
            error: (err) => {
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
            role: this.user.role,
        });
    }
}
