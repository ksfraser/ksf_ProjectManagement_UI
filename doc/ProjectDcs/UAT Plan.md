# ProjectManagement_UI - UAT Plan

**Document ID:** UAT-PMUI-001  
**Module:** ksf_ProjectManagement_UI  
**Version:** 1.0.0  

---

## 1. UAT Objectives

Verify that:
1. Dashboard displays project information correctly
2. API endpoints respond correctly
3. DTOs transfer data properly
4. Gantt widget renders timeline

## 2. Test Scenarios

| Scenario | Expected | Tester |
|----------|----------|--------|
| UAT-001: View dashboard | Project cards displayed | Project Manager |
| UAT-002: List projects via API | JSON array | API Consumer |
| UAT-003: Create project | 201 response | API Consumer |
| UAT-004: View Gantt chart | Timeline rendered | Project Manager |
| UAT-005: Update task | Changes persisted | Team Member |

## 3. Sign-Off

| Role | Name | Date |
|------|------|------|
| Project Manager | | |
| API Consumer | | |
| QA Lead | | |