import { Component, inject, Input } from '@angular/core';
import { IonContent, ModalController } from '@ionic/angular/standalone';
import { UserSelectorComponent } from '../user-selector/user-selector.component';
import { PinPadUserComponent } from 'src/app/components/login/pin-pad-user/pin-pad-user.component';

@Component({
  selector: 'app-login-modal',
  templateUrl: './login-modal.component.html',
  styleUrls: ['./login-modal.component.scss'],
  imports: [IonContent, UserSelectorComponent, PinPadUserComponent],
})
export class LoginModalComponent {
  @Input() tableId!: string;
  private modalCtrl = inject(ModalController);
  state: 'user-selector' | 'pinpad' = 'user-selector';
  selectedUserEmail: string = '';

  selectUser(email: string) {
    this.selectedUserEmail = email;
    this.state = 'pinpad';
  }

  onPinSuccess(role: string) {
    this.modalCtrl.dismiss({ success: true, role, tableId: this.tableId });
  }

  goBack() {
    this.state = 'user-selector';
  }
}
