# ProjectManagement_UI - Use Cases

**Document ID:** UC-PMUI-001  
**Module:** ksf_ProjectManagement_UI  
**Version:** 1.0.0  

---

## 1. Use Case Overview

### UC-001: View Project Dashboard

**Description:** Project Manager views project dashboard.

**Primary Flow:**
1. Manager navigates to dashboard URL
2. DashboardController processes request
3. System retrieves project list
4. System renders project cards
5. Manager views dashboard

---

### UC-002: Create Project via API

**Description:** API consumer creates new project.

**Primary Flow:**
1. Consumer sends POST with project JSON
2. ProjectApiController receives request
3. System parses JSON to ProjectDTO
4. System validates project data
5. System saves project
6. System returns 201 with project ID

---

### UC-003: View Gantt Chart

**Description:** User views project timeline.

**Primary Flow:**
1. User navigates to Gantt view
2. GanttWidget retrieves task timeline
3. Widget renders HTML timeline
4. User views project schedule

---

### UC-004: Update Task Status

**Description:** Team member updates task progress.

**Primary Flow:**
1. Member sends PUT with status update
2. API controller receives request
3. System updates task via DTO
4. System persists changes
5. System returns success

## 2. Actors

| Actor | Role |
|-------|------|
| Project Manager | Full CRUD, dashboard access |
| Team Member | Update own tasks |
| API Consumer | External integrations |
| System | Process requests, render views |