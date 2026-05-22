import { Injectable } from '@angular/core';
import { ApiResponse, BaseApiService } from '../../api/base-api.service';
import { BehaviorSubject, Observable } from 'rxjs';
import { ITables } from 'src/app/models/table';

@Injectable({
  providedIn: 'root',
})
export class TableService extends BaseApiService {
  private tables$ = new BehaviorSubject<ITables>([]);

  getAll(): Observable<ITables> {
    if (this.tables$.getValue().length === 0) {
      this.loadTables();
    }

    return this.tables$.asObservable();
  }

  private loadTables(): void {
    this.httpCall('/tables/restaurant', null, 'get').subscribe({
      next: (response: ApiResponse) => {
        const tables = response as unknown as ITables;
        this.tables$.next(tables);
      },
    });
  }
}
