# Clean Architecture Folder Layout (Gradual Migration)

## Presentation Layer
- `Presentation/Admin/Pages`: admin page endpoints (CRUD + dashboards)
- `Presentation/Admin/Handlers`: form handlers (`*_logic.php`)
- `Presentation/Public/Pages`: public pages
- `Presentation/Public/Story`: story-related public pages
- `Presentation/Public/Hero`: hero-related public pages
- `Presentation/Public/Auth`: auth HTML pages

## Backward Compatibility
Legacy root-level files in `Graduation/` now act as compatibility entry points and load the new file location.
This keeps existing links/forms working while the project is reorganized.
