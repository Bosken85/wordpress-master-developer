# WordPress Master Developer Theme - Build Instructions

## 🚨 IMPORTANT: This Theme Requires a Build Process

This WordPress theme uses **npm packages** and **modular architecture** for maintainability and performance. You **MUST** run the build process after installation.

## 📋 Prerequisites

- **Node.js 16+** and **npm**
- **Command line access** to the theme directory
- **WordPress 5.0+** and **PHP 7.4+**

## 🚀 Quick Start

### 1. Install Dependencies
```bash
cd /path/to/wp-content/themes/wordpress-master-developer/
npm install
```

### 2. Build Assets
```bash
npm run build
```

### 3. Activate Theme
Activate the theme in WordPress admin dashboard.

## 📦 Available Build Commands

| Command | Description | Use Case |
|---------|-------------|----------|
| `npm install` | Install all dependencies | First time setup |
| `npm run build` | Production build (minified) | Deployment |
| `npm run dev` | Development build + watch | Development |
| `npm run build:css` | Build CSS only | CSS changes |
| `npm run build:js` | Build JavaScript only | JS changes |
| `npm run watch` | Watch all files | Active development |
| `npm run clean` | Clean built assets | Fresh start |

## 🔧 Development Workflow

### For Active Development
```bash
# Start development mode (auto-rebuilds on file changes)
npm run dev

# Edit files in src/ directory
# - src/scss/ for styles
# - src/js/ for JavaScript

# Files automatically compile to assets/ directory
```

### For Production Deployment
```bash
# Build optimized assets
npm run build

# Upload theme to production server
# Activate in WordPress admin
```

## 📁 File Structure Explained

```
wordpress-master-developer/
├── 📂 src/                    # SOURCE FILES (edit these)
│   ├── 📂 scss/               # Modular SCSS files
│   │   ├── 📂 base/           # Variables, typography, reset
│   │   ├── 📂 components/     # Navigation, buttons, cards
│   │   ├── 📂 layout/         # Header, footer, grid
│   │   ├── 📂 pages/          # Page-specific styles
│   │   ├── 📂 utilities/      # Helper classes
│   │   └── 📄 main.scss       # Main SCSS file (imports all)
│   └── 📂 js/                 # Modular JavaScript files
│       ├── 📂 modules/        # Individual JS modules
│       └── 📄 main.js         # Main JS file (imports all)
├── 📂 assets/                 # BUILT FILES (generated)
│   ├── 📂 css/
│   │   └── 📄 main.css        # Compiled CSS (Bootstrap + custom)
│   ├── 📂 js/
│   │   ├── 📄 main.js         # Compiled JavaScript bundle
│   │   └── 📄 navigation.js   # Navigation module
│   └── 📂 images/             # Theme images (copied from React theme)
├── 📄 package.json            # npm dependencies
├── 📄 webpack.config.js       # Build configuration
└── 📄 functions.php           # WordPress theme functions
```

## 🎨 Customization Guide

### Editing Styles (CSS/SCSS)

1. **Edit SCSS files in `src/scss/`:**
   ```scss
   // src/scss/base/_variables.scss
   :root {
     --color-primary: #1e40af;    // Change primary color
     --color-secondary: #f97316;  // Change accent color
   }
   ```

2. **Build CSS:**
   ```bash
   npm run build:css
   ```

### Editing JavaScript

1. **Edit JS files in `src/js/`:**
   ```javascript
   // src/js/modules/navigation.js
   // Modify navigation behavior
   ```

2. **Build JavaScript:**
   ```bash
   npm run build:js
   ```

### Bootstrap Customization

1. **Edit Bootstrap variables in `src/scss/main.scss`:**
   ```scss
   // Custom Bootstrap variable overrides
   $primary: #1e40af;
   $secondary: #f97316;
   $font-family-sans-serif: 'Inter', sans-serif;
   
   // Import Bootstrap components
   @import "~bootstrap/scss/functions";
   @import "~bootstrap/scss/variables";
   // ... more imports
   ```

2. **Add/remove Bootstrap components:**
   ```scss
   // Only import what you need for smaller file size
   @import "~bootstrap/scss/grid";
   @import "~bootstrap/scss/buttons";
   @import "~bootstrap/scss/navbar";
   ```

## 🔄 Updating Dependencies

### Update Bootstrap
```bash
npm update bootstrap
npm run build
```

### Update All Dependencies
```bash
npm update
npm run build
```

### Add New Dependencies
```bash
npm install package-name
# Update webpack.config.js if needed
npm run build
```

## 🛠️ Troubleshooting

### ❌ "Assets not found" Error

**Problem:** WordPress shows missing CSS/JS files
**Solution:**
```bash
cd /path/to/theme/
npm install
npm run build
```

### ❌ Build Fails

**Problem:** npm run build shows errors
**Solution:**
```bash
# Clear cache and reinstall
rm -rf node_modules package-lock.json
npm install
npm run build
```

### ❌ Styles Not Updating

**Problem:** Changes not appearing on website
**Solution:**
```bash
# Force rebuild
npm run clean
npm run build

# Clear WordPress cache if using caching plugin
```

### ❌ Node.js Version Issues

**Problem:** Build fails with Node.js errors
**Solution:**
```bash
# Check Node.js version (should be 16+)
node --version

# Update Node.js if needed
# Then reinstall dependencies
npm install
```

## 🎯 Production Checklist

Before deploying to production:

- [ ] Run `npm run build` (not `npm run dev`)
- [ ] Test theme functionality
- [ ] Check all pages load correctly
- [ ] Verify mobile navigation works
- [ ] Test contact forms
- [ ] Check performance with tools like GTmetrix

## 📊 Performance Notes

### Development vs Production

| Mode | File Size | Performance | Use Case |
|------|-----------|-------------|----------|
| Development | Larger files | Slower | Local development |
| Production | Minified | Optimized | Live website |

### Build Output Sizes

- **CSS**: ~50KB (includes Bootstrap + custom styles)
- **JavaScript**: ~30KB (includes Bootstrap JS + custom modules)
- **Images**: 4.2MB (high-quality assets from React theme)

## 🔒 Security Notes

- **Never commit `node_modules/`** to version control
- **Always run production builds** for live sites
- **Keep dependencies updated** for security patches
- **Use `.gitignore`** to exclude build artifacts

## 📞 Support

### Common Issues
1. **Build errors** - Check Node.js version and reinstall dependencies
2. **Missing styles** - Ensure `npm run build` completed successfully
3. **JavaScript errors** - Check browser console for specific errors

### Getting Help
- Check this documentation first
- Review webpack and npm documentation
- Check WordPress Codex for WordPress-specific issues
- Review Bootstrap documentation for styling questions

---

## 🎉 Success!

Once you've completed the build process, your WordPress Master Developer theme will have:

✅ **Bootstrap 5.3.8** integrated and customizable  
✅ **Modular SCSS** for easy maintenance  
✅ **Modern JavaScript** with ES6+ features  
✅ **TrueHorizon.ai navigation** with full-screen mobile menu  
✅ **Performance optimized** assets  
✅ **All React theme assets** properly included  

**Remember:** Always run `npm run build` after making changes to `src/` files!
