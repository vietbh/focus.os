# focus.os
# Focus OS Dark Theme Design Rules

## Design Philosophy

Focus OS Dark Theme follows:

* Apple Notes
* Things 3
* Linear

Goals:

* Comfortable for long-term use
* Soft contrast
* Minimal eye strain
* Mobile-first
* Consistent across all screens

---

# Color Palette

## Light Theme

### Background

```text
bg-slate-50
```

### Surface

```text
bg-white
```

### Border

```text
border-slate-200
```

### Primary Text

```text
text-slate-900
```

### Secondary Text

```text
text-slate-500
```

### Muted Text

```text
text-slate-400
```

---

## Dark Theme

### Background

```text
bg-slate-950
```

### Surface

```text
bg-slate-900
```

### Border

```text
border-slate-800
```

### Primary Text

```text
text-slate-100
```

### Secondary Text

```text
text-slate-400
```

### Muted Text

```text
text-slate-500
```

---

# Standard Mapping Rules

## Background

```twig
bg-slate-50
dark:bg-slate-950
```

---

## Surface

```twig
bg-white
dark:bg-slate-900
```

---

## Border

```twig
border-slate-200
dark:border-slate-800
```

---

## Primary Text

```twig
text-slate-900
dark:text-slate-100
```

---

## Secondary Text

```twig
text-slate-500
dark:text-slate-400
```

---

## Muted Text

```twig
text-slate-400
dark:text-slate-500
```

---

# Components

## Page

```twig
min-h-screen

bg-slate-50
dark:bg-slate-950

text-slate-900
dark:text-slate-100
```

---

## Card

```twig
rounded-3xl

border
border-slate-200
dark:border-slate-800

bg-white
dark:bg-slate-900

shadow-sm
```

---

## Input

```twig
w-full

rounded-2xl

border
border-slate-300
dark:border-slate-700

bg-white
dark:bg-slate-900

text-slate-900
dark:text-slate-100
```

---

## Textarea

```twig
w-full

rounded-2xl

border
border-slate-300
dark:border-slate-700

bg-white
dark:bg-slate-900

text-slate-900
dark:text-slate-100
```

---

## Select

```twig
w-full

rounded-2xl

border
border-slate-300
dark:border-slate-700

bg-white
dark:bg-slate-900

text-slate-900
dark:text-slate-100
```

---

## Bottom Navigation

Container

```twig
bg-white
dark:bg-slate-900

border-t

border-slate-200
dark:border-slate-800
```

### Active Item

```twig
text-slate-900
dark:text-white
```

### Inactive Item

```twig
text-slate-500
dark:text-slate-400
```

---

## Sheet

```twig
bg-white
dark:bg-slate-900

border-slate-200
dark:border-slate-800
```

### Handle

```twig
bg-slate-300
dark:bg-slate-700
```

---

## Modal

```twig
bg-white
dark:bg-slate-900
```

### Overlay

```twig
bg-black/40
```

---

## Badge

### Neutral

```twig
bg-slate-100
dark:bg-slate-800

text-slate-700
dark:text-slate-300
```

---

## Button

### Primary

```twig
bg-slate-900
text-white
```

### Secondary

```twig
bg-slate-100
dark:bg-slate-800

text-slate-700
dark:text-slate-200
```

### Danger

```twig
border-red-200
dark:border-red-900

text-red-600
dark:text-red-400
```

---

# Theme Controller Rules

Theme values:

```text
system
light
dark
```

---

## Light

```html
<html data-theme="light">
```

No `dark` class.

---

## Dark

```html
<html
    data-theme="dark"
    class="dark"
>
```

---

## System

Use browser preference:

```javascript
window.matchMedia(
    '(prefers-color-scheme: dark)'
)
```

If dark:

```html
<html class="dark">
```

Otherwise:

```html
<html>
```

---

# Forbidden

Do NOT use:

```twig
dark:bg-black
```

```twig
dark:bg-gray-900
```

```twig
dark:bg-zinc-900
```

```twig
text-white
```

for normal page text.

---

# Official Palette

Only use:

```text
slate-50
slate-100
slate-200
slate-300
slate-400
slate-500
slate-700
slate-800
slate-900
slate-950
```

for all dark theme surfaces and typography.

Do not mix:

```text
gray
neutral
zinc
stone
```

inside the same application.
