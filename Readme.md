# WP Laravel Boilerplate

Un boilerplate moderno y escalable para desarrollo de plugins de WordPress usando componentes de Laravel.

## Características

- 🏗️ **Arquitectura MVC** - Separación clara de responsabilidades
- 🗃️ **Eloquent ORM** - Manejo elegante de base de datos
- 🎨 **Blade Templates** - Sistema de plantillas potente
- 📦 **Custom Post Types** - Sistema modular para CPTs
- 🔌 **Hooks & Filters** - Gestión centralizada
- 🌐 **REST API** - Endpoints RESTful completos
- 💾 **Cache System** - Sistema de caché integrado
- 📨 **Queue System** - Procesamiento de tareas en background
- 🔒 **Middleware** - Sistema de middleware para seguridad
- ✅ **Validation** - Validación de datos integrada
- 🧪 **Testing** - Estructura para pruebas unitarias

## Requisitos

- PHP >= 7.4
- WordPress >= 5.8
- Composer

## Instalación

1. Clona este repositorio en tu carpeta de plugins:
```bash
cd wp-content/plugins
git clone https://github.com/tu-usuario/wp-laravel-boilerplate.git
```

2. Instala las dependencias:
```bash
cd wp-laravel-boilerplate
composer install
```

3. Activa el plugin desde el panel de WordPress

## Estructura del Proyecto

```
wp-laravel-boilerplate/
├── assets/                 # Archivos CSS y JS
├── resources/             # Vistas Blade
├── src/                   # Código fuente PHP
│   ├── Api/              # Controladores REST API
│   ├── Controllers/      # Controladores MVC
│   ├── Core/            # Núcleo del plugin
│   ├── Database/        # Migraciones
│   ├── Events/          # Eventos
│   ├── Hooks/           # WordPress hooks
│   ├── Http/            # Routing
│   ├── Middleware/      # Middleware
│   ├── Models/          # Modelos Eloquent
│   ├── PostTypes/       # Custom Post Types
│   ├── Queue/           # Jobs para background
│   ├── Services/        # Servicios
│   └── Traits/          # Traits reutilizables
├── storage/              # Cache y archivos temporales
├── tests/                # Pruebas unitarias
└── vendor/               # Dependencias Composer
```

## Uso

### Crear un nuevo modelo

```php
namespace WPLaravel\Models;

class Product extends BaseModel
{
    protected $table = 'products';
    protected $fillable = ['name', 'price', 'description'];
}
```

### Crear un nuevo controlador

```php
namespace WPLaravel\Controllers;

class ProductController extends BaseController
{
    public function index()
    {
        $products = Product::all();
        return $this->view('products.index', compact('products'));
    }
}
```

### Registrar una nueva ruta

```php
// En src/Http/Router.php
register_rest_route('wp-laravel/v1', '/products', [
    'methods' => 'GET',
    'callback' => [new ProductController(), 'index'],
]);
```

### Usar el sistema de caché

```php
$cache = new CacheManager();

// Guardar en caché
$cache->set('products', $products, 3600);

// Obtener de caché
$products = $cache->get('products');

// Remember pattern
$products = $cache->remember('products', function() {
    return Product::all();
}, 3600);
```

### Validación de datos

```php
$validator = new ValidationService();

$valid = $validator->validate($data, [
    'title' => 'required|min:3|max:255',
    'email' => 'required|email',
]);

if (!$valid) {
    $errors = $validator->getErrors();
}
```

## Contribuir

Las contribuciones son bienvenidas. Por favor:

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## Licencia

Este proyecto está bajo la licencia MIT. Ver el archivo `LICENSE` para más detalles.

## Estructura de carpetas

wp-laravel-boilerplate/
├── assets/
│   ├── css/
│   │   ├── admin.css
│   │   └── frontend.css
│   └── js/
│       ├── admin.js
│       └── frontend.js
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       └── examples/
│           ├── index.blade.php
│           └── show.blade.php
├── src/
│   ├── Api/
│   │   └── ExampleApiController.php
│   ├── Cache/
│   │   └── CacheManager.php
│   ├── Controllers/
│   │   ├── BaseController.php
│   │   └── ExampleController.php
│   ├── Core/
│   │   └── Plugin.php
│   ├── Database/
│   │   └── CreatePluginTables.php
│   ├── Events/
│   │   ├── EventManager.php
│   │   └── ExampleCreated.php
│   ├── Helpers/
│   │   └── helpers.php
│   ├── Hooks/
│   │   ├── HookManager.php
│   │   └── ExampleHook.php
│   ├── Http/
│   │   └── Router.php
│   ├── Listeners/
│   │   └── SendExampleNotification.php
│   ├── Middleware/
│   │   ├── AuthMiddleware.php
│   │   ├── MiddlewareInterface.php
│   │   └── NonceMiddleware.php
│   ├── Models/
│   │   ├── BaseModel.php
│   │   └── Example.php
│   ├── PostTypes/
│   │   ├── PostTypeManager.php
│   │   └── ExamplePostType.php
│   ├── Queue/
│   │   ├── Jobs/
│   │   │   └── ExampleJob.php
│   │   └── QueueManager.php
│   ├── Services/
│   │   ├── ServiceProvider.php
│   │   └── ValidationService.php
│   └── Traits/
│       ├── HasMeta.php
│       └── Singleton.php
├── storage/
│   └── views/
├── tests/
│   ├── TestCase.php
│   └── Unit/
│       └── ExampleModelTest.php
├── vendor/
├── .gitignore
├── composer.json
├── phpunit.xml
├── README.md
└── wp-laravel-boilerplate.php