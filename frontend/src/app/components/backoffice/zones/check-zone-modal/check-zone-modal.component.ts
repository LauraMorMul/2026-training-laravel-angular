import { Component, Input, OnInit, inject } from '@angular/core';
import { IonContent, IonHeader, IonToolbar, IonTitle, IonButton, ModalController, IonButtons, IonListHeader, IonList, IonLabel, IonItem } from '@ionic/angular/standalone';
import { ITables } from 'src/app/models/table';
import { FilterByZonePipe } from 'src/app/pipes/table/filter-by-zone-pipe';
import { TableService } from 'src/app/services/HTTPRequests/table-service';

@Component({
  selector: 'app-check-zone-modal',
  templateUrl: './check-zone-modal.component.html',
  styleUrls: ['./check-zone-modal.component.scss'],
  standalone: true,
  imports: [IonContent, IonHeader, IonToolbar, IonTitle, IonButton, IonButtons, IonListHeader, IonList, IonLabel, IonItem, FilterByZonePipe],
})
export class CheckZoneModalComponent implements OnInit{
  @Input() zone!: any;
  tables: ITables = [];

  private modalController = inject(ModalController);
  private tableService = inject(TableService);

  ngOnInit() {
    this.getTables();
  }

  getTables() {
    this.tableService.getAll().subscribe({
      next: (response: ITables) => {
        this.tables = [...response];
      },
      error(err) {
        console.log('Error fetching tables', err);
      },
    });
  }

  closeModal() {
    this.modalController.dismiss();
  }
}
