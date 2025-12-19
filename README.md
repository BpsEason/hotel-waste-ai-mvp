
# 🥘 飯店廚餘 AI 優化系統（Hotel Waste AI Optimizer）

[![Docker](https://img.shields.io/badge/Docker-ready-blue?logo=docker)](https://www.docker.com/)
[![Vue3](https://img.shields.io/badge/Vue-3-green?logo=vue.js)](https://vuejs.org/)
[![Laravel](https://img.shields.io/badge/Laravel-11-red?logo=laravel)](https://laravel.com/)
[![FastAPI](https://img.shields.io/badge/FastAPI-mock-lightgreen?logo=fastapi)](https://fastapi.tiangolo.com/)
[![MariaDB](https://img.shields.io/badge/MariaDB-10.6-blue?logo=mariadb)](https://mariadb.org/)

一個專為飯店廚房設計的 **AI 驅動廚餘管理系統**，透過手機拍照上傳廚餘照片，即時分析浪費食材與重量，並自動產生「明日備料建議」，幫助飯店有效降低食材浪費與採購成本。

---

## 🌟 專案亮點

- **一鍵拍照即分析**：廚房人員只需用手機拍下當日廚餘，系統自動辨識食材類別與估計重量  
- **智能備料建議**：根據歷史廚餘數據，自動建議明日各食材備料量調整比例（例如：雞肉減少 15%）  
- **即時統計儀表板**：總廚餘重量、估計損失金額、上傳筆數一目了然  
- **完整閉環流程**：照片上傳 → AI 分析 → 資料儲存 → 前端即時展示  
- **Docker 一鍵部署**：支援 Windows / macOS / Linux，執行單一腳本即可啟動所有服務  
- **現代化技術棧**：Vue 3 + Tailwind CSS 前端、Laravel API 後端、FastAPI AI Mock、MariaDB 資料庫  

---

## 🚀 快速開始

```bash
# 1. 複製專案
git clone https://github.com/yourname/hotel-waste-ai-mvp.git
cd hotel-waste-ai-mvp

# 2. 建置並啟動所有服務
docker compose up -d --build

# 3. 等待服務啟動（約 2-3 分鐘）

# 4. 開啟瀏覽器訪問
http://localhost
```

就這麼簡單！所有服務（前端、後端、資料庫、AI Mock）都會自動啟動。

---

## 📱 使用方式

1. 打開 [http://localhost](http://localhost)  
2. 點擊「上傳廚餘照片」區域選擇或拖曳照片  
3. 點擊「上傳並 AI 分析」  
4. 系統即時顯示：
   - 辨識出的主要食材與估計重量  
   - 信心度  
   - 明日備料建議  
5. 所有紀錄會自動累積在下方歷史區與統計卡片  

---

## 🏗️ 系統架構

```
前端 (Vue 3 + Vite + Tailwind)
       ↓ (HTTP)
Nginx (反向代理 + 靜態檔案服務)
       ↓
Laravel API (/api/*)
       ↓
FastAPI (AI Mock 服務) ← 未來可替換真實模型
       ↓
MariaDB (儲存廚餘紀錄與圖片路徑)
```

- 圖片儲存於 Laravel `storage/app/public/wastes`  
- 所有 API 路由以 `/api/` 開頭  
- 支援 CORS，未來可輕鬆開發手機 App  

---

## 🔧 技術細節

- **前端**：Vue 3 Composition API + Vite + Tailwind CSS (CDN)  
- **後端 API**：Laravel 11 + Eloquent  
- **AI 服務**：FastAPI（目前為 Mock 隨機結果，方便 Demo）  
- **資料庫**：MariaDB  
- **容器化**：Docker Compose（nginx + php-fpm + python + mariadb + node build）  
- **部署**：單一 bash 腳本自動建置所有服務  

---

## 🎯 商業價值

- 平均可降低 **10-20%** 食材浪費（依據業界案例）  
- 減少過量備料導致的損失  
- 提供數據驅動決策依據  
- 提升廚房管理效率與永續經營形象  

---

## 📈 未來規劃

- [ ] 接入真實電腦視覺模型（Google Vision / 自訓 YOLO）  
- [ ] 手機 App（React Native / Flutter）  
- [ ] 多餐別支援（早餐/午餐/晚餐）  
- [ ] 報表匯出（PDF / Excel）  
- [ ] 使用者權限與多飯店管理  
- [ ] 雲端部署（AWS / Azure）  

---

## 🤝 貢獻與聯絡

歡迎提交 Issue 或 Pull Request！  
有任何問題或合作需求，請聯絡：your.email@example.com  

---

**讓數據說話，用 AI 減少浪費，從今天開始優化你的廚房！**

⭐ 如果覺得這個專案有幫助，請給個 Star 支持一下！
```

這樣排版後，README 在 GitHub 上會更清晰、專業，適合展示給老闆或投資人。你要不要我再幫你加上 **技術徽章（Badges）**，例如 Docker、Vue、Laravel、FastAPI、MariaDB，讓專案首頁更吸睛？
