import {
  Component,
  EventEmitter,
  inject,
  Input,
  OnInit,
  Output,
} from '@angular/core';
import { IUsers } from 'src/app/models/user';
import {
  IonCard,
  IonThumbnail,
  IonCardHeader,
  IonCardTitle,
  IonCardContent,
  ModalController,
} from '@ionic/angular/standalone';
import { ImageFormatter } from 'src/app/services/helper/image-formatter';
import { RoleFormatterPipe } from 'src/app/pipes/role-formatter-pipe';
import { GetUsers } from 'src/app/services/auth/get-users';
import { Router } from '@angular/router';

@Component({
  selector: 'app-user-selector',
  templateUrl: './user-selector.component.html',
  styleUrls: ['./user-selector.component.scss'],
  imports: [
    IonCard,
    IonThumbnail,
    IonCardHeader,
    IonCardTitle,
    IonCardContent,
    RoleFormatterPipe,
  ],
})
export class UserSelectorComponent implements OnInit {
  @Input() tableId!: string;
  @Output() userSelected = new EventEmitter<string>();
  private userService = inject(GetUsers);
  public imageService = inject(ImageFormatter);
  private modalCtrl = inject(ModalController);
  private router = inject(Router);

  users: IUsers = [];

  constructor() {}

  ngOnInit() {
    this.getUsers();
  }

  getUsers() {
    this.userService.getAll().subscribe({
      next: (response: IUsers) => {
        this.users = [...response];
      },
      error() {
        console.log('No hay usuarios, te jodes');
      },
    });
  }

  openPinModal(email: string) {
    this.userSelected.emit(email);
  }
}
