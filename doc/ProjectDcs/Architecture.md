# ProjectManagement_UI - Architecture

**Document ID:** ARCH-PMUI-001  
**Module:** ksf_ProjectManagement_UI  
**Version:** 1.0.0  

---

## 1. Module Overview

ProjectManagement_UI implements MVC patterns with DTOs for data transfer, controllers for business logic, and widgets for visualization.

## 2. Class Diagram

```
┌─────────────────────────────────────────────────────────────┐
│                Controllers (Business Logic)                  │
├─────────────────────────────────────────────────────────────┤
│ - DashboardController                                       │
│   + render(): void                                         │
│   + getProjects(): array                                   │
│   + getTaskSummary(): array                                │
└─────────────────────────────────────────────────────────────┘
                              │
┌─────────────────────────────────────────────────────────────┐
│                API Controllers                             │
├─────────────────────────────────────────────────────────────┤
│ - ProjectApiController                                      │
│   + list(): Response                                        │
│   + get(id): Response                                       │
│   + create(data): Response                                  │
│   + update(id, data): Response                             │
│   + delete(id): Response                                    │
└─────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────┐
│                   Entities                                  │
├─────────────────────────────────────────────────────────────┤
│ - Project                                                   │
│   + getProjectId(): string                                  │
│   + getName(): string                                       │
│   + getStartDate(): DateTime                                │
│   + getEndDate(): ?DateTime                                 │
└─────────────────────────────────────────────────────────────┘
                              │
┌─────────────────────────────────────────────────────────────┐
│                    DTOs                                     │
├─────────────────────────────────────────────────────────────┤
│ - ProjectDTO                                                │
│   - project_id: string                                      │
│   - name: string                                            │
│   - start_date: string                                      │
│   - end_date: ?string                                       │
├─────────────────────────────────────────────────────────────┤
│ - TaskDTO                                                   │
│   - task_id: string                                         │
│   - project_id: string                                      │
│   - title: string                                           │
│   - status: string                                          │
└─────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────┐
│                  UI Components                              │
├─────────────────────────────────────────────────────────────┤
│ - HTMLBuilder                                               │
│   + renderProjectCard(): string                            │
│   + renderTaskList(): string                               │
│   + renderProgress(): string                                │
├─────────────────────────────────────────────────────────────┤
│ - GanttWidget                                               │
│   + render(): string                                       │
│   + setTimeline(): void                                     │
├─────────────────────────────────────────────────────────────┤
│ - Request/Response (Superglobals)                          │
│   + getParams(): array                                      │
│   + getJsonBody(): array                                    │
└─────────────────────────────────────────────────────────────┘
```

## 3. Directory Structure

```
ksf_ProjectManagement_UI/
├── src/Ksfraser/
│   ├── ProjectManagement/
│   │   ├── Entity/
│   │   │   ├── Project.php
│   │   │   └── Task.php
│   │   ├── DTO/
│   │   │   ├── Project/ProjectDTO.php
│   │   │   └── Task/TaskDTO.php
│   │   └── Exception/
│   │       └── Exceptions.php
│   ├── UI/
│   │   └── DashboardController.php
│   ├── HTML/
│   │   └── HTMLBuilder.php
│   ├── Widget/
│   │   └── GanttWidget.php
│   ├── API/
│   │   └── ProjectApiController.php
│   └── KsfSuperglobals/
│       ├── Request.php
│       └── Response.php
├── templates/
│   └── dashboard.php
├── pages/
├── tests/
└── doc/ProjectDcs/
```

## 4. Technology Stack

| Component | Technology |
|-----------|------------|
| Language | PHP 7.3+ |
| HTTP | PSR-7 style |
| Database | Via ProjectManagement backend |
| Widgets | Custom HTML builder |