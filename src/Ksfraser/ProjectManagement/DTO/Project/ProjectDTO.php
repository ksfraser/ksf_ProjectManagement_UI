<?php

namespace Ksfraser\ProjectManagement\DTO\Project;

class ProjectDTO
{
    public array $data = [];
    
    public static function fromEntity($entity): self
    {
        $dto = new self();
        $dto->data = [
            'id' => $entity->getProjectId(),
            'name' => $entity->getName(),
        ];
        return $dto;
    }
    
    public function toArray(): array { return $this->data; }
    public function withTasks(array $tasks): self { return $this; }
    public function withTeam(array $team): self { return $this; }
}