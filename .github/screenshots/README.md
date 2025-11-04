# PixelCat Screenshots

This directory contains screenshots for the main README.md file.

## Required Screenshots

Please take the following screenshots and save them in this directory:

### 1. homepage.png
- **What to capture**: The landing page at `http://localhost:8000/`
- **Recommended size**: 1920x1080 or similar
- **Focus**: Show the hero section with navy blue background and cat photo
- **Tips**: Make sure to show the "Professional Photography Platform" heading

### 2. dashboard.png
- **What to capture**: The photographer dashboard at `http://localhost:8000/photographer`
- **Recommended size**: 1920x1080 or similar
- **Focus**: Show the welcome widget with photographer illustration and the statistics cards below
- **Tips**:
  - Make sure you have some projects created to show meaningful statistics
  - Show both light and dark mode if possible (or use light mode for consistency)
  - The welcome widget should show "Welcome back, [name]!" with the three action buttons and photographer illustration

### 3. projects.png
- **What to capture**: The projects list at `http://localhost:8000/photographer/resources/projects`
- **Recommended size**: 1920x1080 or similar
- **Focus**: Show the project list table with multiple projects
- **Tips**:
  - Create 3-5 sample projects with different statuses (In Progress, Delivered)
  - Show the table with columns: Title, Category, Status, Photos Count, Views, Downloads

### 4. gallery.png
- **What to capture**: The client-facing gallery (use a share link like `http://localhost:8000/gallery/[token]`)
- **Recommended size**: 1920x1080 or similar
- **Focus**: Show the beautiful photo grid with multiple photos
- **Tips**:
  - Upload some sample photos to a project first
  - Show the grid layout with watermarked photos
  - Optionally capture the lightbox viewer in action

### 5. analytics.png
- **What to capture**: Either the project detail page showing analytics or the statistics overview widget
- **Recommended size**: 1920x1080 or similar
- **Focus**: Show view counts, download counts, and the 7-day trend chart
- **Tips**:
  - Show the statistics cards with numbers
  - Include the line chart showing recent views
  - Show "Most Active Project" stat if visible

## How to Take Screenshots

### On macOS:
- Full screen: `Cmd + Shift + 3`
- Selected area: `Cmd + Shift + 4`
- Specific window: `Cmd + Shift + 4`, then press `Space`, then click window

### On Windows:
- Full screen: `PrtScn` or `Windows + Shift + S`
- Snipping Tool: Search for "Snipping Tool" in Start menu

### On Linux:
- Most distributions: `PrtScn` or `Shift + PrtScn`
- GNOME Screenshot tool
- Flameshot (recommended): Install with `sudo apt install flameshot`

## Image Optimization

After taking screenshots, you can optimize them:

```bash
# Using ImageOptim (macOS)
# Drag and drop images into ImageOptim app

# Using pngquant (Cross-platform)
pngquant --quality=65-80 --ext .png --force *.png

# Using TinyPNG website
# Visit https://tinypng.com/ and upload images
```

## After Adding Screenshots

Once you've added all screenshots to this directory:

1. Verify all images are named correctly:
   - `homepage.png`
   - `dashboard.png`
   - `projects.png`
   - `gallery.png`
   - `analytics.png`

2. Check that images display correctly in the README:
   ```bash
   # View README on GitHub or use a Markdown previewer
   ```

3. **To remove this directory later** (after your README is complete):
   ```bash
   # Delete the entire .github folder
   rm -rf .github

   # Or just delete the screenshots folder
   rm -rf .github/screenshots
   ```

## Notes

- All screenshot references in README.md use relative paths: `.github/screenshots/[name].png`
- If you delete this folder, remember to also update or remove the Screenshots section in README.md
- These screenshots are for documentation purposes only and can be safely deleted without affecting the application
- Consider using placeholder images or Lorem Picsum if you don't want to create real projects for screenshots

## Placeholder Images (Alternative)

If you want to skip taking real screenshots temporarily, you can use placeholder services:

```markdown
<!-- In README.md, replace image paths with: -->
![Homepage](https://via.placeholder.com/1920x1080/1e3a8a/ffffff?text=PixelCat+Homepage)
![Dashboard](https://via.placeholder.com/1920x1080/1e3a8a/ffffff?text=Dashboard)
![Projects](https://via.placeholder.com/1920x1080/1e3a8a/ffffff?text=Projects)
![Gallery](https://via.placeholder.com/1920x1080/1e3a8a/ffffff?text=Gallery)
![Analytics](https://via.placeholder.com/1920x1080/1e3a8a/ffffff?text=Analytics)
```

---

**Remember**: This entire `.github` folder can be safely deleted after you're done with the README!
