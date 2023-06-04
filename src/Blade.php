<?php
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Events\Dispatcher;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Factory;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\FileViewFinder;
use Illuminate\Support\Facades\Facade;
use Illuminate\Contracts\View\Factory as ViewFactoryContract;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade as BladeFacade;

class Blade {
    private $container;
    private $pathsToTemplates;
    private $pathToCompiledTemplates;
    private $filesystem;
    private $eventDispatcher;
    private $viewResolver;
    private $bladeCompiler;
    private $viewFinder;
    private $viewFactory;

    public function __construct() {
        $this->container = Container::getInstance();

        $this->pathsToTemplates = Config::get('pathsToTemplates');
        $this->pathToCompiledTemplates = Config::get('pathToCompiledTemplates');

        $this->filesystem = new Filesystem;
        $this->eventDispatcher = new Dispatcher($this->container);

        $this->viewResolver = new EngineResolver;
        $this->bladeCompiler = new BladeCompiler($this->filesystem, $this->pathToCompiledTemplates);

        $bladeCompiler = $this->bladeCompiler;

        $this->viewResolver->register('blade', function () use ($bladeCompiler) {
            return new CompilerEngine($this->bladeCompiler);
        });

        $this->viewFinder = new FileViewFinder($this->filesystem, $this->pathsToTemplates);
        $this->viewFactory = new Factory($this->viewResolver, $this->viewFinder, $this->eventDispatcher);
        $this->viewFactory->setContainer($this->container);
        Facade::setFacadeApplication($this->container);
        $this->container->instance(ViewFactoryContract::class, $this->viewFactory);
        $this->container->alias(ViewFactoryContract::class, 
            (new class extends View {
                public static function getFacadeAccessor() { return parent::getFacadeAccessor(); }
            })::getFacadeAccessor()
        );
        $this->container->instance(BladeCompiler::class, $this->bladeCompiler);
        $this->container->alias(BladeCompiler::class, 
            (new class extends BladeFacade {
                public static function getFacadeAccessor() { return parent::getFacadeAccessor(); }
            })::getFacadeAccessor()
        );
    }

    public function render($view, $data) {
        echo $this->viewFactory->make($view, $data)->render();
    }
}