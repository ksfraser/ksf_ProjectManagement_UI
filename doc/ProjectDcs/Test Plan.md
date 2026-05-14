# ProjectManagement_UI - Test Plan

**Document ID:** TP-PMUI-001  
**Module:** ksf_ProjectManagement_UI  
**Version:** 1.0.0  

---

## 1. Test Scope

- Dashboard rendering
- API controller operations
- DTO data transfer
- Gantt widget display

## 2. Test Cases

### 2.1 Dashboard Tests

| ID | Test | Test Data | Pass Criteria |
|---------|-----------|-----------|---------------|
| TC-001 | testDashboardController_Render | valid session | Dashboard rendered |
| TC-002 | testDashboardController_GetProjects | with projects | Projects listed |
| TC-003 | testDashboardController_GetTaskSummary | with tasks | Summary calculated |

### 2.2 API Tests

| ID | Test | Test Data | Pass Criteria |
|---------|-----------|-----------|---------------|
| TC-010 | testProjectApi_List | with projects | JSON array returned |
| TC-011 | testProjectApi_Get | valid ID | Project object returned |
| TC-012 | testProjectApi_Get_NotFound | invalid ID | 404 returned |
| TC-013 | testProjectApi_Create | valid data | 201 returned, ID present |
| TC-014 | testProjectApi_Update | valid data | 200 returned |
| TC-015 | testProjectApi_Delete | valid ID | 200 returned |

### 2.3 Widget Tests

| ID | Test | Test Data | Pass Criteria |
|---------|-----------|-----------|---------------|
| TC-020 | testGanttWidget_Render | with tasks | HTML timeline rendered |
| TC-021 | testGanttWidget_SetTimeline | task array | Timeline set correctly |

### 2.4 DTO Tests

| ID | Test | Test Data | Pass Criteria |
|---------|-----------|-----------|---------------|
| TC-030 | testProjectDTO_Serialization | valid project | JSON output |
| TC-031 | testTaskDTO_Serialization | valid task | JSON output |