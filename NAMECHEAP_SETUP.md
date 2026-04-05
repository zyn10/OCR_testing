# Namecheap Deployment Guide - Google Gemini API Integration

This guide explains how to store and use Google Gemini API key securely on Namecheap hosting.

---

## Prerequisites

- Namecheap hosting account (cPanel or Plesk)
- Google Gemini API key (already have)
- Laravel application uploaded to Namecheap

---

## Option 1: Using cPanel (Most Common on Namecheap)

Most Namecheap hosting plans include cPanel. Here's how to add your API key:

### Step 1: Log in to Namecheap cPanel

1. Go to **Namecheap Dashboard** → **hosting** → Click on your hosting account
2. Click **Manage** button
3. Click **cPanel Admin** or **cPanel Login** (usually on the right side)
4. You'll see cPanel interface

### Step 2: Access File Manager

1. In cPanel, find **File Manager**
2. Click it to open
3. In the left sidebar, select your **public_html** folder (or your project root)

### Step 3: Enable Hidden Files

1. Click **Settings** button (top right corner)
2. Check the box: **"Show Hidden Files"**
3. Click **Save**
4. Now you'll see hidden files like `.env`

### Step 4: Edit the .env File

1. **Right-click** on `.env` file
2. Select **Edit** (or double-click to open)
3. Find or add this line:
   ```
   GEMINI_API_KEY=YOUR_API_KEY_HERE
   ```
4. Replace `YOUR_API_KEY_HERE` with your actual Gemini API key

   **Example:**

   ```
   GEMINI_API_KEY=AIzaSyDxX...xK8Z
   ```

5. Click **Save Changes** button
6. Close the editor

---

## Option 2: Using Terminal/SSH (Advanced)

If you have SSH access on Namecheap:

### Step 1: Enable SSH on Namecheap

1. Log in to **Namecheap Account**
2. Go to **hosting** → Click your hosting plan
3. Click **Manage**
4. Look for **SSH Access** section (might be under "Manage Account" or "Advanced")
5. Enable SSH if it's disabled
6. Note down your SSH username and server address

### Step 2: Connect via SSH

```bash
# On Mac/Linux terminal or Windows PowerShell:
ssh username@server.namecheap.com

# Enter your password when prompted
```

Replace:

- `username` = your Namecheap SSH username
- `server.namecheap.com` = your server address (shown in cPanel)

### Step 3: Edit .env File via Terminal

```bash
# Navigate to your Laravel project
cd public_html  # or wherever your Laravel app is

# Edit .env using nano
nano .env

# Add or update this line:
GEMINI_API_KEY=YOUR_API_KEY_HERE

# Save: Press Ctrl + X, then Y, then Enter
```

---

## Option 3: Direct FTP Upload (If you have FTP access)

1. Download your `.env` file from server via FTP client (FileZilla, WinSCP, etc.)
2. Open it in a text editor (Notepad, VS Code, etc.)
3. Add/update:
   ```
   GEMINI_API_KEY=YOUR_ACTUAL_KEY_HERE
   ```
4. Upload back to server in the **public_html** (or root) directory

---

## Step 3: Clear Laravel Cache

After updating `.env`, you need to clear cache:

### Via SSH:

```bash
# SSH into server (see Option 2 above)
php artisan config:cache
php artisan cache:clear
```

### Via cPanel Terminal/Console:

1. In cPanel, find **Terminal** (might be under "Advanced")
2. Run:
   ```bash
   cd public_html
   php artisan config:cache
   php artisan cache:clear
   ```

### Via File Manager (Create a PHP script):

1. Create a file called `clear_cache.php` in your public directory:

   ```php
   <?php
   system('php artisan config:cache');
   system('php artisan cache:clear');
   echo "Cache cleared!";
   ?>
   ```

2. Visit `https://yourdomain.com/clear_cache.php` in your browser
3. Delete the `clear_cache.php` file afterward (security!)

---

## Step 4: Deploy Your Updated Code

### Upload these files to public_html:

- `js/utils.js` (has Gemini function)
- `js/ocr.js` (uses Gemini API)
- `index.html` (has meta tag for API key)
- `js/components.js` (fixed header/footer)

Use:

- **cPanel File Manager** → Upload button
- **FTP Client** (FileZilla, etc.)
- **Git** (if Namecheap supports Git deployments)

---

## Step 5: Test Your Deployment

1. Visit your site: `https://yourdomain.com`
2. Upload an image
3. Check browser console (F12 → Console tab)
4. Look for success or error messages

### Test if API Key is Loading:

In browser console, run:

```javascript
getGeminiApiKey(); // Should return your API key (first few chars)
```

If it returns empty string, API key isn't loading.

---

## Troubleshooting

### Issue: "API key not configured"

**Cause:** .env file not being read by Laravel

**Solution:**

1. **Check .env location:**
   - Should be in Laravel root (same level as artisan file)
   - Not in public_html subdirectory

2. **Clear cache again:**

   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan config:cache
   ```

3. **Check file permissions:**
   ```bash
   chmod 644 .env  # via SSH
   ```

### Issue: Still shows "API key not configured" after clearing cache

**Solution:** Restart PHP or Apache on Namecheap

1. In cPanel, find **MySQL Databases** or **PHP**
2. Look for "Restart Services"
3. Or contact Namecheap support to restart PHP

### Issue: CORS or API errors in console

**Cause:** Usually wrong API key or API key expired

**Solution:**

1. Double-check API key in .env (no extra spaces!)
2. Go to [Google AI Studio](https://aistudio.google.com/app/apikey)
3. Regenerate key if needed
4. Update .env and clear cache

---

## Security Practices for Namecheap

### ✅ DO:

1. **Keep .env outside public_html** if possible
2. **Never commit .env to Git** - it's already in .gitignore
3. **Regenerate API key if exposed**
4. **Check file permissions:**
   ```bash
   chmod 640 .env  # Only owner and group can read (via SSH)
   ```

### ❌ DON'T:

- Don't share your .env file
- Don't put API key in JavaScript files directly
- Don't commit .env to version control
- Don't leave clear_cache.php script on server

---

## Your .env File Should Look Like:

```
APP_NAME=ImageToText
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

GEMINI_API_KEY=AIzaSyDxX...YOUR_ACTUAL_KEY...xK8Z
```

---

## Google Gemini API Key Steps (Quick Reminder)

1. Go to https://aistudio.google.com/app/apikey
2. Sign in with Google
3. Click **Create API Key**
4. Copy the key
5. Paste in `.env` file as shown above

---

## Verify Everything Works

1. ✅ .env file exists in Laravel root
2. ✅ GEMINI_API_KEY=YOUR_KEY is in .env
3. ✅ Cache is cleared (`php artisan config:cache`)
4. ✅ Files uploaded to server
5. ✅ Visit your site and test image upload
6. ✅ Check browser console for errors

---

## Need SSH Access?

If you don't have SSH enabled on Namecheap:

1. Log into Namecheap Account
2. Go to **Hosting** → Select your plan
3. Click **Manage**
4. Look for **SSH Access** settings
5. Toggle to **Enabled**
6. Use the SSH username/host shown there

---

## Support Resources

- **Namecheap Help:** https://www.namecheap.com/support/
- **Google Gemini Docs:** https://ai.google.dev/docs
- **Laravel Docs:** https://laravel.com/docs

---

**You're all set!** Your OCR app now uses Google Gemini API on Namecheap hosting. 🚀
