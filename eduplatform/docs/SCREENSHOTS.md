# Screenshots Guide

Adding screenshots to your GitHub repository makes it more attractive and helps users understand what your project looks like.

## Recommended Screenshots

### 1. Landing Page
- **File**: `screenshots/homepage.png`
- **What to capture**: The main index.html page
- **URL**: `http://localhost/eduplatform/`

### 2. Login Page
- **File**: `screenshots/login.png`
- **What to capture**: The login form
- **URL**: `http://localhost/eduplatform/auth/login.html`

### 3. Admin Dashboard
- **File**: `screenshots/admin-dashboard.png`
- **What to capture**: Admin dashboard with course management
- **Login as**: admin@gmail.com / admin

### 4. Teacher Dashboard
- **File**: `screenshots/teacher-dashboard.png`
- **What to capture**: Teacher view with enrollments and pricing
- **Login as**: teacher@gmail.com / teacher

### 5. Student Dashboard
- **File**: `screenshots/student-dashboard.png`
- **What to capture**: Student course enrollment page
- **Login as**: student@gmail.com / student

### 6. Course List
- **File**: `screenshots/courses.png`
- **What to capture**: Available courses listing

### 7. Enrollment Process
- **File**: `screenshots/enrollment.png`
- **What to capture**: Student enrolling in a course

### 8. Pricing Management
- **File**: `screenshots/pricing.png`
- **What to capture**: Teacher setting price for enrollment

## How to Take Screenshots

### Windows
1. Press `Windows + Shift + S`
2. Select area to capture
3. Save from clipboard

### macOS
1. Press `Cmd + Shift + 4`
2. Select area to capture
3. File saves to Desktop

### Linux
1. Use `Screenshot` tool or
2. Press `PrtScn` key

## Creating the Screenshots Directory

```bash
mkdir screenshots
cd screenshots
# Add your screenshots here
```

## Adding Screenshots to README

After taking screenshots, update your README.md:

```markdown
## 📸 Screenshots

### Homepage
![Homepage](screenshots/homepage.png)

### Admin Dashboard
![Admin Dashboard](screenshots/admin-dashboard.png)

### Student Enrollment
![Student Enrollment](screenshots/enrollment.png)

### Teacher Pricing
![Teacher Pricing](screenshots/pricing.png)
```

## Screenshot Best Practices

1. **Resolution**: Use at least 1280x720 for clarity
2. **Format**: PNG for screenshots (better quality than JPG)
3. **Size**: Compress large images (use tinypng.com)
4. **Consistency**: Use the same browser/window size for all
5. **Clean**: Hide personal information or test data
6. **Annotate**: Add arrows or text if needed (optional)

## Optional: Create a Demo GIF

To show functionality in action:

1. **Use a screen recorder**:
   - Windows: Xbox Game Bar (Win + G)
   - Mac: QuickTime Player
   - Cross-platform: OBS Studio

2. **Convert to GIF**:
   - Use [ezgif.com](https://ezgif.com)
   - Or [gifski](https://gif.ski)

3. **Add to README**:
   ```markdown
   ## 🎬 Demo
   ![Demo](screenshots/demo.gif)
   ```

## Git Commands for Screenshots

```bash
# Add screenshots folder
git add screenshots/

# Commit
git commit -m "Add project screenshots"

# Push to GitHub
git push origin main
```

## Example README Section with Screenshots

```markdown
## 📸 Preview

<div align="center">

### 🏠 Homepage
![Homepage](screenshots/homepage.png)

### 👨‍💼 Admin Dashboard
![Admin](screenshots/admin-dashboard.png)

### 👨‍🏫 Teacher Dashboard
![Teacher](screenshots/teacher-dashboard.png)

### 👨‍🎓 Student Portal
![Student](screenshots/student-dashboard.png)

</div>
```

## Creating a Project Banner (Optional)

Use tools like [Canva](https://canva.com) to create a banner:
- Size: 1280 x 640px
- Include: Project name, tagline, key features
- Save as: `screenshots/banner.png`
- Add to README top:
  ```markdown
  ![EduPlatform Banner](screenshots/banner.png)
  ```

## Notes

- Screenshots are optional but highly recommended
- They significantly improve your project's presentation
- First impressions matter on GitHub!
- Keep screenshots updated when UI changes

---

**Tip**: Take screenshots before deploying to production to show clean, demo data instead of real user information.
