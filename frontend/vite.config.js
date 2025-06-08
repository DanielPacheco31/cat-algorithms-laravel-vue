import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

const codespaceName = process.env.CODESPACE_NAME
let backendUrl = 'http://localhost:8000'
if (codespaceName) {
  backendUrl = `https://${codespaceName}-8000.app.github.dev`
}

export default defineConfig({
  plugins: [vue()],
  server: {
    host: '0.0.0.0',
    port: 5173,
    strictPort: true,
    proxy: {
      '/api': {
        target: backendUrl,
        changeOrigin: true,
        secure: true
      }
    }
  }
})
