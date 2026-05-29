<?php

namespace Ksfraser\ProjectManagement\DTO\Task;

class TaskDTO
{
    public array $data = [];
    
    public static function fromEntity($entity): self
    {
        $dto = new self();
        $dto->data = [
            'id' => $entity->getTaskId(),
            'name' => $entity->getName(),
        ];
        return $dto;
    }
    
    public function toArray(): array { return $this->data; }
}