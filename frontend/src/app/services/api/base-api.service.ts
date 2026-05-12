import { environment } from '../../../environments/environment';
import { Injectable, inject } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { catchError, Observable, throwError } from 'rxjs';

export type HttpMethod = 'get' | 'post' | 'patch' | 'put' | 'delete';

@Injectable({
  providedIn: 'root',
})
export abstract class BaseApiService {
  protected apiUrl: string = environment.apiUrl;

  public http: HttpClient = inject(HttpClient);

  /**
   * Hacer una llamada http
   *
   */
  public httpCall(
    endpoint: string,
    params: any = null,
    method: HttpMethod,
  ): Observable<ApiResponse> {
    return this.makeHttpCall(endpoint, params, method);
  }

  /**
   * Ejecuta una petición HTTP
   *
   */
  makeHttpCall(
    endpoint: string,
    params: any = null,
    method: HttpMethod,
  ): Observable<ApiResponse> {
    switch (method) {
      case 'get':
        return this.getHttpCall(endpoint, params);

      case 'post':
        return this.postHttpCall(endpoint, params);

      case 'patch':
        return this.patchHttpCall(endpoint, params);

      case 'put':
        return this.putHttpCall(endpoint, params);

      case 'delete':
        return this.deleteHttpCall(endpoint, params);

      default:
        console.warn(`Unknown HTTP method received: ${method}`);
        break;
    }

    return this.getHttpCall(endpoint, params); // Use GET request as a default callback
  }

  /**
   * Llamada http tipo 'post'
   *
   */
  private postHttpCall(endpoint: string, params: any): Observable<ApiResponse> {
    let options = {};

    if (params instanceof FormData) {
      options = {};
    } else {
      options = {
        headers: { 'Content-Type': 'application/json' },
      };
      params = JSON.stringify(params);
    }
    return this.http
      .post<ApiResponse>(this.apiUrl + endpoint, params, options)
      .pipe(catchError((error) => this.handleError(error)));
  }

  /**
   * Llamada http tipo 'put'
   *
   */
  private putHttpCall(endpoint: string, params: any): Observable<ApiResponse> {
    let options = {};

    if (params instanceof FormData) {
      options = {};
    } else {
      options = {
        headers: { 'Content-Type': 'application/json' },
      };
      params = JSON.stringify(params);
    }
    return this.http
      .put<ApiResponse>(this.apiUrl + endpoint, params, options)
      .pipe(catchError((error) => this.handleError(error)));
  }

  /**
   * Llamada http tipo 'patch'
   *
   */
  private patchHttpCall(
    endpoint: string,
    params?: any,
  ): Observable<ApiResponse> {
    if (params instanceof FormData) {
      params.append('_method', 'PATCH');

      return this.http
        .post<ApiResponse>(this.apiUrl + endpoint, params)
        .pipe(catchError((error) => this.handleError(error)));
    }

    let options = {};

    options = {
      headers: { 'Content-Type': 'application/json' },
    };
    params = JSON.stringify(params);

    return this.http
      .patch<ApiResponse>(this.apiUrl + endpoint, params, options)
      .pipe(catchError((error) => this.handleError(error)));
  }

  /**
   * Llamada http tipo 'delete'
   *
   */
  private deleteHttpCall(
    endpoint: string,
    params?: any,
  ): Observable<ApiResponse> {
    return this.http
      .delete<ApiResponse>(this.apiUrl + endpoint, { params })
      .pipe(catchError((error) => this.handleError(error)));
  }

  /**
   * Llamada http tipo 'get'
   *
   */
  private getHttpCall(endpoint: string, params?: any): Observable<ApiResponse> {
    return this.http
      .get<ApiResponse>(this.apiUrl + endpoint, { params })
      .pipe(catchError((error) => this.handleError(error)));
  }

  /**
   * Manejar errores HTTP
   * Comentado por sustitución
   */
  /* private handleError(error: HttpErrorResponse): Observable<never> {
    return throwError(() => new Error(error.message));
  } */

  private handleError(error: HttpErrorResponse): Observable<never> {
    const customError = new Error(error.message);
    (customError as any).status = error.status;
    return throwError(() => customError);
}
}

export interface ApiResponse {
  data: any;
  status: number;
  message: string;
}
