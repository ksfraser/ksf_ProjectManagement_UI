# ksf_ProjectManagement_UI - Architecture

## Document Information

| Field | Value |
|-------|-------|
| **Document ID** | ARCH-PM-001 |
| **Module** | ksf_ProjectManagement_UI |
| **Project** | Project Management UI |
| **Version** | 1.0.0 |
| **Author** | KS Fraser Development Team |
| **Created** | 2024-01-15 |

---

## 1. Technical Architecture Overview

### 1.1 Architecture Pattern
The ksf_ProjectManagement_UI module follows **Domain-Driven Design** with clear separation between entities, DTOs, API, and UI layers.

### 1.2 Module Classification
- **Type**: Business Logic + UI Adapter
- **Namespace**: `Ksfraser\ProjectManagement`
- **Platform**: FrontAccounting with standalone capability

### 1.3 Architecture Layers

```
┌──────────────────────────────────────────────────────────────┐
│                    PRESENTATION LAYER                        │
│  ┌────────────────────────────────────────────────────────┐  │
│  │  UI Layer                                               │  │
│  │  - HTML generation                                       │  │
│  │  - Widget components                                     │  │
│  │  - Templates                                             │  │
│  └────────────────────────────────────────────────────────┘  │
└──────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌──────────────────────────────────────────────────────────────┐
│                    API LAYER                                 │
│  ┌────────────────────────────────────────────────────────┐  │
│  │  API Components                                         │  │
│  │  - REST-style endpoints                                 │  │
│  │  - Request handling                                     │  │
│  │  - Response formatting                                  │  │
│  └────────────────────────────────────────────────────────┘  │
└──────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌──────────────────────────────────────────────────────────────┐
│                    DTO LAYER                                 │
│  ┌────────────────────────────────────────────────────────┐  │
│  │  DTOs (Data Transfer Objects)                             │  │
│  │  - ProjectDTO                                            │  │
│  │  - TaskDTO                                              │  │
│  │  - Immutability patterns                                │  │
│  └────────────────────────────────────────────────────────┘  │
└──────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌──────────────────────────────────────────────────────────────┐
│                    ENTITY LAYER                              │
│  ┌────────────────────────────────────────────────────────┐  │
│  │  Domain Entities                                        │  │
│  │  - Project                                              │  │
│  │  - Task                                                 │  │
│  │  - Domain logic                                         │  │
│  └────────────────────────────────────────────────────────┘  │
└──────────────────────────────────────────────────────────────┘
```

---

## 2. Class Diagram

### 2.1 Entity Classes

```
┌─────────────────────────────────────────────────────────────┐
│                      Project Entity                          │
├─────────────────────────────────────────────────────────────┤
│ + projectId: string                                         │
│ + name: string                                              │
│ + startDate: DateTime                                        │
│ + endDate: ?DateTime                                         │
├─────────────────────────────────────────────────────────────┤
│ + getProjectId(): string                                    │
│ + getName(): string                                         │
│ + getStartDate(): DateTime                                  │
│ + getEndDate(): ?DateTime                                   │
└─────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────┐
│                       Task Entity                           │
├─────────────────────────────────────────────────────────────┤
│ + taskId: string                                           │
│ + name: string                                              │
│ + startDate: ?DateTime                                      │
│ + endDate: ?DateTime                                         │
│ + progress: float                                            │
│ + priority: string                                          │
│ + status: string                                            │
│ + assignedTo: string                                        │
│ + parentTaskId: ?string                                     │
├─────────────────────────────────────────────────────────────┤
│ + getTaskId(): string                                       │
│ + getName(): string                                         │
│ + getStartDate(): ?DateTime                                 │
│ + getEndDate(): ?DateTime                                   │
│ + getProgress(): float                                      │
│ + getPriority(): string                                      │
│ + getStatus(): string                                        │
│ + getAssignedTo(): string                                   │
│ + getParentTaskId(): ?string                                │
│ + isCompleted(): bool                                        │
└─────────────────────────────────────────────────────────────┘
```

### 2.2 DTO Classes

```
┌─────────────────────────────────────────────────────────────┐
│                     ProjectDTO                              │
├─────────────────────────────────────────────────────────────┤
│ + data: array                                              │
├─────────────────────────────────────────────────────────────┤
│ + static fromEntity(entity): ProjectDTO                    │
│ + toArray(): array                                        │
│ + withTasks(tasks): ProjectDTO                            │
│ + withTeam(team): ProjectDTO                              │
└─────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────┐
│                      TaskDTO                               │
├─────────────────────────────────────────────────────────────┤
│ + data: array                                              │
├─────────────────────────────────────────────────────────────┤
│ + static fromEntity(entity): TaskDTO                      │
│ + toArray(): array                                        │
└─────────────────────────────────────────────────────────────┘
```

### 2.3 Component Structure

```
┌─────────────────────────────────────────────────────────────┐
│                    ProjectManagement                        │
├─────────────────────────────────────────────────────────────┤
│  Namespace: Ksfraser\ProjectManagement                     │
│                                                              │
│  ├─ Entity/                                                 │
│  │   ├─ Project.php                                         │
│  │   └─ Task.php                                            │
│  │                                                          │
│  ├─ DTO/                                                   │
│  │   ├─ Project/ProjectDTO.php                             │
│  │   └─ Task/TaskDTO.php                                   │
│  │                                                          │
│  ├─ Contract/                                               │
│  │   ├─ ProjectRepositoryInterface.php                     │
│  │   └─ TaskRepositoryInterface.php                        │
│  │                                                          │
│  ├─ Exception/                                              │
│  │   ├─ ProjectNotFoundException.php                       │
│  │   └─ TaskNotFoundException.php                         │
│  │                                                          │
│  ├─ API/                                                   │
│  │   └─ (API controllers)                                  │
│  │                                                          │
│  ├─ HTML/                                                  │
│  │   └─ (HTML generation utilities)                        │
│  │                                                          │
│  ├─ Widget/                                                │
│  │   └─ (UI widget components)                            │
│  │                                                          │
│  └─ KsfSuperglobals/                                       │
│      └─ (Input handling utilities)                         │
└─────────────────────────────────────────────────────────────┘
```

