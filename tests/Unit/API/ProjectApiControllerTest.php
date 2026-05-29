<?php

declare(strict_types=1);

namespace Ksfraser\Tests\Unit\PMUI\API;

use Ksfraser\PMUI\API\ProjectApiController;
use KsfSuperglobals\Response;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class ProjectApiControllerTest extends TestCase
{
    public function testControllerCanBeInstantiated(): void
    {
        $container = $this->createMockContainerWithServices();
        
        $controller = new ProjectApiController($container, '/api/projects');
        
        $this->assertInstanceOf(ProjectApiController::class, $controller);
    }

    public function testControllerHasRequiredMethods(): void
    {
        $container = $this->createMockContainerWithServices();
        $controller = new ProjectApiController($container);

        $this->assertTrue(method_exists($controller, 'handle'));
        $this->assertTrue(method_exists($controller, 'index'));
        $this->assertTrue(method_exists($controller, 'show'));
        $this->assertTrue(method_exists($controller, 'create'));
        $this->assertTrue(method_exists($controller, 'update'));
        $this->assertTrue(method_exists($controller, 'delete'));
    }

    public function testDefaultBasePathIsProjectsEndpoint(): void
    {
        $container = $this->createMockContainerWithServices();
        $controller = new ProjectApiController($container);

        $reflection = new \ReflectionClass($controller);
        $property = $reflection->getProperty('basePath');
        $property->setAccessible(true);

        $this->assertEquals('/api/projects', $property->getValue($controller));
    }

    public function testCustomBasePathCanBeSet(): void
    {
        $container = $this->createMockContainerWithServices();
        $controller = new ProjectApiController($container, '/api/custom/path');

        $reflection = new \ReflectionClass($controller);
        $property = $reflection->getProperty('basePath');
        $property->setAccessible(true);

        $this->assertEquals('/api/custom/path', $property->getValue($controller));
    }

    public function testProjectServiceIsInjected(): void
    {
        $container = $this->createMockContainerWithServices();
        $controller = new ProjectApiController($container);

        $reflection = new \ReflectionClass($controller);
        $property = $reflection->getProperty('projectService');
        $property->setAccessible(true);

        $this->assertNotNull($property->getValue($controller));
    }

    public function testResponseIsInjected(): void
    {
        $container = $this->createMockContainerWithServices();
        $controller = new ProjectApiController($container);

        $reflection = new \ReflectionClass($controller);
        $property = $reflection->getProperty('response');
        $property->setAccessible(true);

        $this->assertNotNull($property->getValue($controller));
    }

    private function createMockContainerWithServices(): ContainerInterface
    {
        $projectService = $this->createMock(\Ksfraser\ProjectManagement\Contract\ProjectServiceInterface::class);
        $projectService->method('getAllProjects')->willReturn([]);
        $projectService->method('getProject')->willReturn(null);
        $projectService->method('getProjectsByStatus')->willReturn([]);
        $projectService->method('getProjectCount')->willReturn(0);
        $projectService->method('getProjectCountByStatus')->willReturn(0);
        $projectService->method('getPendingTaskCount')->willReturn(0);
        $projectService->method('getOverdueTaskCount')->willReturn(0);
        $projectService->method('getRecentProjects')->willReturn([]);
        $projectService->method('getOverdueTasks')->willReturn([]);

        $response = $this->createMock(Response::class);

        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')
            ->willReturnCallback(function (string $id) use ($projectService, $response) {
                if ($id === \Ksfraser\ProjectManagement\Contract\ProjectServiceInterface::class) {
                    return $projectService;
                }
                if ($id === Response::class) {
                    return $response;
                }
                return null;
            });
        $container->method('has')->willReturn(true);

        return $container;
    }
}
