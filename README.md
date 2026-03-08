# Museum Audioguide - Open Source

An open-source, multilingual audioguide web application for museums and cultural institutions. Built with Laravel, Filament, and Tailwind CSS.

## Features

- **Multilingual** - Support for Catalan, Spanish, English, and French (easily extensible)
- **Audio guides** - Audio player for each exhibition piece/room
- **Audio descriptions** - Accessibility feature for visually impaired visitors
- **Sign language videos** - Support for embedded sign language videos
- **QR codes** - Generate QR codes for each piece, ready to print and place in your museum
- **Accessibility widget** - High contrast mode, font size controls
- **Admin panel** - Full CRUD management with [Filament](https://filamentphp.com/)
- **Visitor statistics** - Track visits, languages, devices (privacy-friendly, no personal data)
- **PDF documents** - Attach documents and room sheets to exhibitions
- **Responsive** - Mobile-first design, works on any device
- **URL redirects** - Manage redirects from old QR codes or URLs
- **Customizable** - Easy branding configuration via environment variables

## Tech Stack

- **Backend**: Laravel 12, PHP 8.2+
- **Admin Panel**: Filament 3
- **Frontend**: Tailwind CSS 4, Alpine.js
- **Build**: Vite
- **Database**: MySQL / MariaDB / SQLite

## Quick Start

### Prerequisites
- PHP 8.2+ with GD extension
- Composer
- Node.js 18+
- SQLite (development) or MySQL (production)

### Installation

```bash
# Clone the repository
git clone https://github.com/humbertblanco/appmuseus.git
cd appmuseus

# Install dependencies and set up
composer setup
```

This single command will:
1. Install PHP dependencies
2. Copy `.env.example` to `.env`
3. Generate the application key
4. Run database migrations
5. Install Node.js dependencies
6. Build frontend assets

### Start Development Server

```bash
composer dev
```

This starts the Laravel server, queue worker, log viewer, and Vite dev server concurrently.

### Seed Sample Data

```bash
php artisan db:seed
```

Default admin credentials: `admin@example.com` / `password`

**Important**: Change the default password immediately!

### Access the Application

- **Frontend**: http://127.0.0.1:8000
- **Admin Panel**: http://127.0.0.1:8000/admin

## Customization

All branding can be configured via environment variables in your `.env` file:

```env
# Museum name shown in the browser title and admin panel
MUSEUM_NAME="My Museum Audioguide"

# Institution name shown in the footer
MUSEUM_INSTITUTION="City Museum"

# Logo file (place in public/images/)
MUSEUM_LOGO=images/logo.png

# Primary color for the admin panel
# Options: Red, Blue, Green, Amber, Purple, Pink, Indigo, Emerald, etc.
MUSEUM_PRIMARY_COLOR=Blue

# Default language (ca, es, en, fr)
MUSEUM_DEFAULT_LOCALE=ca

# Available languages (comma-separated)
MUSEUM_LOCALES=ca,es,en,fr

# Font for the admin panel (Google Fonts)
MUSEUM_FONT=Montserrat

# Legal notice URL (shown in footer)
MUSEUM_LEGAL_URL=https://example.com/legal

# Footer credit text
MUSEUM_FOOTER_CREDIT="My Organization"
```

### Adding Your Logo

1. Place your logo file in `public/images/`
2. Set `MUSEUM_LOGO=images/your-logo.png` in `.env`

### Adding a New Language

1. Add the language code to `MUSEUM_LOCALES` in `.env`
2. Update the route constraint in `routes/web.php`
3. Add translations in `lang/` directory
4. Add language option in `resources/views/components/language-selector.blade.php`

## Project Structure

```
app/
  Filament/             # Admin panel resources and widgets
  Http/Controllers/     # Frontend controllers
  Http/Middleware/       # Language detection, redirects
  Models/               # Eloquent models
config/
  museum.php            # Museum-specific configuration
database/
  migrations/           # Database schema
  seeders/              # Sample data
resources/
  views/                # Blade templates
  css/                  # Stylesheets
  js/                   # JavaScript
public/
  images/               # Logo and static images
routes/
  web.php               # Application routes
```

## Data Model

- **Exposicio** (Exhibition) - The main entity, contains metadata and translations
- **Peca** (Piece/Room) - Individual stops within an exhibition
- **ExposicioTraduccio** / **PecaTraduccio** - Translations for each language
- **PecaImatge** - Images for each piece
- **PecaMaterial** - Additional materials (PDFs, videos, links)
- **Estadistica** - Visitor statistics
- **Redireccio** - URL redirects

## Production Deployment

See [DEPLOYMENT.md](DEPLOYMENT.md) for detailed deployment instructions.

## License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## Credits

Built with Laravel, Filament, Tailwind CSS, and Alpine.js.
