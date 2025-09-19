# ☕ Kopiew App – Laravel Project  
---

## 📥 Setup Project  

### 1. Prasyarat  
Pastikan sudah install:  
- *PHP* (minimal versi sesuai composer.json)  
- *Composer*  
- *Node.js & npm*  
- *MySQL / MariaDB*  
- *Git*  

### 2. Clone Repository  
bash
git clone https://github.com/azmiagr/kopiew-app.git
cd kopiew-app


### 3. Install Dependencies
bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install


### 4. Environment Setup
bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate


### 5. Database Configuration
Edit file .env sesuai dengan konfigurasi database Anda:
env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kopiew_db
DB_USERNAME=root
DB_PASSWORD=


### 6. Database Migration & Seeding
bash
# Create database (pastikan database sudah dibuat)
php artisan migrate

# Optional: Jalankan seeder jika ada
php artisan db:seed


### 7. Build Assets
bash
# Development
npm run dev

# Production
npm run build


### 8. Start Development Server
bash
php artisan serve


Project akan berjalan di http://localhost:8000

---

## 🌿 Git Workflow & Branching Strategy

### 1. Create Personal Branch
Setelah clone project, buat branch personal Anda:
bash
# Format: nama-fitur atau nama-developer
git checkout -b nama-anda/fitur-yang-dikerjakan

# Contoh:
git checkout -b cut/auth-system
git checkout -b cut/dashboard-ui


### 2. Working on Your Branch
bash
# Pastikan selalu di branch Anda
git branch  # cek branch aktif

# Lakukan perubahan code, lalu commit
git add .
git commit -m "feat: implementasi login system"

# Push ke remote branch
git push origin nama-anda/fitur-yang-dikerjakan


### 3. Keep Branch Updated
Secara berkala update branch Anda dengan main:
bash
# Pindah ke main dan pull latest changes
git checkout main
git pull origin main

# Kembali ke branch Anda dan merge main
git checkout nama-anda/fitur-yang-dikerjakan
git merge main

# Atau gunakan rebase (opsional)
git rebase main


### 4. Create Pull Request (PR)
1. Push final changes ke branch Anda
2. Buka GitHub repository: https://github.com/azmiagr/kopiew-app
3. Klik *"Compare & pull request"*
4. Isi detail PR dengan format:

markdown
## 📋 Description
Brief description tentang fitur/perubahan yang dibuat

## 🔧 Changes Made
- [ ] Fitur A
- [ ] Bug fix B
- [ ] Update dokumentasi

## 🧪 Testing
- [ ] Manual testing
- [ ] Unit tests (jika ada)

## 📸 Screenshots
(Jika ada perubahan UI)


### 5. PR Review Process
- *Hanya Azmi* yang bisa melakukan merge ke main branch
- PR harus di-review dan approve sebelum merge
- Pastikan tidak ada conflict dengan main branch
- Code harus mengikuti coding standard Laravel

---

## 📋 Branch Naming Convention

Gunakan format berikut untuk nama branch:
- nama-dev/feature-name - untuk fitur baru
- nama-dev/bugfix-name - untuk bug fix
- nama-dev/hotfix-name - untuk hotfix urgent

*Contoh:*
bash
git checkout -b azmi/user-management
git checkout -b rina/coffee-catalog
git checkout -b budi/bugfix-login-error


---

## 📝 Commit Message Convention

Gunakan format conventional commits:
bash
# Format
<type>: <description>

# Contoh
feat: add user authentication system
fix: resolve login redirect issue
docs: update API documentation
style: format code with prettier
refactor: optimize database queries
test: add unit tests for user model


*Types:*
- feat - fitur baru
- fix - bug fix
- docs - dokumentasi
- style - formatting, tidak mengubah logic
- refactor - refactor code
- test - menambah/update tests
- chore - maintenance tasks

---

## ⚠ Important Rules

### 🚫 Yang TIDAK BOLEH dilakukan:
- ❌ Push langsung ke main branch
- ❌ Merge PR sendiri (kecuali Azmi)
- ❌ Force push ke branch yang sudah di-share
- ❌ Commit file .env atau credential

### ✅ Yang HARUS dilakukan:
- ✅ Selalu buat branch baru untuk setiap fitur/task
- ✅ Write clear commit messages
- ✅ Test code sebelum create PR
- ✅ Update branch dengan main secara berkala
- ✅ Resolve conflicts sebelum create PR

---

## 🛠 Development Commands

bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Generate model, controller, migration
php artisan make:model Coffee -mcr
php artisan make:controller CoffeeController --resource

# Database commands
php artisan migrate:fresh --seed
php artisan migrate:rollback

# Asset compilation
npm run watch    # auto-compile saat development
npm run hot      # hot reload


---

## 👥 Team Collaboration

### Daily Workflow:
1. *Morning*: Pull latest main, merge ke branch Anda
2. *Development*: Work on your branch, commit regularly
3. *Before going home*: Push your progress
4. *Weekly*: Create PR untuk review

### Communication:
- Coordinate dengan team sebelum merge main
- Report progress dan blockers
- Ask for help jika stuck dengan Git issues

---

## 🆘 Troubleshooting

### Common Git Issues:

*Merge Conflicts:*
bash
# Jika ada conflict saat merge main
git status  # lihat file yang conflict
# Edit file yang conflict, hapus conflict markers
git add .
git commit -m "resolve merge conflicts"


*Accidentally committed to wrong branch:*
bash
# Pindah ke branch yang benar
git checkout correct-branch-name
git cherry-pick commit-hash


*Need to undo last commit:*
bash
# Soft reset (keep changes)
git reset --soft HEAD~1

# Hard reset (discard changes) - HATI-HATI!
git reset --hard HEAD~1


*Happy Coding! ☕*
