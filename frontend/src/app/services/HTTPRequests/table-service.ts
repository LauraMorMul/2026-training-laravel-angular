import { inject, Injectable } from '@angular/core';
import { ApiResponse, BaseApiService } from '../api/base-api.service';
import { ITables } from 'src/app/models/table';
import { BehaviorSubject, Observable, tap } from 'rxjs';
import { LocalStorageService } from '../storage/local-storage-service';

@Injectable({
  providedIn: 'root',
})
export class TableService extends BaseApiService {
  private tables$ = new BehaviorSubject<ITables>([]);
  private localService = inject(LocalStorageService);

  getAll(): Observable<ITables> {
    if (this.tables$.getValue().length === 0) {
      this.loadTables();
    }

    return this.tables$.asObservable();
  }

  private loadTables(): void {
    if (this.localService.isThereUserToken()) {
      console.log('hay user token?', this.localService.isThereUserToken());
      this.httpCall('/tables/user', null, 'get').subscribe({
        next: (response: ApiResponse) => {
          const tables = response as unknown as ITables;
          const tablesWithOccupied = tables.map((table) => ({
            ...table,
            __occupied: this.localService.getOrderByTable(table.id) !== null,
          }));
          this.tables$.next(tablesWithOccupied);
        },
      });
    } else {
      this.httpCall('/tables/restaurant', null, 'get').subscribe({
        next: (response: ApiResponse) => {
          const tables = response as unknown as ITables;
          const tablesWithOccupied = tables.map((table) => ({
            ...table,
            __occupied: this.localService.getOrderByTable(table.id) !== null,
          }));
          this.tables$.next(tablesWithOccupied);
        },
      });
    }
  }

  updateOccupied(tableId: string, occupied: boolean): void {
    const current = this.tables$.getValue();
    console.log('antes:', current);
    const updated = current.map((table) =>
      table.id === tableId ? { ...table, __occupied: occupied } : table,
    );
    console.log('después:', updated);
    this.tables$.next(updated);
  }

  refreshTables(): void {
    this.loadTables();
  }

  add(formData: FormData): Observable<ApiResponse> {
    return this.httpCall('/tables', formData, 'post').pipe(
      tap(() => this.refreshTables()),
    );
  }

  delete(id: string): Observable<ApiResponse> {
    return this.httpCall(`/tables/${id}`, null, 'delete').pipe(
      tap(() => this.refreshTables()),
    );
  }

  update(id: string, formData: FormData): Observable<ApiResponse> {
    return this.httpCall(`/tables/${id}`, formData, 'patch').pipe(
      tap(() => this.refreshTables()),
    );
  }

  getTableName(tableId: string): string {
    const tables = this.tables$.getValue();
    return tables.find((t) => t.id === tableId)?.name || '';
  }
}
