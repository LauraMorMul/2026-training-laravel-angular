import { inject, Injectable } from '@angular/core';
import { IOrder } from 'src/app/models/order';
import { IOrderLines } from 'src/app/models/order_line';
import { IRestaurant } from 'src/app/models/restaurant';
import { LocalStorageService } from '../storage/local-storage-service';
import { ISale } from 'src/app/models/sale';

@Injectable({
  providedIn: 'root',
})
export class TicketGeneratorService {
  private localService = inject(LocalStorageService);
  private readonly ancho = 48;
  private restaurant: IRestaurant | null = null;
  private nTicket: string = 'Pendiente';

  private wrapText(texto: string, maxLength: number): string[] {
    const words = texto.split(' ');
    const lines: string[] = [];
    let currentLine = '';

    for (const word of words) {
      if ((currentLine + word).length > maxLength) {
        lines.push(currentLine.trim());
        currentLine = word + ' ';
      } else {
        currentLine += word + ' ';
      }
    }
    lines.push(currentLine.trim());
    return lines;
  }

  generarTicketProvisional(
    order: IOrder,
    lines: IOrderLines,
    total: number,
    tableName: string,
  ): string {
    this.restaurant = this.localService.getRestaurant();
    const iva = lines[0]?.percentage ?? 10;
    const base = total / (1 + iva / 100);
    const cuotaIva = total - base;
    const lineas: string[] = [
      '-'.repeat(this.ancho),
      this.centrar(this.restaurant!.name),
      this.centrar(`CIF: ${this.restaurant!.tax_id}`),
      '-'.repeat(this.ancho),
      `Nº Op.: ${this.nTicket}`,
      '-'.repeat(this.ancho),
      `Mesa: ${tableName}`,
      `Comensales: ${order.diners}`,
      `Fecha: ${new Date().toLocaleString()}`,
      '-'.repeat(this.ancho),
      this.padRight('Producto', 20) +
        this.padRight('Cant', 10) +
        this.padRight('Precio', 18),
      '-'.repeat(this.ancho),
    ];

    for (const line of lines) {
      const nombreLines = this.wrapText(
        line.product_name || line.product_id,
        20,
      );

      for (let i = 0; i < nombreLines.length; i++) {
        if (i === 0) {
          lineas.push(
            this.padRight(nombreLines[i], 20) +
              this.padRight(line.quantity.toString(), 10) +
              this.padRight(
                ((line.price * line.quantity) / 100).toFixed(2) + '€',
                18,
              ),
          );
        } else {
          lineas.push(
            this.padRight(nombreLines[i], 20) +
              this.padRight('', 10) +
              this.padRight('', 18),
          );
        }
      }
    }

    lineas.push(
      '-'.repeat(this.ancho),
      this.padRight(`Base ${iva}%:`, 30) +
        this.padRight((base / 100).toFixed(2) + '€', 18),
      this.padRight(`IVA (${iva}%):`, 30) +
        this.padRight((cuotaIva / 100).toFixed(2) + '€', 18),
      '-'.repeat(this.ancho),
      this.padRight('TOTAL:', 30) +
        this.padRight((total / 100).toFixed(2) + '€', 18),
      '-'.repeat(this.ancho),
      '',
      this.centrar('Le atendió:'),
      this.centrar('-----'),
      '-'.repeat(this.ancho),
    );

    return lineas.join('\n');
  }

  generarTicketDefinitivo(
    sale: ISale,
    lines: IOrderLines,
    total: number,
    tableName: string,
  ): string {
    this.restaurant = this.localService.getRestaurant();
    const iva = lines[0]?.percentage ?? 10;
    const base = total / (1 + iva / 100);
    const cuotaIva = total - base;
    const lineas: string[] = [
      '-'.repeat(this.ancho),
      this.centrar(this.restaurant!.name),
      this.centrar(`CIF: ${this.restaurant!.tax_id}`),
      '-'.repeat(this.ancho),
      `Nº Op.: ${sale.ticket_number}`,
      '-'.repeat(this.ancho),
      `Mesa: ${tableName}`,
      `Fecha: ${new Date().toLocaleString()}`,
      '-'.repeat(this.ancho),
      this.padRight('Producto', 20) +
        this.padRight('Cant', 10) +
        this.padRight('Precio', 18),
      '-'.repeat(this.ancho),
    ];

    for (const line of lines) {
      const nombreLines = this.wrapText(
        line.product_name || line.product_id,
        20,
      );

      for (let i = 0; i < nombreLines.length; i++) {
        if (i === 0) {
          lineas.push(
            this.padRight(nombreLines[i], 20) +
              this.padRight(line.quantity.toString(), 10) +
              this.padRight(
                ((line.price * line.quantity) / 100).toFixed(2) + '€',
                18,
              ),
          );
        } else {
          lineas.push(
            this.padRight(nombreLines[i], 20) +
              this.padRight('', 10) +
              this.padRight('', 18),
          );
        }
      }
    }

    lineas.push(
      '-'.repeat(this.ancho),
      this.padRight(`Base ${iva}%:`, 30) +
        this.padRight((base / 100).toFixed(2) + '€', 18),
      this.padRight(`IVA (${iva}%):`, 30) +
        this.padRight((cuotaIva / 100).toFixed(2) + '€', 18),
      '-'.repeat(this.ancho),
      this.padRight('TOTAL:', 30) +
        this.padRight((total / 100).toFixed(2) + '€', 18),
      '-'.repeat(this.ancho),
      '',
      this.centrar('Le atendió:'),
      this.centrar('-----'),
      '-'.repeat(this.ancho),
    );

    return lineas.join('\n');
  }

  private centrar(texto: string): string {
    const espacios = (this.ancho - texto.length) / 2;
    const izquierda = Math.floor(espacios);
    const derecha = Math.ceil(espacios);
    return " ".repeat(Math.max(0, izquierda)) + texto + " ".repeat(Math.max(0, derecha));
}

  private padRight(texto: string, longitud: number): string {
    return texto.padEnd(longitud, ' ');
  }
}
