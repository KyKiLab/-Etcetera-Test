# Real Estate Core Plugin

This plugin adds a custom post type **Real Estate Object**, a custom taxonomy **District**, and includes full support for:

* ACF-powered property fields
* AJAX filter with pagination
* REST API for external integration
* Flexible shortcode and widget usage

---

## ✨ Installation Instructions

1. Clone or download this repository.
2. Move the following folders to your WordPress installation:

```bash
wp-content/themes/understrap/
wp-content/themes/understrap-child/
wp-content/plugins/real-estate-core/
```

3. Install and activate the required plugins:

   * ✅ [Advanced Custom Fields PRO](https://www.advancedcustomfields.com/pro/) (**required**)

4. Activate the theme **Understrap Child**.

5. Activate the plugin **Real Estate Core**.

---

## 📦 Required Plugins

| Plugin         | Purpose                               |
| -------------- | ------------------------------------- |
| ACF PRO        | Custom fields for real estate objects |

---

## 🧱 ACF Field Structure

### Post type: `real_estate`

* `building_name` (text)
* `coordinates` (text)
* `number_of_floors` (select: 1–20)
* `building_type` (radio: Panel / Brick / Foam block)
* `eco_rating` (select: 1–5)
* `main_image` (image)

### Repeater field: `rooms`

Each room contains:

* `room_image` (image)
* `area` (text)
* `room_count` (radio: 1–10)
* `balcony` (radio: Yes / No)
* `bathroom` (radio: Yes / No)

---

## 🖼 Template Integration

To properly display single and archive pages of real estate objects:

1. Copy template files into your active theme:

```bash
plugins/real-estate-core/templates/single-real_estate.php  → yourtheme/single-real_estate.php
plugins/real-estate-core/templates/archive-real_estate.php → yourtheme/archive-real_estate.php
```

---

## 🔍 Filter Integration

You can display a filter form on any page using the shortcode:

```text
[real_estate_filter]
```

Alternatively, use the widget **Real Estate Filter Widget** available under Appearance → Widgets.

Filtered results are loaded via AJAX with pagination (5 results per page).

---

## 📡 REST API

All API endpoints are prefixed with:

```text
/wp-json/realestate/v1/
```

### Available Endpoints

| Method | Endpoint        | Description                     |
| ------ | --------------- | ------------------------------- |
| GET    | `/objects`      | List all objects (with filters) |
| POST   | `/objects`      | Create new object               |
| PUT    | `/objects/{id}` | Update object by ID             |
| DELETE | `/objects/{id}` | Delete object by ID             |

---

### 🔍 GET `/objects` — Example

**Request:**

```http
GET /wp-json/realestate/v1/objects?eco_rating=4
```

**Response:**

```json
[
  {
    "id": 45,
    "title": "Sunrise Plaza",
    "eco_rating": "4",
    "coordinates": "41.4036, 2.1744"
  }
]
```

---

### ✍️ POST/PUT — Request Body Example

```json
{
  "title": "New Building",
  "building_name": "Sunrise Plaza",
  "coordinates": "41.4036, 2.1744",
  "number_of_floors": "12",
  "building_type": "Panel",
  "eco_rating": "4"
}
```

---

### 🗑️ DELETE `/objects/{id}` — Example

```http
DELETE /wp-json/realestate/v1/objects/45
```

**Response:**

```json
{
  "success": true,
  "data": {
    "deleted": true
  }
}
```

---

## 👤 Permissions

* `GET` requests are **public**
* `POST`, `PUT`, and `DELETE` require a user with `edit_posts` capability (Editor or Administrator)

---

## 📲 Hosting Limitation

This site is currently deployed on [infinityfree.com](https://infinityfree.com/), which **does not allow external REST API calls**.
To test the API endpoints, please install this project on a local environment or compatible hosting provider.

---

Developed by Kate Kulikova — for technical test purposes.