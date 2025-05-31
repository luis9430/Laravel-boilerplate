<?php
namespace WPLaravel\Core;

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Factory;
use Illuminate\View\FileViewFinder;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Engines\PhpEngine;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Compilers\BladeCompiler;
use WPLaravel\Http\Router;
use WPLaravel\PostTypes\PostTypeManager;
use WPLaravel\Hooks\HookManager;
use WPLaravel\Cli\WorkflowCommands; 

class Plugin
{
    private static $instance = null;
    private $container;
    private $capsule;
    
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct()
    {
        $this->container = new Container();
        Container::setInstance($this->container);
    }
    
    public function init()
    {
        $this->setupDatabase();
        $this->setupViews();
        $this->registerServices();
        $this->registerHooks();
        $this->registerPostTypes();
        $this->registerRoutes();
        $this->registerCliCommands(); 

    }
    
    private function setupDatabase()
    {
        global $wpdb;
        
        $this->capsule = new Capsule();
        
        // Detectar el charset y collation correctos de WordPress
        $charset = $wpdb->charset ?: 'utf8';
        $collate = $wpdb->collate ?: '';
        
        // Si WordPress usa utf8mb3, usar utf8_general_ci como collation
        if ($charset === 'utf8mb3' || $charset === 'utf8') {
            $charset = 'utf8';
            $collate = 'utf8_general_ci';
        } elseif ($charset === 'utf8mb4') {
            $collate = 'utf8mb4_unicode_ci';
        }
        
        // Si no hay collation definido, usar el predeterminado para el charset
        if (empty($collate)) {
            $collate = $charset === 'utf8' ? 'utf8_general_ci' : 'utf8mb4_unicode_ci';
        }
        
        $this->capsule->addConnection([
            'driver' => 'mysql',
            'host' => DB_HOST,
            'database' => DB_NAME,
            'username' => DB_USER,
            'password' => DB_PASSWORD,
            'charset' => $charset,
            'collation' => $collate,
            'prefix' => $wpdb->prefix,
            'strict' => false,
            'engine' => null,
            'options' => [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => true,
            ],
        ]);
        
        $this->capsule->setEventDispatcher(new Dispatcher($this->container));
        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();
    }
    
    private function setupViews()
    {
        $this->container->bind('view.engine.resolver', function ($app) {
            $resolver = new EngineResolver();
            
            $resolver->register('php', function () {
                return new PhpEngine();
            });
            
            $resolver->register('blade', function () use ($app) {
                return new CompilerEngine(
                    new BladeCompiler(
                        $app['files'],
                        WP_LARAVEL_PLUGIN_PATH . 'storage/views'
                    )
                );
            });
            
            return $resolver;
        });
        
        $this->container->bind('view.finder', function ($app) {
            return new FileViewFinder(
                $app['files'],
                [WP_LARAVEL_PLUGIN_PATH . 'resources/views']
            );
        });
        
        $this->container->bind('files', function () {
            return new Filesystem();
        });
        
        $this->container->bind('view', function ($app) {
            $factory = new Factory(
                $app['view.engine.resolver'],
                $app['view.finder'],
                new Dispatcher()
            );
            
            $factory->setContainer($app);
            
            return $factory;
        });
    }
    
    private function registerServices()
    {
        $this->container->singleton(Router::class, function() {
            return new Router();
        });
        
        $this->container->singleton(PostTypeManager::class, function() {
            return new PostTypeManager();
        });
        
        $this->container->singleton(HookManager::class, function() {
            return new HookManager();
        });
    }
    
    private function registerHooks()
    {
        $hookManager = $this->container->make(HookManager::class);
        $hookManager->register();
    }
    
    private function registerPostTypes()
    {
        $postTypeManager = $this->container->make(PostTypeManager::class);
        $postTypeManager->register();
    }
    
    private function registerRoutes()
    {
        $router = $this->container->make(Router::class);
        $router->register();
    }
    
        public static function activate()
    {
        // Crear tabla de ejemplos (existente)
        $exampleMigration = new \WPLaravel\Database\CreatePluginTables();
        $exampleMigration->up(); // Crea la tabla de ejemplos

        // Crear tablas del sistema de workflow (NUEVO)
        $workflowMigration = new \WPLaravel\Database\CreateWorkflowSystemTables();
        $workflowMigration->up(); // Crea las tablas de workflow

        flush_rewrite_rules();
    }

    
    public static function deactivate()
    {
        flush_rewrite_rules();
    }
    
    public function getContainer()
    {
        return $this->container;
    }

private function registerCliCommands()
    {
        if (defined('WP_CLI') && WP_CLI) {
            // Si WorkflowCommands::class se usa aquí sin un 'use' o '\' al inicio,
            // PHP intentará resolverlo como WPLaravel\Core\WorkflowCommands
            \WP_CLI::add_command('wplaravel workflow', WorkflowCommands::class);
        }
    }


}