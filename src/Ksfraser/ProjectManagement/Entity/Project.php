<?php

namespace Ksfraser\ProjectManagement\Entity;

class Project
{
    public function getProjectId(): string { return ''; }
    public function getName(): string { return ''; }
    public function getStartDate(): \DateTime { return new \DateTime(); }
    public function getEndDate(): ?\DateTime { return null; }
}