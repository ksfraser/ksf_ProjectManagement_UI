<?php
/**
 * Project Dashboard Template
 */

use Ksfraser\PMUI\Widget\GanttWidget;

$title = 'Project Dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="/assets/css/pm-ui.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/frappe-gantt@0.5.0/dist/frappe-gantt.css">
</head>
<body>
    <div class="pm-container">
        <header class="pm-header">
            <h1>Project Dashboard</h1>
            <nav>
                <a href="/projects">Projects</a>
                <a href="/tasks">Tasks</a>
                <a href="/team">Team</a>
                <a href="/reports">Reports</a>
            </nav>
        </header>

        <section class="pm-stats-row">
            <?php foreach ($stats as $stat): ?>
                <?= $controller->renderStatCard($stat['label'], $stat['value'], $stat['icon'], $stat['type']) ?>
            <?php endforeach; ?>
        </section>

        <div class="pm-main-grid">
            <section class="pm-recent-projects">
                <h2>Recent Projects</h2>
                <table class="pm-table">
                    <thead>
                        <tr>
                            <th>Project</th>
                            <th>Status</th>
                            <th>Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentProjects as $project): ?>
                        <tr>
                            <td><a href="/projects/<?= $project->getProjectId() ?>"><?= htmlspecialchars($project->getName()) ?></a></td>
                            <td><span class="pm-status pm-status-<?= strtolower($project->getStatus()) ?>"><?= $project->getStatus() ?></span></td>
                            <td>
                                <div class="pm-progress-bar">
                                    <div class="pm-progress-fill" style="width: <?= $project->getProgress() ?>%"></div>
                                </div>
                                <?= $project->getProgress() ?>%
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>

            <section class="pm-overdue-tasks">
                <h2>Overdue Tasks</h2>
                <?php if (empty($overdueTasks)): ?>
                    <p class="pm-empty">No overdue tasks</p>
                <?php else: ?>
                    <ul class="pm-task-list">
                        <?php foreach ($overdueTasks as $task): ?>
                            <li class="pm-task-overdue">
                                <a href="/tasks/<?= $task->getTaskId() ?>"><?= htmlspecialchars($task->getName()) ?></a>
                                <span class="pm-task-project"><?= $task->getProjectId() ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </section>
        </div>

        <section class="pm-gantt-section">
            <h2>Project Timeline</h2>
            <div id="gantt-chart" class="pm-gantt-container"></div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/frappe-gantt@0.5.0/dist/frappe-gantt.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/api/gantt')
                .then(r => r.json())
                .then(data => {
                    new Gantt('#gantt-chart', data.tasks, {
                        view_mode: 'Month',
                        date_format: 'YYYY-MM-DD'
                    });
                });
        });
    </script>
</body>
</html>