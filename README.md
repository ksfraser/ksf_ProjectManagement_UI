# ksf_ProjectManagement_UI

Standalone Project Management UI for `ksfraser/ksf-project-management`.

Can be used:
- As a standalone web app (separate from FrontAccounting)
- Embedded in FA via `ksf_FA_ProjectManagement`
- Headless API for SPA/mobile consumption

## Architecture

```
ksf_ProjectManagement_UI/
├── src/
│   ├── API/           # REST API controllers (JSON)
│   ├── UI/            # UI controllers (server-rendered HTML)
│   └── Widget/        # Reusable UI widgets (Gantt, Calendar, Kanban)
├── templates/         # PHP templates (no framework dependency)
├── assets/
│   ├── css/           # Stylesheets
│   └── js/            # JavaScript (vanilla JS + libs)
└── doc/
```

## Features

- [x] Project Dashboard
- [x] Project CRUD
- [x] Task CRUD with hierarchy
- [x] Team assignment
- [x] File attachments
- [ ] Gantt chart visualization
- [ ] Kanban board
- [ ] Calendar view
- [ ] Time tracking integration (ksf_TimeTracking)
- [ ] Notifications

## Integration with ksf_* packages

| Package | Integration |
|---------|-------------|
| `ksfraser/ksf-project-management` | Core logic layer |
| `ksfraser/html` | HTML generation helpers |
| `ksfraser/superglobals` | Request/response handling |
| `ksfraser/file` | File upload/download |

## Gantt Chart

Uses [Frappe Gantt](https://github.com/frappe/gantt) for client-side rendering.
PHP generates the JSON data structure, JS renders the chart.

## License

GPL-3.0