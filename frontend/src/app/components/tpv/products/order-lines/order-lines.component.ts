import { Component, inject, Input, OnInit } from '@angular/core';
import { IOrderLines } from 'src/app/models/order_line';
import { IProducts } from 'src/app/models/product';
import { OrderLineManagerService } from 'src/app/services/tpv/order-line-manager-service';
import {
  IonCardHeader,
  IonCard,
  IonCardTitle,
  IonCardSubtitle,
  IonCardContent,
  IonList,
  IonItem,
  IonLabel,
  IonButton,
  IonIcon,
  ModalController,
} from '@ionic/angular/standalone';
import { FindProductNamePipe } from 'src/app/pipes/helper/find-product-name-pipe';
import { OrderManagerService } from 'src/app/services/tpv/order-manager-service';
import { MoneyFormatterPipe } from 'src/app/pipes/money-formatter-pipe';
import { CurrencyPipe } from '@angular/common';
import { addIcons } from 'ionicons';
import { addOutline, removeOutline, trashOutline } from 'ionicons/icons';
import { IOrder } from 'src/app/models/order';
import { LocalStorageService } from 'src/app/services/storage/local-storage-service';
import { ITable } from 'src/app/models/table';
import { TableService } from 'src/app/services/HTTPRequests/table-service';
import { Router } from '@angular/router';
import { NumpadComponent } from '../../numpad/numpad.component';
import { IRestaurant } from 'src/app/models/restaurant';
import { TicketGeneratorService } from 'src/app/services/ticket/ticket-generator-service';
import { TicketComponent } from '../../ticket/ticket.component';
import { PaymentMethodComponent } from '../../payment-method/payment-method.component';
import { ISale } from 'src/app/models/sale';
import { SaleManagerService } from 'src/app/services/tpv/sale-manager-service';

@Component({
  selector: 'app-order-lines',
  templateUrl: './order-lines.component.html',
  styleUrls: ['./order-lines.component.scss'],
  imports: [
    IonCardHeader,
    IonCard,
    IonCardTitle,
    IonCardSubtitle,
    IonCardContent,
    IonList,
    IonItem,
    IonLabel,
    FindProductNamePipe,
    IonButton,
    MoneyFormatterPipe,
    CurrencyPipe,
    IonIcon,
  ],
})
export class OrderLinesComponent implements OnInit {
  public orderLineManager = inject(OrderLineManagerService);
  private orderManager = inject(OrderManagerService);
  private localService = inject(LocalStorageService);
  private tableService = inject(TableService);
  private router = inject(Router);
  private modalCtrl = inject(ModalController);
  private ticketService = inject(TicketGeneratorService);
  private saleManager = inject(SaleManagerService);

  restaurant: IRestaurant | null = null;
  order: IOrder | null = null;
  orderLines: IOrderLines = [];
  sale: ISale | null = null;
  @Input() products: IProducts = [];
  @Input() diners: number = 0;
  @Input() tableId: string = '';
  @Input() table: ITable | undefined = undefined;
  total: number = 0;
  tableName: string | undefined = '';
  ticket: string | undefined = undefined;

  constructor() {
    addIcons({ trashOutline, removeOutline, addOutline });
  }

  ngOnInit() {
    this.getOrder();
    if (this.order) {
      this.diners = this.order.diners;
    }
    this.orderLineManager.getLinesForTable(this.tableId).subscribe((lines) => {
      this.orderLines = lines;
      this.total = this.calculateTotal();
      this.tableName = this.table?.name;
    });

    this.restaurant = this.localService.getRestaurant();
  }

  calculateTotal(): number {
    return this.orderLines.reduce(
      (sum, line) => sum + line.price * line.quantity,
      0,
    );
  }

  getOrder() {
    this.order = this.localService.getOrderByTable(this.tableId);
  }

  getOrderLines() {
    this.orderLines = this.orderLineManager.getLines(this.tableId);
  }

  removeLine(index: number) {
    this.orderLineManager.removeOrderLine(this.tableId, index);
  }

  changeQuantity(amount: number, index: number) {
    this.orderLineManager.updateQuantity(this.tableId, index, amount);
  }

  confirmOrder() {
    const orderLines = this.orderLineManager.getLines(this.tableId);
    let orderExists = this.localService.getOrderId(this.tableId);
    if (orderExists) {
      this.orderLineManager
        .sendLinesToBackend(orderExists, orderLines)
        .subscribe({
          next: (response) => {
            console.log('Bien?');
            this.router.navigate(['/tpv/tables']);
          },
          error: (err) => {
            console.error('Mal :(');
          },
        });
    } else {
      const order: IOrder = {
        table_id: this.tableId,
        diners: this.diners,
        orderLines: orderLines,
      };

      this.orderManager.add(order).subscribe({
        next: (response: any) => {
          const newOrder: IOrder = {
            id: response.id,
            table_id: response.table_id,
            diners: response.diners,
          };
          this.localService.setOrderByTable(this.tableId, newOrder);
          this.tableService.updateOccupied(this.tableId, true);
          this.router.navigate(['/tpv/tables']);
        },
        error: (err) => {
          console.error('Error al crear pedido', err);
        },
      });
    }
  }

  async modificarComensales() {
    const modal = await this.modalCtrl.create({
      component: NumpadComponent,
      componentProps: {
        tableId: this.table,
      },
    });

    await modal.present();

    const { data } = await modal.onDidDismiss();
    if (data?.success) {
      if (this.order) {
        let updatedOrder: IOrder = {
          table_id: this.tableId,
          diners: data.diners,
        };
        this.localService.setOrderByTable(this.tableId, updatedOrder);
      }
      this.diners = data.diners;
    }
  }

  async imprimirTicket(tipo: string) {
    if (tipo === 'provisional') {
      this.ticket = this.ticketService.generarTicketProvisional(
        this.order!,
        this.orderLines,
        this.total,
        this.table?.name!,
      );
      const modal = await this.modalCtrl.create({
        component: TicketComponent,
        componentProps: { ticket: this.ticket },
      });
      await modal.present();
    } else {
      this.order!.orderLines = this.orderLines;
      this.sale = { order_id: this.order?.id, total: this.total };
      this.saleManager.add(this.sale).subscribe({
        next: (response: any) => {
          const newSale: ISale = {
            id: response.id,
            ticket_number: response.ticket_number,
            value_date: response.value_date,
            user_closes_name: response.user_closes_name,
          };
          const newTicket = this.ticketService.generarTicketDefinitivo(
            newSale,
            this.order!.orderLines!,
            this.total,
            this.tableName!,
          );
          this.orderLineManager.clear(this.tableId);
          this.localService.removeOrderByTable(this.tableId);
          this.tableService.updateOccupied(this.tableId, false);
          this.showTicket(newTicket);
        },
      });
      
    }
  }

  async showTicket(ticketNueo: string) {
    const modal = await this.modalCtrl.create({
        component: PaymentMethodComponent,
        componentProps: {
          ticket: ticketNueo
        },
      });
      await modal.present();
  }

  closeOrder() {
    this.localService.removeOrderByTable(this.tableId);
    this.localService.removeOrderLines(this.tableId);
    this.orderLineManager.clear(this.tableId);
    this.tableService.updateOccupied(this.tableId, false);
    this.router.navigate(['/tpv/tables']);
  }
}
