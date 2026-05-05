import {
  Component,
  ElementRef,
  EventEmitter,
  inject,
  Output,
  ViewChild,
} from '@angular/core';
import {
  AbstractControl,
  FormControl,
  FormGroup,
  ReactiveFormsModule,
  ValidationErrors,
  ValidatorFn,
  Validators,
} from '@angular/forms';
import {
  IonCard,
  IonCardHeader,
  IonCardContent,
  IonInput,
  IonLabel,
  IonInputPasswordToggle,
  IonSelect,
  IonSelectOption,
  IonCardTitle,
  IonButton,
  LoadingController,
  ToastController,
  IonIcon,
} from '@ionic/angular/standalone';
import { addIcons } from 'ionicons';
import { UserService } from 'src/app/services/entity/user-service';
import { image } from 'ionicons/icons';

@Component({
  selector: 'app-add-user',
  templateUrl: './add-user.component.html',
  styleUrls: ['./add-user.component.scss'],
  imports: [
    IonCard,
    IonCardHeader,
    IonCardContent,
    IonInput,
    ReactiveFormsModule,
    IonLabel,
    IonInputPasswordToggle,
    IonSelect,
    IonSelectOption,
    IonCardTitle,
    IonButton,
    IonIcon,
  ],
})
export class AddUserComponent {
  @Output() userCreated = new EventEmitter<void>();
  @ViewChild('fileUpload') fileUpload!: ElementRef<HTMLInputElement>;

  private userService = inject(UserService);
  private loadingController = inject(LoadingController);
  private toastController = inject(ToastController);

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

  formulario = new FormGroup(
    {
      name: new FormControl('', Validators.required),
      email: new FormControl('', [Validators.required, Validators.email]),
      password: new FormControl('', [Validators.required, this.hasUppercase]),
      password_confirmation: new FormControl('', Validators.required),
      role: new FormControl('', Validators.required),
      image: new FormControl<File | null>(null, Validators.required),
      pin: new FormControl('', Validators.required),
    },
    { validators: [this.passwordMatchValidator] },
  );

  async addUser() {
    if (this.formulario.invalid) {
      this.formulario.markAllAsTouched();
      return;
    } else {
      const loading = await this.loadingController.create({
        message: 'Creando usuario.',
      });
      const toast = await this.toastController.create({
        duration: 1500,
        position: 'bottom',
      });
      loading.present();

      const formData = new FormData();
      const valores = this.formulario.getRawValue();
      formData.append('name', valores.name!);
      formData.append('email', valores.email!);
      formData.append('password', valores.password!);
      formData.append('password_confirmation', valores.password_confirmation!);
      formData.append('role', valores.role!);
      formData.append('pin', valores.pin!);
      formData.append('image', valores.image!);

      this.userService.add(formData).subscribe({
        next: (response: any) => {
          loading.remove();
          toast.message = 'Usuario creado';
          toast.color = 'success';
          toast.present();
          this.userCreated.emit();
          this.formulario.reset();
        },
        error(err) {
          loading.remove();
          toast.message = 'Ha habido un error.';
          toast.color = 'danger';
          toast.present();
        },
      });
    }
  }

  hasUppercase(control: AbstractControl) {
    const value = control.value;
    if (value && !/[A-Z]/.test(value)) {
      return { uppercase: true };
    }
    return null;
  }

  hasNumber(control: AbstractControl) {
    const value = control.value;
    if (value && !/\d/.test(value)) {
      return { number: true };
    }
    return null;
  }

  hasSpecialCharacter(control: AbstractControl) {
    const value = control.value;
    if (value && !/[!@#$%^&*(),.?":{}|<>]/.test(value)) {
      return { specialCharacter: true };
    }
    return null;
  }

  openFileDialog(): void {
    this.fileUpload.nativeElement.click();
  }

  setImage(event: Event): void {
    const input = event.target as HTMLInputElement;
    this.selectedFile = input.files?.[0] || null;

    if (this.selectedFile) {
      console.log(this.selectedFile);
      this.formulario.controls.image.setValue(this.selectedFile);
    }
  }
}
