<?php
/**
 * Project API Controller
 *
 * REST API endpoints for Project management
 *
 * @package Ksfraser\PMUI\API
 */

declare(strict_types=1);

namespace Ksfraser\PMUI\API;

use Ksfraser\ProjectManagement\Contract\ProjectServiceInterface;
use Ksfraser\ProjectManagement\DTO\Project\ProjectDTO;
use Ksfraser\ProjectManagement\Exception\ProjectException;
use Ksfraser\ProjectManagement\Exception\ValidationException;
use KsfSuperglobals\Request;
use KsfSuperglobals\Response;
use Psr\Container\ContainerInterface;

class ProjectApiController
{
    private ProjectServiceInterface $projectService;
    private Response $response;
    private string $basePath;

    public function __construct(
        ContainerInterface $container,
        string $basePath = '/api/projects'
    ) {
        $this->projectService = $container->get(ProjectServiceInterface::class);
        $this->response = $container->get(Response::class);
        $this->basePath = $basePath;
    }

    public function handle(Request $request): void
    {
        $path = $request->getPath();
        $method = $request->getMethod();

        if (strpos($path, $this->basePath . '/') === 0) {
            $id = substr($path, strlen($this->basePath) + 1);
            $this->handleSingle($id, $method, $request);
            return;
        }

        switch ($path) {
            case $this->basePath:
                $this->handleCollection($method, $request);
                break;
            default:
                $this->response->notFound();
        }
    }

    private function handleCollection(string $method, Request $request): void
    {
        switch ($method) {
            case 'GET':
                $this->index($request);
                break;
            case 'POST':
                $this->create($request);
                break;
            default:
                $this->response->methodNotAllowed();
        }
    }

    private function handleSingle(string $id, string $method, Request $request): void
    {
        if ($id === '') {
            $this->response->notFound();
            return;
        }

        switch ($method) {
            case 'GET':
                $this->show($id);
                break;
            case 'PUT':
            case 'PATCH':
                $this->update($id, $request);
                break;
            case 'DELETE':
                $this->delete($id);
                break;
            default:
                $this->response->methodNotAllowed();
        }
    }

    private function index(Request $request): void
    {
        $status = $request->getQuery('status', '');
        $search = $request->getQuery('search', '');

        try {
            if ($status) {
                $projects = $this->projectService->getProjectsByStatus($status);
            } else {
                $projects = $this->projectService->getAllProjects();
            }

            $dtos = array_map(
                fn($project) => ProjectDTO::fromEntity($project)->toArray(),
                $projects
            );

            $this->response->json(['data' => $dtos]);
        } catch (ProjectException $e) {
            $this->response->error($e->getMessage(), 500);
        }
    }

    private function show(string $id): void
    {
        try {
            $project = $this->projectService->getProject($id);
            $dto = ProjectDTO::fromEntity($project);

            $tasks = $this->projectService->getProjectTasks($id);
            $dto = $dto->withTasks(array_map(
                fn($task) => \Ksfraser\ProjectManagement\DTO\Task\TaskDTO::fromEntity($task)->toArray(),
                $tasks
            ));

            $team = $this->projectService->getProjectTeam($id);
            $dto = $dto->withTeam($team);

            $this->response->json(['data' => $dto->toArray()]);
        } catch (ProjectException $e) {
            $this->response->error($e->getMessage(), 404);
        }
    }

    private function create(Request $request): void
    {
        $data = $request->getJsonBody() ?? $request->getPostBody();

        try {
            $project = $this->projectService->createProject($data);
            $dto = ProjectDTO::fromEntity($project);

            $this->response->json(['data' => $dto->toArray()], 201);
        } catch (ValidationException $e) {
            $this->response->json([
                'error' => $e->getMessage(),
                'errors' => $e->getErrors()
            ], 422);
        } catch (ProjectException $e) {
            $this->response->error($e->getMessage(), 400);
        }
    }

    private function update(string $id, Request $request): void
    {
        $data = $request->getJsonBody() ?? $request->getPostBody();

        try {
            $project = $this->projectService->updateProject($id, $data);
            $dto = ProjectDTO::fromEntity($project);

            $this->response->json(['data' => $dto->toArray()]);
        } catch (ValidationException $e) {
            $this->response->json([
                'error' => $e->getMessage(),
                'errors' => $e->getErrors()
            ], 422);
        } catch (ProjectException $e) {
            $this->response->error($e->getMessage(), 400);
        }
    }

    private function delete(string $id): void
    {
        try {
            $this->projectService->deleteProject($id);
            $this->response->json(['message' => 'Project deleted']);
        } catch (ProjectException $e) {
            $this->response->error($e->getMessage(), 400);
        }
    }
}