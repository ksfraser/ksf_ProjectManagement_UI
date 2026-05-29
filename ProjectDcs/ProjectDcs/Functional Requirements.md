# ksf_ProjectManagement_UI - Functional Requirements

## Document Information

| Field | Value |
|-------|-------|
| **Document ID** | FRD-PM-001 |
| **Module** | ksf_ProjectManagement_UI |
| **Project** | Project Management UI |
| **Version** | 1.0.0 |
| **Author** | KS Fraser Development Team |
| **Created** | 2024-01-15 |

---

## 1. Functional Requirements

### 1.1 Entity Management

#### FR-001: Project Entity
| Requirement ID | FR-001 |
|----------------|--------|
| **Priority** | High |

**Description**: Provide Project entity with core properties.

**Methods**:
```php
public function getProjectId(): string;
public function getName(): string;
public function getStartDate(): DateTime;
public function getEndDate(): ?DateTime;
```

**Properties**:
| Property | Type | Default |
|----------|------|---------|
| projectId | string | Empty string |
| name | string | Empty string |
| startDate | DateTime | Current date |
| endDate | ?DateTime | null |

---

#### FR-002: Task Entity
| Requirement ID | FR-002 |
|----------------|--------|
| **Priority** | High |

**Description**: Provide Task entity with comprehensive properties.

**Methods**:
```php
public function getTaskId(): string;
public function getName(): string;
public function getStartDate(): ?DateTime;
public function getEndDate(): ?DateTime;
public function getProgress(): float;
public function getPriority(): string;
public function getStatus(): string;
public function getAssignedTo(): string;
public function getParentTaskId(): ?string;
public function isCompleted(): bool;
```

**Properties**:
| Property | Type | Default | Notes |
|----------|------|---------|-------|
| taskId | string | "" | |
| name | string | "" | |
| startDate | ?DateTime | null | |
| endDate | ?DateTime | null | |
| progress | float | 0.0 | 0.0-1.0 |
| priority | string | 'medium' | low/medium/high/critical |
| status | string | 'pending' | pending/in_progress/completed |
| assignedTo | string | "" | |
| parentTaskId | ?string | null | For hierarchy |

**Status Values**:
| Value | Description |
|-------|-------------|
| pending | Not started |
| in_progress | Work started |
| completed | Work finished |

**Priority Values**:
| Value | Description |
|-------|-------------|
| low | Low priority |
| medium | Default priority |
| high | High priority |
| critical | Critical priority |

---

### 1.2 DTO Management

#### FR-003: ProjectDTO
| Requirement ID | FR-003 |
|----------------|--------|
| **Priority** | High |

**Description**: Data Transfer Object for Project.

**Methods**:
```php
public static function fromEntity($entity): self;
public function toArray(): array;
public function withTasks(array $tasks): self;
public function withTeam(array $team): self;
```

**Usage**:
```php
$dto = ProjectDTO::fromEntity($project);
$dto = $dto->withTasks([$task1, $task2]);
$dto = $dto->withTeam([$member1, $member2]);
$array = $dto->toArray();
```

---

#### FR-004: TaskDTO
| Requirement ID | FR-004 |
|----------------|--------|
| **Priority** | High |

**Description**: Data Transfer Object for Task.

**Methods**:
```php
public static function fromEntity($entity): self;
public function toArray(): array;
```

**Usage**:
```php
$dto = TaskDTO::fromEntity($task);
$array = $dto->toArray();
```

---

### 1.3 API Layer

#### FR-005: API Components
| Requirement ID | FR-005 |
|----------------|--------|
| **Priority** | Medium |

**Description**: Provide API layer for external access.

**Components**:
- Request handling
- Response formatting
- Controller structure

---

### 1.4 UI Components

#### FR-006: HTML Generation
| Requirement ID | FR-006 |
|----------------|--------|
| **Priority** | Medium |

**Description**: HTML generation utilities.

**Components**:
- Element creation
- Form generation
- Table generation
- Output buffering

#### FR-007: Widget System
| Requirement ID | FR-007 |
|----------------|--------|
| **Priority** | Medium |

**Description**: Reusable UI widget components.

**Widgets**:
- Project display widgets
- Task list widgets
- Progress indicators
- Status badges

---

## 2. Data Structures

### 2.1 Project Data

```php
[
    'id' => string,
    'name' => string,
    'startDate' => 'Y-m-d',
    'endDate' => 'Y-m-d' | null,
    'tasks' => array,     // via withTasks()
    'team' => array      // via withTeam()
]
```

### 2.2 Task Data

```php
[
    'id' => string,
    'name' => string,
    'startDate' => 'Y-m-d H:i:s' | null,
    'endDate' => 'Y-m-d H:i:s' | null,
    'progress' => float,
    'priority' => string,
    'status' => string,
    'assignedTo' => string,
    'parentTaskId' => string | null
]
```

---

## 3. Non-Functional Requirements

### 3.1 Performance
| Metric | Target |
|--------|--------|
| Entity instantiation | < 1ms |
| DTO conversion | < 2ms |
| Array conversion | < 1ms |

### 3.2 Compatibility
| Requirement | Specification |
|------------|---------------|
| PHP Version | 7.3+ |
| DateTime | Native PHP |

---

## 4. Requirements Traceability

| Requirement ID | Use Case | Test Case | Status |
|---------------|----------|-----------|--------|
| FR-001 | UC-001 | TC-001 | Pending |
| FR-002 | UC-002 | TC-002 | Pending |
| FR-003 | UC-003 | TC-003 | Pending |
| FR-004 | UC-004 | TC-004 | Pending |

---

**Document Owner**: KS Fraser Development Team  
**Review Status**: Pending