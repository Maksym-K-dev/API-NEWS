# News Importer

Import news articles from an external API (e.g. [NewsAPI](https://newsapi.org/)) and publish them as WordPress posts automatically or on demand.

**Version:** 1.0.0  
**Author:** Maksym K.

---

## Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher
- An API key from a news API service (e.g. NewsAPI.org)

---

## Installation

### 1. Upload the plugin

- Download or copy the `news-importer` folder into `wp-content/plugins/`.
- Your path should look like: `wp-content/plugins/news-importer/news-importer.php`

### 2. Activate the plugin

- In WordPress admin, go to **Plugins**.
- Find **News Importer** and click **Activate**.

### 3. Get an API key (for NewsAPI)

- Go to [https://newsapi.org/](https://newsapi.org/).
- Sign up and get your free API key.
- You will use this key in the plugin settings.

---

## How to use

### Open settings

1. In the WordPress admin sidebar, click **News Importer** (rss icon).
2. You will see the **News Importer Settings** page.

### Configure settings

| Setting    | Description |
|-----------|-------------|
| **API Key** | Your API key from the news service (e.g. NewsAPI). Required for imports. |
| **Endpoint** | API URL. Default: `https://newsapi.org/v2/everything`. Change only if you use another compatible API. |
| **Count**   | Number of articles to fetch per run (default: 5). |
| **Interval** | How often the automatic import runs: **Every Hour**, **Two times on day**, or **Every day**. |

Click **Save Changes** after editing.

### Run import

- **Automatic:** After saving, the plugin will import according to the **Interval** you chose.
- **Manual:** Click **Import Now (Manual)** on the same settings page to run an import immediately. You will see a message with how many posts were imported, skipped, or had errors.

### View imported posts

Imported items are normal WordPress **Posts**. You can view and edit them under **Posts → All Posts**. Each has:

- Title and content from the article
- Featured image (if the API provided one)
- Category based on the article source
- Original URL stored in post meta (`_source_url`) for deduplication

The plugin does not import the same article twice (duplicates are skipped by URL).

---

## REST API

The plugin exposes a REST endpoint to list imported news:

**Endpoint:** `GET /wp-json/news-importer/v1/news`

**Query parameters:**

| Parameter   | Type   | Description |
|------------|--------|-------------|
| `limit`    | number | Posts per page (1–20, default: 10). |
| `category` | string | Filter by category slug/name. |
| `from`     | string | Only posts after this date (e.g. `2024-01-01`). |

**Example:**

```
https://yoursite.com/wp-json/news-importer/v1/news?limit=5
```

**Example response:**

```json
{
  "count": 5,
  "data": [
    {
      "id": 123,
      "title": "Article title",
      "content": "Excerpt text...",
      "source": "https://example.com/article",
      "date": "2024-02-27T12:00:00+00:00",
      "image": "https://yoursite.com/wp-content/uploads/..."
    }
  ]
}
```

---

## Logs

Import runs are logged to a file. The log path is:

- `wp-content/uploads/news-importer.log`  
  or, if uploads are not available:
- `wp-content/news-importer.log`

Check this file if imports fail or you need to debug.

---

## Deactivation

When you **Deactivate** the plugin:

- Automatic scheduled imports stop (the cron job is removed).
- Your existing posts and settings remain; you can activate again later.

---

## Summary

1. Install the plugin in `wp-content/plugins/news-importer/` and activate it.
2. Open **News Importer** in the admin, enter your **API Key** and options, then **Save Changes**.
3. Use **Import Now (Manual)** for a one-time import or rely on the **Interval** for automatic imports.
4. View posts under **Posts** and use `/wp-json/news-importer/v1/news` to list them via the REST API.
