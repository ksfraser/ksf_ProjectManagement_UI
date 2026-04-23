<?php
/**
 * Project Dashboard Controller
 *
 * Server-rendered HTML for project dashboard
 *
 * @package Ksfraser\PMUI\UI
 */

declare(strict_types=1);

namespace Ksfraser\PMUI\UI;

use Ksfraser\HTML\HTMLBuilder;
use Ksfraser\ProjectManagement\Contract\ProjectServiceInterface;
use Psr\Container\ContainerInterface;

class DashboardController
{
    private ProjectServiceInterface $projectService;
    private HTMLBuilder $html;

    public function __construct(
        ContainerInterface $container,
        private readonly string $templateDir
    ) {
        $this->projectService = $container->get(ProjectServiceInterface::class);
        $this->html = new HTMLBuilder();
    }

    public function index(): string
    {
        $stats = $this->getDashboardStats();
        $recentProjects = $this->getRecentProjects();
        $overdueTasks = $this->getOverdueTasks();

        return $this->renderDashboard($stats, $recentProjects, $overdueTasks);
    }

    private function getDashboardStats(): array
    {
        return [
            'total_projects' => $this->projectService->getProjectCount(),
            'active_projects' => $this->projectService->getProjectCountByStatus('Active'),
            'pending_tasks' => $this->projectService->getPendingTaskCount(),
            'overdue_tasks' => $this->projectService->getOverdueTaskCount(),
        ];
    }

    private function getRecentProjects(): array
    {
        return $this->projectService->getRecentProjects(5);
    }

    private function getOverdueTasks(): array
    {
        return $this->projectService->getOverdueTasks(5);
    }

    private function renderDashboard(array $stats, array $recentProjects, array $overdueTasks): string
    {
        ob_start();
        include $this->templateDir . '/dashboard.php';
        return ob_get_clean();
    }

    public function renderStatCard(string $label, int $value, string $icon, string $type): string
    {
        return $this->html->div([
            'class' => 'pm-stat-card pm-stat-' . $type,
            'content' => [
                $this->html->div(['class' => 'pm-stat-icon', 'content' => $icon]),
                $this->html->div(['class' => 'pm-stat-value', 'content' => (string) $value]),
                $this->html->div(['class' => 'pm-stat-label', 'content' => $label]),
            ]
        ]);
    }
}