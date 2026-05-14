# Project Management UI Module - Architecture

## Document Information

| Field | Value |
|-------|-------|
| Document Title | Technical Architecture Specification |
| Module | ksf_ProjectManagement_UI |
| Version | 1.0.0 |
| Author | KSF Development Team |
| Last Updated | May 2026 |

---

## 1. Architecture Overview

### 1.1 Module Structure

```
ksf_ProjectManagement_UI/
├── src/Ksfraser/ProjectUI/
│   ├── ProjectDashboard.php     # Project overview
│   ├── TaskList.php             # Task list widget
│   ├── GanttChart.php           # Gantt visualization
│   └── WorkloadView.php         # Team workload
└── templates/
```

---

## 2. Core Classes

### 2.1 ProjectDashboard

```php
namespace Ksfraser\ProjectUI;

class ProjectDashboard {
    
    public function render(int $projectId): string;
    public function renderPortfolio(int $userId): string;
    public function getProjectSummary(int $projectId): array;
}
```

### 2.2 TaskList

```php
namespace Ksfraser\ProjectUI;

class TaskList {
    
    public function render(int $projectId, array $filters = []): string;
    public function renderMyTasks(int $employeeId): string;
}
```

---

## 3. Revision History

| Version | Date | Author | Changes |
|---------|------|--------|---------|
| 1.0.0 | May 2026 | KSF Development Team | Initial specification |