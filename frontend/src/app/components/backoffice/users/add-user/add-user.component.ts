import { Component, EventEmitter, inject, Output } from '@angular/core';
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
} from '@ionic/angular/standalone';
import { UserService } from 'src/app/services/entity/user-service';

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
  ],
})
export class AddUserComponent {

  @Output() userCreated = new EventEmitter<void>();

  private userService = inject(UserService);
  private loadingController = inject(LoadingController);
  private toastController = inject(ToastController);

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
      image_src: new FormControl('', Validators.required),
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
        position: 'bottom'
      });
      loading.present();
      console.log('enviado');
      this.userService
        .add(
          this.formulario.value.name!,
          this.formulario.value.email!,
          this.formulario.value.password!,
          this.formulario.value.password_confirmation!,
          this.formulario.value.role!,
          this.formulario.value.image_src!,
          this.formulario.value.pin!,
        )
        .subscribe({
          next: (response: any) => {
            loading.remove();
            toast.message = 'Usuario creado';
            toast.color = 'success'
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
}
