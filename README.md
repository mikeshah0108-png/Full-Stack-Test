# WPoets Full Stack Developer Test

**A responsive, interactive full-stack web application demonstrating PHP/MySQL CRUD functionality with synchronized tabbed sliders and accordion navigation.**

![DelphianLogic Design](https://img.shields.io/badge/Design-Responsive-brightgreen)
![PHP Backend](https://img.shields.io/badge/Backend-PHP%207.0+-blue)
![MySQL Database](https://img.shields.io/badge/Database-MySQL%205.7+-orange)
![Frontend](https://img.shields.io/badge/Frontend-HTML5%20%7C%20CSS3%20%7C%20jQuery-yellow)

---

## 📋 Overview

This project is a complete implementation of the WPoets Full Stack Developer Test. It showcases:

- **Backend**: Secure PHP with MySQL for CRUD operations
- **Frontend**: Responsive HTML5/CSS3 with jQuery interactions
- **Design**: Desktop tabs & mobile accordion with synchronized sliders
- **Database**: Optimized MySQL schema with seed data
- **Performance**: Optimized queries and smooth animations

---

## 🎨 Design Mockups

### Desktop View (3-Column Layout)
Column 1 shows categories as tabs, Column 2 displays a synchronized slider with controls, and Column 3 shows 1:1 aspect ratio images.

```
┌─────────────────────────────────────────────────────────────┐
│  DelphianLogic in Action                                    │
│  Lorem ipsum dolor sit amet, consectetuer adipiscing elit.  │
├──────────────┬──────────────────────┬──────────────────────┤
│              │                      │                      │
│  Learning ✓  │  Slider with         │  Featured Image      │
│              │  Content & Controls  │  (1:1 Ratio)         │
│  Technology  │                      │                      │
│              │  ◄ Previous | 1/4 ▶  │                      │
│  Communication                      │                      │
│              │  ● ● ● ●             │                      │
└──────────────┴──────────────────────┴──────────────────────┘
```

### Mobile View (Responsive)
Column 1 converts to accordion, Column 2 becomes full-width slider with background images.

```
┌─────────────────────────────┐
│ Learning              ▼     │
│ Description here            │
├─────────────────────────────┤
│ Technology            ▼     │
├─────────────────────────────┤
│         Slider Content      │
│    with Background Image    │
│  ◄  Previous  |  1/4 | ▶   │
│        ● ● ● ●             │
└─────────────────────────────┘
```

---

## 📁 Project Structure

```
Full-Stack-Test/
├── index.php                      # Main entry point
├── config/
│   └── database.php              # Database configuration
├── api/
│   ├── get_categories.php        # Get all categories
│   ├── get_items.php             # Get items by category
│   ├── create_item.php           # Create new item (CRUD)
│   ├── update_item.php           # Update item (CRUD)
│   └── delete_item.php           # Delete item (CRUD)
├── assets/
│   ├── css/
│   │   └── style.css             # Responsive stylesheet
│   ├── js/
│   │   └── script.js             # jQuery interactions & slider sync
│   └── images/
│       ├── arrow-right.svg       # Navigation icon
│       ├── plus-01.svg           # Add/expand icon
│       ├── minus-01.svg          # Remove/collapse icon
│       ├── DL-learning.svg       # Learning category icon
│       ├── DL-technology.svg     # Technology category icon
│       └── DL-communication.svg  # Communication category icon
├── database/
│   └── schema.sql                # MySQL schema & seed data
├── docs/
│   └── Answers to technical questions.md
├── .gitignore
└── README.md
```

---

## ✨ Features

### Desktop Features (≥992px)
✅ **Column 1 - Category Tabs**
- Click tabs to switch between categories
- Active tab highlighting
- Smooth transitions

✅ **Column 2 - Synchronized Slider**
- Previous/Next navigation buttons
- Slide counter (1/4, 2/4, etc.)
- Navigation dots for quick access
- Keyboard navigation support
- Touch/swipe support

✅ **Column 3 - Image Display**
- 1:1 aspect ratio images
- Synchronized with slider
- Image title and description
- Hover zoom effect

### Mobile Features (<992px)
✅ **Responsive Accordion**
- Categories expand/collapse
- Smooth animations
- Touch-friendly

✅ **Full-Width Slider**
- Mobile-optimized controls
- Background image support
- Bottom navigation

### CRUD Operations
✅ **Create**: Add new items with title, description, and image
✅ **Read**: Fetch categories and items via API
✅ **Update**: Modify existing item details
✅ **Delete**: Remove items from database

---

## 🚀 Quick Start

### Prerequisites
- PHP 7.0 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx) or PHP built-in server
- Modern web browser

### Installation

#### 1. Clone the Repository
```bash
git clone https://github.com/mikeshah0108-png/Full-Stack-Test.git
cd Full-Stack-Test
```

#### 2. Create Database
```bash
# Using MySQL command line
mysql -u root -p < database/schema.sql

# Or import through phpMyAdmin
# 1. Create new database: wpoets_test
# 2. Import database/schema.sql
```

#### 3. Configure Database Connection
Edit `config/database.php`:
```php
$servername = "localhost";
$username = "root";              // Your MySQL username
$password = "your_password";     // Your MySQL password
$dbname = "wpoets_test";
```

#### 4. Run Application

**Option A: Using PHP Built-in Server**
```bash
php -S localhost:8000
# Visit: http://localhost:8000
```

**Option B: Using Apache/Nginx**
```bash
# Configure your web server to point to the project root
# Visit: http://your-domain.local
```

---

## 📡 API Endpoints

All endpoints return JSON responses.

### Get All Categories
```http
GET /api/get_categories.php
```
**Response:**
```json
{
  "success": true,
  "message": "Categories retrieved successfully",
  "data": [
    {
      "id": 1,
      "name": "Technology",
      "description": "Latest technology trends",
      "display_order": 1
    }
  ]
}
```

### Get Items by Category
```http
GET /api/get_items.php?category_id=1
```
**Response:**
```json
{
  "success": true,
  "message": "Items retrieved successfully",
  "data": [
    {
      "id": 1,
      "category_id": 1,
      "title": "Web Development",
      "description": "Build modern web applications",
      "image_url": "https://via.placeholder.com/500x500",
      "display_order": 1
    }
  ]
}
```

### Create Item (POST)
```http
POST /api/create_item.php
Content-Type: application/json

{
  "category_id": 1,
  "title": "New Item",
  "description": "Item description",
  "image_url": "https://example.com/image.jpg"
}
```

### Update Item (POST)
```http
POST /api/update_item.php
Content-Type: application/json

{
  "id": 1,
  "title": "Updated Title",
  "description": "Updated description",
  "image_url": "https://example.com/new-image.jpg"
}
```

### Delete Item (POST)
```http
POST /api/delete_item.php
Content-Type: application/json

{
  "id": 1
}
```

---

## 🗄️ Database Schema

### Categories Table
```sql
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_display_order (display_order)
);
```

### Items Table
```sql
CREATE TABLE items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    image_url VARCHAR(500),
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    INDEX idx_category (category_id),
    INDEX idx_display_order (display_order)
);
```

### Seed Data
The database includes 4 categories with 4 items each:
- **Technology**: Web Development, AI, Cloud Computing, Mobile Development
- **Design**: UI Design, UX Design, Typography, Color Theory
- **Business**: Marketing Strategy, Leadership, Finance, Entrepreneurship
- **Lifestyle**: Fitness, Meditation, Nutrition, Travel

---

## 🛠️ Technologies Used

| Component | Technology | Version |
|-----------|-----------|----------|
| **Backend** | PHP | 7.0+ |
| **Database** | MySQL | 5.7+ |
| **Frontend** | HTML5 | - |
| **Styling** | CSS3 | - |
| **Scripting** | JavaScript (ES6) | - |
| **Framework** | jQuery | 3.6+ |
| **CSS Framework** | Bootstrap | 4.6 |
| **Icons** | Font Awesome | 6.0+ |

---

## 📱 Browser Support

| Browser | Desktop | Mobile |
|---------|---------|--------|
| Chrome | ✅ | ✅ |
| Firefox | ✅ | ✅ |
| Safari | ✅ | ✅ |
| Edge | ✅ | ✅ |
| IE 11 | ⚠️ | - |

---

## ⚡ Performance Features

✅ **Frontend Optimizations**
- CSS transforms for smooth animations
- Hardware acceleration with `will-change`
- Lazy image loading
- Minimal DOM manipulation
- Debounced event handlers

✅ **Backend Optimizations**
- Parameterized queries (prevent SQL injection)
- Database indexing on foreign keys
- Efficient query structure
- Connection pooling ready

✅ **Responsive Design**
- Mobile-first approach
- CSS media queries
- Touch-friendly controls
- Optimized for all screen sizes

---

## 📊 Responsive Breakpoints

```css
Desktop:     ≥ 992px (≥lg)
Tablet:      768px - 991px (md)
Mobile:      < 768px (xs, sm)
Small Mobile: < 480px
```

---

## 🔒 Security Features

✅ **Input Validation**
- Server-side validation on all inputs
- Maximum length checks
- Type validation

✅ **Database Security**
- Prepared statements (prevent SQL injection)
- Parameterized queries
- Foreign key constraints

✅ **Output Protection**
- HTML escaping with `htmlspecialchars()`
- UTF-8 charset enforcement
- XSS prevention

---

## 📚 Code Quality

✅ **Best Practices**
- Clean, readable code
- Proper error handling
- Comprehensive comments
- Consistent naming conventions
- DRY (Don't Repeat Yourself) principle
- Modular structure

✅ **Accessibility**
- Semantic HTML
- ARIA labels
- Keyboard navigation
- Focus indicators
- Color contrast compliance

---

## 🚦 Keyboard Navigation

| Key | Action |
|-----|--------|
| `Arrow Right` | Next slide |
| `Arrow Left` | Previous slide |
| `Tab` | Navigate elements |
| `Enter` | Activate buttons/tabs |

---

## 📝 Documentation

For detailed answers to technical questions, see:
- **[Answers to technical questions.md](docs/Answers%20to%20technical%20questions.md)**

Includes:
- Time spent on development
- Future enhancements
- Performance troubleshooting methodology
- Developer self-description in JSON

---

## 🎯 Future Enhancements

### High Priority
- [ ] Admin dashboard for CRUD operations
- [ ] User authentication system
- [ ] Image upload functionality
- [ ] Search and filter options
- [ ] User ratings and comments

### Performance
- [ ] Redis caching
- [ ] Image CDN integration
- [ ] Database query optimization
- [ ] Minification and bundling
- [ ] Pagination implementation

### Testing
- [ ] PHPUnit tests
- [ ] Jest frontend tests
- [ ] E2E tests with Selenium
- [ ] Performance testing

### Infrastructure
- [ ] Docker containerization
- [ ] CI/CD pipeline (GitHub Actions)
- [ ] Error tracking (Sentry)
- [ ] API documentation (Swagger)

---

## 🐛 Troubleshooting

### Database Connection Error
```
Error: Database connection failed
```
**Solution:**
- Check MySQL is running
- Verify credentials in `config/database.php`
- Ensure database `wpoets_test` exists
- Check user has proper permissions

### Categories Not Loading
```
Error: No categories found
```
**Solution:**
- Run `database/schema.sql` to seed data
- Verify database connection
- Check browser console for errors

### Slider Not Syncing
**Solution:**
- Clear browser cache
- Check JavaScript console for errors
- Verify jQuery is loaded
- Check CSS transforms are supported

---

## 📄 License

MIT License - Feel free to use this project for learning and development.

---

## 👤 Author

**WPoets Developer Test**
- Repository: [mikeshah0108-png/Full-Stack-Test](https://github.com/mikeshah0108-png/Full-Stack-Test)
- Created: 2024

---

## 📞 Support

For issues, questions, or suggestions:
1. Check the troubleshooting section
2. Review the technical questions document
3. Check browser console for errors
4. Verify all prerequisites are installed

---

## ✅ Checklist

- [x] PHP/MySQL CRUD functionality
- [x] Responsive HTML5/CSS3 design
- [x] jQuery slider synchronization
- [x] Bootstrap integration
- [x] Desktop tabs layout
- [x] Mobile accordion layout
- [x] Database schema and seed data
- [x] API endpoints
- [x] Technical documentation
- [x] Performance optimization
- [x] Security measures
- [x] Accessibility features

---

**Made with ❤️ for WPoets**
