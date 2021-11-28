<?php

declare(strict_types=1);

namespace Enraged\Infrastructure\Framework;

use function dirname;
use Enraged\Infrastructure\Assertion\InfrastructureAssertion;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    private const CONFIG_RELATIVE_PATH = '../../../../config/';

    protected function configureContainer(ContainerConfigurator $container) : void
    {
        InfrastructureAssertion::notEmpty($this->environment);
        $container->import(self::CONFIG_RELATIVE_PATH . '{packages}/*.yaml');
        $container->import(self::CONFIG_RELATIVE_PATH . '{packages}/' . $this->environment . '/*.yaml');

        if (is_file(dirname(__DIR__, 4) . '/config/services.yaml')) {
            $container->import(self::CONFIG_RELATIVE_PATH . 'services.yaml');
            $container->import(self::CONFIG_RELATIVE_PATH . '{services}_' . $this->environment . '.yaml');
        } elseif (is_file($path = dirname(__DIR__, 4) . '/config/services.php')) {
            (require $path)($container->withPath($path), $this);
        }
    }

    protected function configureRoutes(RoutingConfigurator $routes) : void
    {
        InfrastructureAssertion::notEmpty($this->environment);
        $routes->import(self::CONFIG_RELATIVE_PATH . '{routes}/' . $this->environment . '/*.yaml');
        $routes->import(self::CONFIG_RELATIVE_PATH . '{routes}/*.yaml');

        if (is_file(dirname(__DIR__, 4) . '/config/routes.yaml')) {
            $routes->import(self::CONFIG_RELATIVE_PATH . 'routes.yaml');
        } elseif (is_file($path = dirname(__DIR__, 4) . '/config/routes.php')) {
            (require $path)($routes->withPath($path), $this);
        }
    }
}
