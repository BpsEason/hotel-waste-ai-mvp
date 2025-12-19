<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 to-green-50">
    <!-- Hero 區 -->
    <div class="text-center pt-12 pb-8 px-6">
      <h1 class="text-5xl md:text-6xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-green-600 mb-4">
        飯店廚餘 AI 優化系統
      </h1>
      <p class="text-xl text-gray-600 max-w-2xl mx-auto">
        用 AI 分析廚餘照片，精準掌握浪費，自動建議明日備料量，幫助飯店降低成本、減少浪費
      </p>
    </div>

    <!-- 上傳區 -->
    <div class="max-w-4xl mx-auto px-6 mb-16">
      <div class="bg-white rounded-2xl shadow-2xl p-10">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">上傳今日廚餘照片</h2>

        <!-- 拖曳上傳 + 預覽 -->
        <div
          @drop.prevent="onDrop"
          @dragover.prevent
          @dragenter.prevent
          class="border-4 border-dashed border-gray-300 rounded-2xl p-12 text-center cursor-pointer transition hover:border-blue-500 bg-gray-50"
        >
          <input
            type="file"
            accept="image/*"
            @change="file = $event.target.files[0]"
            class="hidden"
            ref="fileInput"
          />
          <div @click="$refs.fileInput.click()">
            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
            </svg>
            <p class="text-xl text-gray-600 mb-2">點擊或拖曳照片到這裡</p>
            <p class="text-sm text-gray-500">支援 JPG、PNG 格式</p>
          </div>

          <!-- 圖片預覽 -->
          <div v-if="previewUrl" class="mt-8">
            <img :src="previewUrl" class="max-h-96 mx-auto rounded-xl shadow-lg" />
          </div>
        </div>

        <button
          @click="upload"
          :disabled="!file || loading"
          class="mt-8 w-full py-5 bg-gradient-to-r from-blue-600 to-green-600 text-white text-xl font-bold rounded-xl hover:from-blue-700 hover:to-green-700 disabled:opacity-60 transition shadow-lg"
        >
          <span v-if="loading">AI 分析中...</span>
          <span v-else>立即 AI 分析</span>
        </button>

        <!-- 分析結果 -->
        <transition name="fade">
          <div v-if="result" class="mt-12 p-8 bg-gradient-to-r from-green-50 to-blue-50 rounded-2xl border-2 border-green-200">
            <div class="text-center mb-6">
              <svg class="mx-auto h-20 w-20 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4a1 1 0 00-1.414-1.414z" clip-rule="evenodd" />
              </svg>
              <p class="text-3xl font-bold text-green-800 mt-4">分析完成！</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
              <div class="bg-white p-6 rounded-xl shadow">
                <p class="text-gray-600 mb-2">主要食材</p>
                <p class="text-2xl font-bold text-blue-600">{{ result.data.items[0].food_category }}</p>
              </div>
              <div class="bg-white p-6 rounded-xl shadow">
                <p class="text-gray-600 mb-2">估計重量</p>
                <p class="text-2xl font-bold text-orange-600">{{ result.data.total_estimated_weight }} kg</p>
              </div>
              <div class="bg-white p-6 rounded-xl shadow">
                <p class="text-gray-600 mb-2">信心度</p>
                <p class="text-2xl font-bold text-green-600">{{ (result.data.items[0].confidence * 100).toFixed(0) }}%</p>
              </div>
            </div>
            <div class="mt-8 bg-yellow-50 p-6 rounded-xl border-2 border-yellow-300">
              <p class="text-xl font-bold text-yellow-800 text-center">{{ result.data.suggestion }}</p>
              <p class="text-lg text-yellow-700 text-center mt-3">{{ result.data.recommended_preparation }}</p>
            </div>
          </div>
        </transition>
      </div>
    </div>

    <!-- 統計卡片 -->
    <div class="max-w-6xl mx-auto px-6 mb-16">
      <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">今日統計概覽</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-gradient-to-br from-blue-500 to-blue-700 text-white p-10 rounded-2xl shadow-2xl text-center transform hover:scale-105 transition">
          <svg class="mx-auto h-16 w-16 mb-4 opacity-90" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <p class="text-5xl font-bold">{{ stats.total_weight }}</p>
          <p class="text-2xl mt-4 opacity-90">總廚餘重量 (kg)</p>
        </div>
        <div class="bg-gradient-to-br from-red-500 to-red-700 text-white p-10 rounded-2xl shadow-2xl text-center transform hover:scale-105 transition">
          <svg class="mx-auto h-16 w-16 mb-4 opacity-90" fill="currentColor" viewBox="0 0 20 20">
            <path d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z" />
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v3a1 1 0 00.293.707l2.5 2.5a1 1 0 101.414-1.414L11 8.586V5z" clip-rule="evenodd" />
          </svg>
          <p class="text-5xl font-bold">{{ stats.total_loss }}</p>
          <p class="text-2xl mt-4 opacity-90">估計損失金額 (元)</p>
        </div>
        <div class="bg-gradient-to-br from-green-500 to-green-700 text-white p-10 rounded-2xl shadow-2xl text-center transform hover:scale-105 transition">
          <svg class="mx-auto h-16 w-16 mb-4 opacity-90" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 011.414-1.414L9 10.586V5a1 1 0 112 0v5.586l1.293-1.293a1 1 0 111.414 1.414z" clip-rule="evenodd" />
          </svg>
          <p class="text-5xl font-bold">{{ stats.count }}</p>
          <p class="text-2xl mt-4 opacity-90">今日上傳筆數</p>
        </div>
      </div>
    </div>

    <!-- 歷史紀錄 -->
    <div class="max-w-7xl mx-auto px-6 pb-16">
      <h2 class="text-3xl font-bold text-center text-gray-800 mb-10">歷史紀錄</h2>
      <div v-if="logs.length === 0" class="text-center text-gray-500 text-xl py-16">
        尚無紀錄，趕快上傳第一張照片吧！
      </div>
      <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8">
        <div v-for="log in logs" :key="log.id" class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
          <img :src="log.image_path" alt="廚餘照片" class="w-full h-64 object-cover" />
          <div class="p-6">
            <p class="text-xl font-bold text-gray-800 truncate">{{ log.food_category }}</p>
            <p class="text-lg text-gray-600 mt-2">{{ log.weight }} kg</p>
            <p class="text-sm text-gray-500 mt-3 line-clamp-2">{{ log.suggestion }}</p>
            <p class="text-xs text-gray-400 mt-4 text-right">{{ formatDate(log.created_at) }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      file: null,
      previewUrl: null,
      result: null,
      logs: [],
      stats: {},
      loading: false
    }
  },
  mounted() {
    this.fetchData()
  },
  methods: {
    onDrop(e) {
      this.file = e.dataTransfer.files[0]
      this.generatePreview()
    },
    generatePreview() {
      if (this.file) {
        this.previewUrl = URL.createObjectURL(this.file)
      }
    },
    async upload() {
      if (!this.file) return
      this.loading = true
      const formData = new FormData()
      formData.append('image', this.file)
      try {
        this.result = (await axios.post('/waste/upload', formData)).data
        this.fetchData()
        this.file = null
        this.previewUrl = null
      } catch (err) {
        alert('上傳失敗，請檢查圖片格式或大小')
      } finally {
        this.loading = false
      }
    },
    async fetchData() {
      try {
        this.logs = (await axios.get('/waste/logs')).data
        this.stats = (await axios.get('/waste/stats')).data
      } catch (err) {
        console.error('載入資料失敗', err)
      }
    },
    formatDate(dateString) {
      const date = new Date(dateString)
      return date.toLocaleDateString('zh-TW', { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' })
    }
  },
  watch: {
    file(newFile) {
      if (newFile) this.generatePreview()
    }
  }
}
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}
.line-clamp-2 {
  overflow: hidden;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
}
</style>