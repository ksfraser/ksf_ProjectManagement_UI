<?php

namespace Ksfraser\ProjectManagement\Exception;

class ProjectException extends \Exception {}
class ValidationException extends \Exception 
{
    public function getErrors(): array { return []; }
}