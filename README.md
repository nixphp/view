<div align="center" style="text-align: center;">

![Logo](https://nixphp.github.io/docs/assets/nixphp-logo-small-square.png)

[![NixPHP View Plugin](https://github.com/nixphp/view/actions/workflows/php.yml/badge.svg)](https://github.com/nixphp/view/actions/workflows/php.yml)

</div>

[← Back to NixPHP](https://github.com/nixphp/framework)

---

# nixphp/view

> **A lightweight, native PHP templating system — with layout inheritance and block support.**

This plugin brings a clean, minimal templating system to your NixPHP application.
It lets you define base layouts, use content blocks, and safely output user data — all with pure PHP.

> 🧩 Part of the official NixPHP plugin collection.
> Install it when you need structured HTML rendering — without external engines like Twig or Blade.

---

## 📦 Features

* ✅ Define layouts and reuse views via `setLayout()` and `block()/endblock()`
* ✅ Render views with `view('template', [...])`
* ✅ Return response objects with `render('template', [...])`
* ✅ Safe output via `s()` (escape helper)
* ✅ Fully native PHP – no new syntax or templating engine required

---

## 📥 Installation

```bash
composer require nixphp/view
```

The plugin auto-registers itself and adds the `view()`, `render()` and `s()` helpers globally.

---

## 🚀 Usage

### 🧱 Rendering views

Use the `view()` helper to render a template and return the result as a **string**:

```php
$content = view('hello', ['name' => 'World']);
```

This is useful if you want to process or wrap the HTML manually.

Use the `render()` helper to return a **response object** instead (e.g. in your controller):

```php
return render('hello', ['name' => 'World']);
```

This renders the view **and wraps it in a proper response**, ready to be returned from any route handler.

---

### 🧩 Layouts & Blocks

Use `setLayout()` to define a parent layout, and `block()/endblock()` to inject content:

#### `app/views/page.phtml`

```php
<?php $this->setLayout('layout') ?>

<?php $this->block('content') ?>
    <h1>Hello <?= s($name) ?>!</h1>
<?php $this->endblock('content') ?>
```

#### `app/views/layout.phtml`

```php
<!doctype html>
<html>
<head>
    <title>My App</title>
</head>
<body>
    <?= $this->renderBlock('content') ?>
</body>
</html>
```

---

### 🛡️ Escape output

Use the `s()` helper to sanitize output (HTML-escaped):

```php
<p><?= s($userInput) ?></p>
```

---

## 🔁 Helper Comparison

| Helper     | Returns             | Use case                                |
| ---------- | ------------------- | --------------------------------------- |
| `view()`   | `string`            | For manual output or further processing |
| `render()` | `ResponseInterface` | Ideal for controller return values      |

---

## 🔍 Internals

* `view()` resolves and loads `.phtml` templates from `/app/views/` or any registered view path.
* `setLayout()` nests the rendered content into a wrapper view.
* Blocks are buffered and stored internally until rendered.

---

## ✅ Requirements

* `nixphp/framework` >= 1.0

---

## 📄 License

MIT License.