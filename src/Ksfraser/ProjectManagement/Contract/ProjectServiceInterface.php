<?php

namespace Ksfraser\ProjectManagement\Contract;

interface ProjectServiceInterface
{
    public function getAllProjects(): array;
    public function getProject(string $id): mixed;
    public function createProject(array $data): mixed;
    public function updateProject(string $id, array $data): mixed;
    public function deleteProject(string $id): void;
    public function getProjectsByStatus(string $status): array;
    public function getProjectTasks(string $projectId): array;
    public function getProjectTeam(string $projectId): array;
    public function getProjectCount(): int;
    public function getProjectCountByStatus(string $status): int;
    public function getPendingTaskCount(): int;
    public function getOverdueTaskCount(): int;
    public function getRecentProjects(int $limit): array;
    public function getOverdueTasks(int $limit): array;
}