# ksf_ProjectManagement_UI - Test Plan

## Document Information

| Field | Value |
|-------|-------|
| **Document ID** | TP-PM-001 |
| **Module** | ksf_ProjectManagement_UI |
| **Project** | Project Management UI |
| **Version** | 1.0.0 |
| **Author** | KS Fraser Development Team |
| **Created** | 2024-01-15 |

---

## 1. Test Scenarios

### 1.1 TC-001: Project Entity

**Test Case ID**: TC-001  
**Class**: `Project`  
**Method**: Getters

#### Test Steps
1. Instantiate Project
2. Assert getProjectId() returns string
3. Assert getName() returns string
4. Assert getStartDate() returns DateTime
5. Assert getEndDate() returns DateTime or null

#### Pass Criteria
- [ ] All getter methods functional
- [ ] Returns correct types
- [ ] Nullable handling correct

---

### 1.2 TC-002: Task Entity

**Test Case ID**: TC-002  
**Class**: `Task`  
**Method**: Getters

#### Test Data
```php
$task = new Task();
$task->name = 'Design Database';
$task->progress = 0.75;
$task->status = 'in_progress';
```

#### Test Steps
1. Instantiate Task
2. Assert getTaskId() returns string
3. Assert getName() returns string
4. Assert getProgress() returns 0.75
5. Assert getPriority() returns 'medium' (default)
6. Assert getStatus() returns 'in_progress'
7. Assert isCompleted() returns false

#### Pass Criteria
- [ ] All getters functional
- [ ] Default values correct
- [ ] isCompleted() logic correct

---

### 1.3 TC-003: ProjectDTO Creation

**Test Case ID**: TC-003  
**Class**: `ProjectDTO`  
**Method**: `fromEntity()`

#### Test Steps
1. Create Project entity with test data
2. Call `ProjectDTO::fromEntity($entity)`
3. Assert DTO created
4. Assert data['id'] matches entity
5. Assert data['name'] matches entity

#### Pass Criteria
- [ ] DTO created from entity
- [ ] Data correctly mapped

---

### 1.4 TC-004: TaskDTO Creation

**Test Case ID**: TC-004  
**Class**: `TaskDTO`  
**Method**: `fromEntity()`

#### Test Steps
1. Create Task entity
2. Call `TaskDTO::fromEntity($entity)`
3. Assert DTO created
4. Call toArray()
5. Assert returns array
6. Assert contains id and name

#### Pass Criteria
- [ ] DTO created correctly
- [ ] toArray() returns valid array

---

### 1.5 TC-005: ProjectDTO Enrichment

**Test Case ID**: TC-005  
**Class**: `ProjectDTO`  
**Method**: `withTasks()`, `withTeam()`

#### Test Steps
1. Create ProjectDTO
2. Create task array
3. Call `withTasks($tasks)`
4. Assert tasks added
5. Create team array
6. Call `withTeam($team)`
7. Assert team added

#### Pass Criteria
- [ ] withTasks() adds tasks
- [ ] withTeam() adds team
- [ ] Methods return self (fluent)

---

### 1.6 TC-006: Task Completion Check

**Test Case ID**: TC-006  
**Class**: `Task`  
**Method**: `isCompleted()`

#### Test Data
| Progress | Status | isCompleted |
|----------|--------|-------------|
| 0.0 | pending | false |
| 0.5 | in_progress | false |
| 1.0 | completed | true |
| 0.0 | completed | true |

#### Test Steps
1. Create Task with progress=1.0, status='completed'
2. Assert isCompleted() returns true
3. Create Task with progress=0.0, status='pending'
4. Assert isCompleted() returns false

#### Pass Criteria
- [ ] Correct completion detection
- [ ] Works with different status values

---

## 2. Test Execution Matrix

| Test Case | Class | Priority | Status |
|-----------|-------|----------|--------|
| TC-001 | Project | High | Pending |
| TC-002 | Task | High | Pending |
| TC-003 | ProjectDTO | High | Pending |
| TC-004 | TaskDTO | High | Pending |
| TC-005 | ProjectDTO | Medium | Pending |
| TC-006 | Task | Medium | Pending |

---

**Document Owner**: KS Fraser Development Team  
**Review Status**: Pending