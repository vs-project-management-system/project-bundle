#Project Management System
##Project Bundle
Project bundle for the PMS System sandbox.

###Entities
- Category
- Project
- Status

###Forms
- CategoryFormType
- ProjectFormType
- StatusFormType

###Routes
route name | path
--- | ---
pms_category_edit | /categories/{slug}/edit
pms_category_index | /categories
pms_category_new | /categories/new
pms_category_remove | /categories/{slug}/remove
pms_category_show | /categories/{slug}

###Repositories
- CategoryRepository
- ProjectRepository
- StatusRepository

###Resources
Action | Template
--- | ---
edit | edit.html.twig
index | index.html.twig
new | new.html.twig
remove | remove.html.twig
show | show.html.twig
