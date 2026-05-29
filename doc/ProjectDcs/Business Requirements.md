# ProjectManagement_UI - Business Requirements

**Document ID:** BR-PMUI-001  
**Module:** ksf_ProjectManagement_UI  
**Version:** 1.0.0  

---

## 1. Overview

ProjectManagement_UI provides the user interface layer for project and task management within FrontAccounting. It includes a dashboard controller, API endpoints, HTML rendering components, and widgets for project visualization including Gantt chart support.

## 2. Purpose

The module delivers a comprehensive project management interface enabling users to create projects, manage tasks, track progress, and visualize timelines through dashboards and Gantt widgets.

## 3. Scope

### 3.1 Core Features

- **Dashboard Interface**
  - Project overview dashboard
  - Task status summary
  - Progress indicators
  - DashboardController for view logic

- **Project Management**
  - Project entity with DTO support
  - Project CRUD operations
  - Start/end date tracking
  - Project status management

- **Task Management**
  - Task entity with DTO support
  - Task assignment
  - Task status tracking
  - Dependencies

- **API Layer**
  - ProjectApiController for REST operations
  - JSON request/response handling
  - CRUD endpoints

- **UI Components**
  - HTMLBuilder for rendering
  - GanttWidget for timeline visualization
  - Superglobals abstraction for request/response

### 3.2 Out of Scope

- Resource allocation
- Time tracking/billing
- File attachments
- Comments system

## 4. Integration Dependencies

| Module | Dependency Type | Purpose |
|--------|-----------------|---------|
| ksf_ProjectManagement | Required | Backend logic |
| ksf_Gantt | Optional | Gantt chart visualization |
| ksf_HRM | Optional | Resource/employee data |

## 5. User Roles

| Role | Permissions |
|------|-------------|
| Project Manager | Full project/task CRUD |
| Team Member | View projects, update own tasks |
| Viewer | Read-only access |

## 6. Acceptance Criteria

- [ ] DashboardController renders dashboard view
- [ ] ProjectApiController handles REST operations
- [ ] ProjectDTO and TaskDTO transfer data correctly
- [ ] GanttWidget displays timeline
- [ ] Request/Response handling works correctly