---

## 3. Data Flow

### 3.1 Entity to DTO Flow

```
┌─────────────┐    ┌─────────────┐    ┌─────────────┐
│  Database   │    │  Entity    │    │    DTO     │
│  (Row)      │───▶│  (Object)  │───▶│  (Array)   │
└─────────────┘    └─────────────┘    └─────────────┘
                          │                  │
                   fromRow()         toArray()
                   constructor        serialized
```

### 3.2 Task Hierarchy Flow

```
┌─────────────┐
│   Project   │
└──────┬──────┘
       │
       │ has many
       ▼
┌─────────────┐
│    Task     │
│  (Parent)   │
└──────┬──────┘
       │
       │ has many
       ▼
┌─────────────┐
│    Task     │
│  (Child)    │─── parentTaskId
└─────────────┘
```

### 3.3 API Request Flow

```
┌─────────────┐    ┌─────────────┐    ┌─────────────┐    ┌─────────────┐
│  HTTP       │    │   API      │    │  Service   │    │ Repository │
│  Request    │───▶│  Layer     │───▶│   Layer    │───▶│   Layer    │
└─────────────┘    └─────────────┘    └─────────────┘    └─────────────┘
     │                  │                  │                  │
     │  GET /project    │  Route           │  Business        │  Database
     │  ?id=123        │  Dispatch        │  Logic          │  Query
     │                  │                  │                  │
     │  Response       │                  │                  │
     │  (JSON)         │                  │                  │
     └──────────────────┴──────────────────┴──────────────────┘
```

---

## 4. File Structure

### 4.1 Module Directory Structure

```
ksf_ProjectManagement_UI/
├── ProjectDcs/
│   ├── ProjectDcs/
│   │   ├── Business Requirements.md
│   │   ├── Architecture.md
│   │   ├── Functional Requirements.md
│   │   ├── Use Case.md
│   │   ├── Test Plan.md
│   │   └── UAT Plan.md
│   ├── BABOK/
│   ├── UML/
│   └── RTM/
├── src/
│   └── Ksfraser/
│       └── ProjectManagement/
│           ├── Entity/
│           │   ├── Project.php
│           │   └── Task.php
│           ├── DTO/
│           │   ├── Project/
│           │   │   └── ProjectDTO.php
│           │   └── Task/
│           │       └── TaskDTO.php
│           ├── Contract/
│           ├── Exception/
│           ├── API/
│           ├── HTML/
│           ├── Widget/
│           └── KsfSuperglobals/
├── templates/
├── assets/
├── doc/
├── tests/
├── composer.json
└── README.md
```

---

## 5. Entity Specifications

### 5.1 Project Entity

```php
class Project
{
    public function getProjectId(): string { return ''; }
    public function getName(): string { return ''; }
    public function getStartDate(): DateTime { return new DateTime(); }
    public function getEndDate(): ?DateTime { return null; }
}
```

### 5.2 Task Entity

```php
class Task
{
    public function getTaskId(): string { return ''; }
    public function getName(): string { return ''; }
    public function getStartDate(): ?DateTime { return null; }
    public function getEndDate(): ?DateTime { return null; }
    public function getProgress(): float { return 0.0; }
    public function getPriority(): string { return 'medium'; }
    public function getStatus(): string { return 'pending'; }
    public function getAssignedTo(): string { return ''; }
    public function getParentTaskId(): ?string { return null; }
    public function isCompleted(): bool { return false; }
}
```

### 5.3 Default Values

| Property | Default | Notes |
|----------|---------|-------|
| progress | 0.0 | 0.0 to 1.0 |
| priority | 'medium' | low/medium/high/critical |
| status | 'pending' | pending/in_progress/completed |
| isCompleted | false | Derived from progress/status |

---

## 6. Design Patterns

### 6.1 Entity Pattern
Domain entities encapsulate business logic:
- Getters for properties
- Business rules encapsulated
- No direct database dependency

### 6.2 DTO Pattern
Data Transfer Objects for API:
- Immutable or with-modifier methods
- Easy serialization to arrays/JSON
- Enrichment methods (withTasks, withTeam)

### 6.3 Repository Pattern
Data access abstraction (via Contract):
```php
interface ProjectRepositoryInterface {
    public function find(string $id): ?Project;
    public function findAll(array $filters = []): array;
    public function save(Project $project): void;
    public function delete(string $id): void;
}
```

### 6.4 Factory Pattern
DTO factories for creation:
```php
ProjectDTO::fromEntity($entity): self
TaskDTO::fromEntity($entity): self
```

---

## 7. Integration Points

### 7.1 FrontAccounting Integration
- UI components use FA theme
- Session management via FA
- Permission checking via FA

### 7.2 Future API Integration
- REST API endpoints planned
- JSON request/response format
- Authentication layer

---

**Document Owner**: KS Fraser Development Team  
**Review Status**: Pending