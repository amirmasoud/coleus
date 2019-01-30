# Overview

---

- [Add Content](#add-content)
- [Add Paragraph](#add-paragraph)
- [Add Permissions](#add-permissions)
- [Add Roles](#add-roles)

<a name="add-content"></a>
## Add Content

Add content to a book.

```
add:content {path : The path to dataset}
    {book : The book ID to content add to}
    {parent? : The parent of the content}
    {--T|title= : The title of the content}
    {--R|refresh : Refresh book\'s content before import}
    {--C|count : Count title on indexing}
    {--P|persian : Persian numbers}
    {--H|header=* : Subheader titles}
    {--A|append : Append m1 to titles}
    {--D|delimiter= : Delimiter for append and title, default is ": "}
```

<a name="add-paragraph"></a>
## Add Paragraph

Add paragraph from pages table.

```
add:paragraphs
```

<a name="add-permission"></a>
## Add Permissions

Add permissions for given resource, added permissions includes browse, view, create, update, delete, restore and force delete

```
add:permissions {resource}
```

<a name="add-roles"></a>
## Add Roles

Add default roles to database (if not added already).

```
add:roles
```
