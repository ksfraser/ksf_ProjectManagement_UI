<?php

declare(strict_types=1);

namespace Ksfraser\Tests\Unit\PMUI\Widget;

use Ksfraser\PMUI\Widget\GanttWidget;
use PHPUnit\Framework\TestCase;

class GanttWidgetTest extends TestCase
{
    public function testControllerCanBeInstantiated(): void
    {
        $container = $this->createMockContainer();
        $widget = new GanttWidget($container);

        $this->assertInstanceOf(GanttWidget::class, $widget);
    }

    public function testControllerHasRequiredMethods(): void
    {
        $container = $this->createMockContainer();
        $widget = new GanttWidget($container);

        $this->assertTrue(method_exists($widget, 'renderProjectGantt'));
        $this->assertTrue(method_exists($widget, 'renderMultipleProjects'));
        $this->assertTrue(method_exists($widget, 'toJson'));
    }

    public function testToJsonReturnsString(): void
    {
        $container = $this->createMockContainer();
        $widget = new GanttWidget($container);

        $json = $widget->toJson([]);

        $this->assertIsString($json);
    }

    public function testToJsonReturnsValidJson(): void
    {
        $container = $this->createMockContainer();
        $widget = new GanttWidget($container);

        $data = ['project' => ['id' => '1', 'name' => 'Test Project']];
        $json = $widget->toJson($data);

        $this->assertJson($json);
    }

    public function testToJsonWithEmptyArray(): void
    {
        $container = $this->createMockContainer();
        $widget = new GanttWidget($container);

        $json = $widget->toJson([]);

        $this->assertEquals('[]', $json);
    }

    public function testToJsonWithMultipleProjects(): void
    {
        $container = $this->createMockContainer();
        $widget = new GanttWidget($container);

        $data = [
            ['project' => ['id' => '1', 'name' => 'Project 1']],
            ['project' => ['id' => '2', 'name' => 'Project 2']],
        ];
        $json = $widget->toJson($data);

        $this->assertJson($json);
        $decoded = json_decode($json, true);
        $this->assertCount(2, $decoded);
    }

    public function testToJsonContainsPrettyPrintFlag(): void
    {
        $container = $this->createMockContainer();
        $widget = new GanttWidget($container);

        $data = ['test' => 'value'];
        $json = $widget->toJson($data);

        $this->assertStringContainsString("\n", $json);
    }

    public function testToJsonWithNestedData(): void
    {
        $container = $this->createMockContainer();
        $widget = new GanttWidget($container);

        $data = [
            'project' => [
                'id' => '123',
                'tasks' => [
                    ['id' => 't1', 'name' => 'Task 1'],
                    ['id' => 't2', 'name' => 'Task 2'],
                ],
            ],
        ];
        $json = $widget->toJson($data);

        $this->assertJson($json);
        $decoded = json_decode($json, true);
        $this->assertEquals('123', $decoded['project']['id']);
        $this->assertCount(2, $decoded['project']['tasks']);
    }

    public function testProjectServiceIsInjected(): void
    {
        $container = $this->createMockContainer();
        $widget = new GanttWidget($container);

        $reflection = new \ReflectionClass($widget);
        $property = $reflection->getProperty('projectService');
        $property->setAccessible(true);

        $this->assertNotNull($property->getValue($widget));
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
                        public function getProjectCount(): int { return 0; }
                        public function getProjectCountByStatus(string $status): int { return 0; }
                        public function getPendingTaskCount(): int { return 0; }
                        public function getOverdueTaskCount(): int { return 0; }
                        public function getRecentProjects(int $limit): array { return []; }
                        public function getOverdueTasks(int $limit): array { return []; }
                    },
                    default => null,
                };
            }
            public function has(string $id): bool { return true; }
        };
    }
}