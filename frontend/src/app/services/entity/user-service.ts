import { Injectable } from '@angular/core';
import { ApiResponse, BaseApiService } from '../api/base-api.service';
import { BehaviorSubject, Observable, tap } from 'rxjs';
import { IUsers } from 'src/app/models/user';

@Injectable({
  providedIn: 'root',
})
export class UserService extends BaseApiService {
  private users$ = new BehaviorSubject<IUsers>([]);

  getAll(): Observable<IUsers> {
    if (this.users$.getValue().length === 0) {
      this.loadUsers();
    }

    return this.users$.asObservable();
  }

  private loadUsers(): void {
    this.httpCall('/users/restaurant', null, 'get').subscribe({
      next: (response: any) => {
        const users = response as unknown as IUsers;
        this.users$.next(users);
      },
    });
  }

  refreshUsers(): void {
    this.loadUsers();
  }

  add(formData: FormData): Observable<ApiResponse> {
    return this.httpCall('/users', formData, 'post').pipe(
      tap(() => this.refreshUsers()),
    );
  }

  delete(id: string): Observable<ApiResponse> {
    return this.httpCall(`/users/${id}`, null, 'delete').pipe(
      tap(() => this.refreshUsers()),
    );
  }

  update(id: string, formData: FormData): Observable<ApiResponse> {
    return this.httpCall(`/users/${id}`, formData, 'patch').pipe(
      tap(() => this.refreshUsers()),
    );
  }
}
