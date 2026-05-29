# ksf_ProjectManagement_UI - Use Case Specification

## Document Information

| Field | Value |
|-------|-------|
| **Document ID** | UCD-PM-001 |
| **Module** | ksf_ProjectManagement_UI |
| **Project** | Project Management UI |
| **Version** | 1.0.0 |
| **Author** | KS Fraser Development Team |
| **Created** | 2024-01-15 |

---

## 1. Use Case Overview

### 1.1 Actor Definitions

| Actor | Description |
|-------|-------------|
| **Project Manager** | Creates/manages projects |
| **Team Member** | Views and updates tasks |
| **Stakeholder** | Monitors progress |
| **API Consumer** | Integrates via API |

### 1.2 Use Case Summary

| UC ID | Use Case | Actor | Priority |
|-------|----------|-------|----------|
| UC-001 | Manage Projects | Project Manager | High |
| UC-002 | Manage Tasks | Team Member | High |
| UC-003 | View Project Details | Any | Medium |
| UC-004 | Track Task Progress | Team Member | Medium |

---

## 2. Use Case Details

### 2.1 UC-001: Manage Projects

**Primary Actor**: Project Manager  
**Priority**: High

#### Description
Create, read, update, and delete project entities.

#### Basic Flow
```
1. Project Manager creates Project entity
2. Sets project properties:
   - projectId
   - name
   - startDate
   - endDate (optional)
3. Converts entity to DTO for transfer
4. Saves via repository
```

---

### 2.2 UC-002: Manage Tasks

**Primary Actor**: Team Member  
**Priority**: High

#### Description
Create and manage tasks with hierarchy.

#### Basic Flow
```
1. Team member creates Task entity
2. Sets task properties:
   - taskId
   - name
   - dates (start/end)
   - priority
   - status
   - assignedTo
   - parentTaskId (for subtasks)
3. Tracks progress
4. Marks completion when done
```

#### Task Hierarchy
```
Project
  └── Phase 1 (Parent Task)
        ├── Task 1.1 (Subtask)
        ├── Task 1.2 (Subtask)
        └── Task 1.3 (Subtask)
```

---

### 2.3 UC-003: View Project Details

**Primary Actor**: Stakeholder  
**Priority**: Medium

#### Description
View project information via DTO.

#### Basic Flow
```
1. Stakeholder requests project
2. System retrieves Project entity
3. Converts to ProjectDTO
4. Enriches with tasks (withTasks)
5. Enriches with team (withTeam)
6. Returns serialized array
```

---

### 2.4 UC-004: Track Task Progress

**Primary Actor**: Team Member  
**Priority**: Medium

#### Description
Track and update task progress.

#### Basic Flow
```
1. Team member retrieves task
2. Reviews current progress
3. Updates progress (0.0 to 1.0)
4. Updates status (in_progress, completed)
5. Checks isCompleted()
6. Saves updated task
```

---

## 3. Requirements Traceability

| Use Case | Requirements | Test Cases |
|----------|--------------|------------|
| UC-001 | FR-001, FR-003 | TC-001, TC-003 |
| UC-002 | FR-002, FR-004 | TC-002, TC-004 |
| UC-003 | FR-001, FR-003 | TC-001, TC-003 |
| UC-004 | FR-002 | TC-002 |

---

**Document Owner**: KS Fraser Development Team  
**Review Status**: Pending