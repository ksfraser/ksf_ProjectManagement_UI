<?php

declare(strict_types=1);

namespace Ksfraser\Tests\Unit\PMUI\UI;

use Ksfraser\PMUI\UI\DashboardController;
use PHPUnit\Framework\TestCase;

class DashboardControllerTest extends TestCase
{
    public function testControllerCanBeInstantiated(): void
    {
        $container = $this->createMockContainer();
        $controller = new DashboardController($container, '/templates');

        $this->assertInstanceOf(DashboardController::class, $controller);
    }

    public function testControllerHasRequiredMethods(): void
    {
        $container = $this->createMockContainer();
        $controller = new DashboardController($container, '/templates');

        $this->assertTrue(method_exists($controller, 'index'));
        $this->assertTrue(method_exists($controller, 'getDashboardStats'));
        $this->assertTrue(method_exists($controller, 'getRecentProjects'));
        $this->assertTrue(method_exists($controller, 'getOverdueTasks'));
        $this->assertTrue(method_exists($controller, 'renderStatCard'));
    }

    public function testRenderStatCardReturnsString(): void
    {
        $container = $this->createMockContainer();
        $controller = new DashboardController($container, '/templates');

        $html = $controller->renderStatCard('Total Projects', 10, '📊', 'primary');

        $this->assertIsString($html);
    }

    public function testRenderStatCardContainsLabel(): void
    {
        $container = $this->createMockContainer();
        $controller = new DashboardController($container, '/templates');

        $html = $controller->renderStatCard('Active Tasks', 5, '✓', 'success');

        $this->assertStringContainsString('Active Tasks', $html);
    }

    public function testRenderStatCardContainsValue(): void
    {
        $container = $this->createMockContainer();
        $controller = new DashboardController($container, '/templates');

        $html = $controller->renderStatCard('Total', 42, '📈', 'info');

        $this->assertStringContainsString('42', $html);
    }

    public function testRenderStatCardContainsIcon(): void
    {
        $container = $this->createMockContainer();
        $controller = new DashboardController($container, '/templates');

        $html = $controller->renderStatCard('Stats', 100, '🎯', 'warning');

        $this->assertStringContainsString('🎯', $html);
    }

    public function testRenderStatCardContainsTypeClass(): void
    {
        $container = $this->createMockContainer();
        $controller = new DashboardController($container, '/templates');

        $html = $controller->renderStatCard('Test', 1, '✓', 'danger');

        $this->assertStringContainsString('pm-stat-danger', $html);
    }

    public function testTemplateDirIsStored(): void
    {
        $container = $this->createMockContainer();
        $controller = new DashboardController($container, '/custom/templates');

        $reflection = new \ReflectionClass($controller);
        $property = $reflection->getProperty('templateDir');
        $property->setAccessible(true);

        $this->assertEquals('/custom/templates', $property->getValue($controller));
    }

    public function testProjectServiceIsInjected(): void
    {
        $container = $this->createMockContainer();
        $controller = new DashboardController($container, '/templates');

        $reflection = new \ReflectionClass($controller);
        $property = $reflection->getProperty('projectService');
        $property->setAccessible(true);

        $this->assertNotNull($property->getValue($controller));
    }

    public function testHtmlBuilderIsInjected(): void
    {
        $container = $this->createMockContainer();
        $controller = new DashboardController($container, '/templates');

        $reflection = new \ReflectionClass($controller);
        $property = $reflection->getProperty('html');
        $property->setAccessible(true);

        $this->assertNotNull($property->getValue($controller));
    }

    private function createMockContainer(): object
    {
        return new class implements \Psr\Container\ContainerInterface {
            public function get(string $id): mixed
            {
                return match ($id) {
                    \Ksfraser\ProjectManagement\Contract\ProjectServiceInterface::class => new class implements \Ksfraser\ProjectManagement\Contract\ProjectServiceInterface {
                        public function getAllProjects(): array { return []; }
                        public function getProject(string $id): mixed { return null; }
                        public function createProject(array $data): mixed { return null; }
                        public function updateProject(string $id, array $data): mixed { return null; }
                        public function deleteProject(string $id): void {}
                        public function getProjectsByStatus(string $status): array { return []; }
                        public function getProjectTasks(string $projectId): array { return []; }
                        public function getProjectTeam(string $projectId): array { return []; }
                        public function getProjectCount(): int { return 10; }
                        public function getProjectCountByStatus(string $status): int { return 5; }
                        public function getPendingTaskCount(): int { return 25; }
                        public function getOverdueTaskCount(): int { return 3; }
                        public function getRecentProjects(int $limit): array { return []; }
                        public function getOverdueTasks(int $limit): array { return []; }
                    },
                    \Ksfraser\HTML\HTMLBuilder::class => new class {
                        public function div(array $attrs): string { return '<div></div>'; }
                    },
                    default => null,
                };
            }
            public function has(string $id): bool { return true; }
        };
    }
}