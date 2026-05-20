# TPV en prácticas

 
> **Autor:** Laura Mora

> **Periodo de desarrollo:** Marzo - Junio 2026  

> **Actualizado a fecha de :** 20 de Mayo 2026  



En este repositorio podemos encontrar un TPV desarrollado de forma específica para la restauración. Está compuesto de dos zonas claramente diferenciadas:
* Panel de configuración: Gestión de los elementos necesarios para tener un TPV, incluyendo, pero no limitado a, gestión de usuarios, creación de productos y manejo de zonas y mesas.
* TPV: Creación de pedidos relacionados con su mesa, gestión del estado de estos y manejo de tickets.

Se ha desarrollado empleando las siguientes tecnologías:
*  Backend: Laravel 12
* Frontend: Angular 20 e Ionic 8


---

## Índice
- [Roadmap y alcances](#roadmap-y-alcances)
  - [Desglose por hitos](#desglose-por-hitos-completados)
- [Prerrequisitos](#prerrequisitos)
- [Cómo empezar](#cómo-empezar)
- [Estructura del proyecto](#estructura-del-proyecto)
  - [Backend (`backend/`)](#backend-backend)
  - [Frontend (`frontend/`)](#frontend-frontend)
  - [DbGate (cliente de base de datos)](#dbgate-cliente-de-base-de-datos)
- [Objetivos de aprendizaje](#objetivos-de-aprendizaje)
- [Buenas prácticas](#buenas-prácticas)
- [Estilo de código](#estilo-de-código)

---
## Roadmap y alcances
|  Hito | Estado  | Nombre  | Descripción  |
| :------------: | ------------ | ------------ | ------------ |
|  1 |  Completado | Modelo de datos  | Creación de migraciones y datos |
|  2 | Completado   |API REST Backoffice   | Endpoints para la gestión de datos  |
|  3 |  Completado | Interfaz: Backoffice  | Pantalla de gestión del TPV   |
|  4 |  En proceso | Front de venta  | Diseño de interfaz de venta y desarrollo de lógica  |
|  5 | Sin empezar (opcional)   | Informes  | Implementación de ceración y consulta de histórico  |
| 6  | En proceso (opcional)  |  Mejoras | Modificaciones de mejora a la aplicación  |

### Desglose por hitos completados
#### Hito 1 - Modelo de datos
* Creación de migraciones tanto de creación de tablas como de modificación de estas
* Populación de la base de datos implementando uso de factories y seeders
* Creación de modelos eloquent con sus respectivas relaciones y soft-deletes implementados

#### Hito 2 - API REST: Backoffice
* Autenticación de usuarios mediante implementación de API Token
* CRUD de entidades relevantes al backoffice
* Validaciones en las diferentes capas y errores relevantes

#### Hito 3 - Interfaz: Backoffice
* Diseño de pantallas sencillas pero funcionales
* Vistas para gestionar las entidades en un solo panel

#### Hito 6 - Mejoras
* Funcionales
 * Roles de usuario aplicados como *ability* mediante *middleware*
* Técnicas
 * Autenticación basada en tokens

## Prerrequisitos

Para seguir esta guía necesitas tener instalado en tu máquina:

- **Docker** (y Docker Compose), para levantar la API, el frontend, la base de datos y DbGate. Sin Docker no podrás ejecutar `make start` ni el resto de comandos que dependen de los contenedores.
- **Make** (GNU Make), para usar los objetivos del `Makefile` (`make start`, `make install`, `make db-migrate`, etc.).
- **Git**, para clonar el repositorio.



## Cómo empezar

1. **Clonar el repositorio:**

   ```bash
   git clone <repo-url>
   cd 2026-training-laravel-angular
   ```

2. **Configurar entorno backend (solo la primera vez):** copiar el archivo de ejemplo:

   ```bash
   cp backend/.env.example backend/.env
   ```

3. **Levantar los contenedores Docker:**

   ```bash
   make start
   ```

4. **Instalar dependencias backend, migrar la base de datos y generar clave de aplicación:**

   ```bash
   make install   # composer install + migraciones (requiere que los contenedores estén levantados: make start)
   docker compose run --rm api php artisan key:generate
   ```

   Si el contenedor `api` no quedó en marcha, vuelve a levantar: `make start`.

5. **Frontend (Angular):** El repositorio ya incluye el proyecto en `frontend/`. Con `make start` el contenedor levanta la app automáticamente. Para desarrollo en primer plano con live reload: `make serve-frontend`.

Tras seguir estos pasos tendrás:

- **API (Laravel):** [http://localhost:8000](http://localhost:8000)
- **Frontend (Angular):** [http://localhost:4200](http://localhost:4200)
- **DbGate (MySQL):** [http://localhost:9051](http://localhost:9051) (conexión **Training MySQL** preconfigurada)



## Estructura del proyecto

### Backend (`backend/`)

El backend sigue un enfoque **DDD + Hexagonal**, con cada dominio encapsulado bajo su propio namespace.  
El ejemplo que se muestra a continuación es para el dominio `User`.

```text
App/
└── User/
    ├── Domain/
    │   ├── Entity/
    │   ├── ValueObject/
    │   └── Interfaces/
    ├── Application/
    │   └── CreateUser.php
    └── Infrastructure/
        ├── Persistence/
        └── Entrypoint/Http/
```

| Carpeta | Descripción |
|---------|-------------|
| **Domain/** | Lógica de negocio pura, entidades y value objects. |
| **Interfaces/** | Contratos del dominio (por ejemplo `UserRepositoryInterface`). |
| **Application/** | Casos de uso y handlers. |
| **Infrastructure/** | Adaptadores que conectan el dominio con el mundo externo: persistencia, HTTP, colas. |
| **Entrypoint/Http/** | Controladores o endpoints HTTP. |

### Frontend (`frontend/`)

Proyecto **Angular + Ionic** (standalone components). Cliente que consume la API del backend.

```text
frontend/src/app/
├── components/        # Componentes reutilizables
├── pages/             # Páginas de la aplicación
│   └── core/          # Páginas principales
│       └── home/
├── pipes/             # Pipes personalizados
├── providers/         # Interceptores y providers
│   └── interceptor.ts
└── services/          # Servicios (llamadas a la API, lógica compartida)
```

El interceptor HTTP (`providers/interceptor.ts`) prefija automáticamente la URL base de la API y añade los headers por defecto (`Accept`, `Accept-Language`).

### DbGate (cliente de base de datos)

Interfaz web para explorar y consultar la base MySQL. La conexión **Training MySQL** queda preconfigurada y apunta a la base `training` del servicio `db`.



## Objetivos de aprendizaje

- Comprender y aplicar **DDD**: separar Domain, Application e Infrastructure.
- Aprender a usar **repositorios e interfaces** para desacoplar dominio de la persistencia.
- Practicar la implementación de **casos de uso y handlers**.
- Exponer la lógica de negocio a través de **HTTP entrypoints** y mantener el dominio independiente del framework.
- Familiarizarse con **Docker**, **Composer** y **Node** en un flujo de desarrollo profesional.



## Buenas prácticas

- Programar contra **interfaces**, no implementaciones concretas.
- Evitar lógica de negocio en Controllers o Eloquent Models.
- Mantener los dominios **autocontenidos**, siguiendo la convención: `App/<Dominio>/{Domain, Application, Infrastructure}`.
- Escribir **tests** que dependan de la interfaz del dominio, no de la implementación concreta.



## Estilo de código

Para mantener un código consistente entre todos los colaboradores (humanos y IAs), se siguen estas pautas:

- **Backend (PHP):** PSR-12 y las recomendaciones de [Symfony Coding Standards](https://symfony.com/doc/current/contributing/code/standards.html).
- **Frontend (Angular):** [Angular Style Guide](https://angular.dev/style-guide).
- **Convenciones básicas**:
  - Una **clase por archivo**.
  - `camelCase` para variables y métodos, `PascalCase` para clases, `SCREAMING_SNAKE_CASE` para constantes.
  - Propiedades antes de los métodos; métodos públicos antes que protegidos y privados.
  - Imports (`use`) para todas las clases que no estén en el espacio de nombres actual.
- **Estructura y formato**:
  - Siempre usar paréntesis al instanciar clases (`new Foo()`).
  - En arrays multilínea, dejar **coma final** en cada elemento.
  - Añadir una línea en blanco antes de un `return` cuando mejore la legibilidad.
  - Evitar lógica compleja en una sola línea; preferir bloques claros con llaves siempre presentes.

Antes de subir cambios, se recomienda:

```bash
make test   # tests del backend (PHPUnit)
make lint   # formatear código PHP (Laravel Pint)
```
