<?php

namespace Ksfraser\ProjectManagement\Entity;

class Task
{
    public function getTaskId(): string { return ''; }
    public function getName(): string { return ''; }
    public function getStartDate(): ?\DateTime { return null; }
    public function getEndDate(): ?\DateTime { return null; }
    public function getProgress(): float { return 0.0; }
    public function getPriority(): string { return 'medium'; }
    public function getStatus(): string { return 'pending'; }
    public function getAssignedTo(): string { return ''; }
    public function getParentTaskId(): ?string { return null; }
    public function isCompleted(): bool { return false; }
}