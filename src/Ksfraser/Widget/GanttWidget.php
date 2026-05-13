<?php
/**
 * Gantt Widget
 *
 * Renders Gantt chart data JSON for client-side rendering
 *
 * @package Ksfraser\PMUI\Widget
 */

declare(strict_types=1);

namespace Ksfraser\PMUI\Widget;

use Ksfraser\ProjectManagement\Contract\ProjectServiceInterface;
use Ksfraser\ProjectManagement\Entity\Project;
use Ksfraser\ProjectManagement\Entity\Task;
use Psr\Container\ContainerInterface;

class GanttWidget
{
    private ProjectServiceInterface $projectService;

    public function __construct(ContainerInterface $container)
    {
        $this->projectService = $container->get(ProjectServiceInterface::class);
    }

    public function renderProjectGantt(string $projectId): array
    {
        $project = $this->projectService->getProject($projectId);
        $tasks = $this->projectService->getProjectTasks($projectId);

        return $this->buildGanttData($project, $tasks);
    }

    public function renderMultipleProjects(array $projectIds): array
    {
        $ganttData = [];

        foreach ($projectIds as $projectId) {
            try {
                $project = $this->projectService->getProject($projectId);
                $tasks = $this->projectService->getProjectTasks($projectId);
                $ganttData[] = $this->buildGanttData($project, $tasks);
            } catch (\Exception $e) {
                continue;
            }
        }

        return $ganttData;
    }

    private function buildGanttData(Project $project, array $tasks): array
    {
        $startDate = $project->getStartDate();
        $endDate = $project->getEndDate() ?? new \DateTime('+30 days');

        $ganttTask = [
            'id' => 'project_' . $project->getProjectId(),
            'name' => $project->getName(),
            'start' => $startDate->format('Y-m-d'),
            'end' => $endDate->format('Y-m-d'),
            'progress' => $this->calculateProjectProgress($tasks),
            'dependencies' => [],
            'is_project' => true,
            'custom_class' => 'gantt-project-row',
        ];

        $childTasks = [];
        foreach ($tasks as $task) {
            if (empty($task->getParentTaskId())) {
                $childTasks[] = $this->buildTaskGanttItem($task, $tasks);
            }
        }

        return [
            'project' => $ganttTask,
            'tasks' => $childTasks,
            'task_count' => count($tasks),
            'completed_count' => count(array_filter($tasks, fn($t) => $t->isCompleted())),
        ];
    }

    private function buildTaskGanttItem(Task $task, array $allTasks): array
    {
        $dependencies = [];
        foreach ($allTasks as $t) {
            if ($t->getParentTaskId() === $task->getTaskId()) {
                $dependencies[] = 'task_' . $t->getTaskId();
            }
        }

        $startDate = $task->getStartDate()?->format('Y-m-d') ?? date('Y-m-d');
        $endDate = $task->getEndDate()?->format('Y-m-d') ?? date('Y-m-d', strtotime('+1 day'));

        return [
            'id' => 'task_' . $task->getTaskId(),
            'name' => $task->getName(),
            'start' => $startDate,
            'end' => $endDate,
            'progress' => $task->getProgress(),
            'dependencies' => $dependencies,
            'priority' => $task->getPriority(),
            'status' => $task->getStatus(),
            'assigned_to' => $task->getAssignedTo(),
            'is_project' => false,
            'custom_class' => $this->getStatusClass($task->getStatus()),
        ];
    }

    private function calculateProjectProgress(array $tasks): float
    {
        if (empty($tasks)) {
            return 0.0;
        }

        $totalProgress = 0.0;
        foreach ($tasks as $task) {
            $totalProgress += $task->getProgress();
        }

        return $totalProgress / count($tasks);
    }

    private function getStatusClass(string $status): string
    {
        return match ($status) {
            'Completed' => 'gantt-task-completed',
            'In Progress' => 'gantt-task-in-progress',
            'On Hold' => 'gantt-task-on-hold',
            'Not Started' => 'gantt-task-not-started',
            default => '',
        };
    }

    public function toJson(array $ganttData): string
    {
        return json_encode($ganttData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}