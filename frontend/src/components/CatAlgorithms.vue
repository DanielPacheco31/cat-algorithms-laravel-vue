<template>
  <div class="min-h-screen bg-gradient-to-br from-orange-50 to-amber-50 p-4">
    <!-- Header -->
    <header class="text-center mb-8">
      <div class="inline-flex items-center justify-center p-4 bg-white rounded-full shadow-lg mb-4">
        <span class="text-6xl">🐱</span>
      </div>
      <h1 class="text-4xl font-bold text-orange-800 mb-2">
        Cat Algorithms 🐾
      </h1>
      <p class="text-orange-600 mb-4">
        Algoritmos adorables con temática felina
      </p>
      
      <!-- Estado de la API -->
      <div class="inline-flex items-center space-x-2 px-4 py-2 rounded-full" 
           :class="apiStatus === 'connected' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
        <div class="w-2 h-2 rounded-full" 
             :class="apiStatus === 'connected' ? 'bg-green-500' : 'bg-red-500'"></div>
        <span class="text-sm font-medium">
          {{ apiStatus === 'connected' ? 'API Conectada ✅' : 'API Desconectada ❌' }}
        </span>
      </div>
    </header>

    <!-- Grid de Algoritmos -->
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
      
      <!-- 1. Las Casitas de los Gatos Numéricos -->
      <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-orange-100 hover:border-orange-200 transition-all">
        <div class="text-center mb-6">
          <div class="text-4xl mb-2">🏠</div>
          <h2 class="text-2xl font-bold text-orange-800 mb-2">
            Las Casitas de los Gatos
          </h2>
          <p class="text-gray-600 text-sm">
            Convierte dígitos en direcciones IP válidas
          </p>
        </div>

        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Dígitos para las casitas 🔢
            </label>
            <input
              v-model="casitas.input"
              type="text"
              placeholder="Ej: 25525511135"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
              :disabled="casitas.loading"
            />
            <p class="text-xs text-gray-500 mt-1">
              Entre 4 y 12 dígitos
            </p>
          </div>

          <button
            @click="construirCasitas"
            :disabled="casitas.loading || !casitas.input"
            class="w-full bg-orange-500 hover:bg-orange-600 disabled:bg-gray-300 text-white font-medium py-2 px-4 rounded-lg transition-colors"
          >
            {{ casitas.loading ? '🐱 Construyendo...' : '🏗️ Construir Casitas' }}
          </button>

          <!-- Ejemplo -->
          <button
            @click="usarEjemploCasitas"
            class="w-full text-orange-600 hover:text-orange-700 text-sm underline"
          >
            📝 Usar ejemplo: "25525511135"
          </button>

          <!-- Resultados -->
          <div v-if="casitas.result" class="mt-4 p-4 bg-orange-50 rounded-lg">
            <h3 class="font-semibold text-orange-800 mb-2 flex items-center">
              <span class="mr-2">{{ casitas.result.cat_reaction }}</span>
              Resultados ({{ casitas.result.total_casitas }} casitas)
            </h3>
            <div class="space-y-1 max-h-32 overflow-y-auto">
              <div
                v-for="(ip, index) in casitas.result.casitas_ip"
                :key="index"
                class="text-sm font-mono bg-white px-2 py-1 rounded border"
              >
                {{ ip }}
              </div>
            </div>
          </div>

          <!-- Error -->
          <div v-if="casitas.error" class="mt-4 p-4 bg-red-50 rounded-lg">
            <p class="text-red-800 text-sm">
              😿 {{ casitas.error }}
            </p>
          </div>
        </div>
      </div>

      <!-- 2. Secuencia de Siesta Felina -->
      <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-purple-100 hover:border-purple-200 transition-all">
        <div class="text-center mb-6">
          <div class="text-4xl mb-2">😴</div>
          <h2 class="text-2xl font-bold text-purple-800 mb-2">
            Secuencia de Siesta
          </h2>
          <p class="text-gray-600 text-sm">
            Encuentra la secuencia consecutiva más larga
          </p>
        </div>

        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Collares de los gatos 📿
            </label>
            <input
              v-model="siesta.input"
              type="text"
              placeholder="Ej: 100,4,200,1,3,2"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
              :disabled="siesta.loading"
            />
            <p class="text-xs text-gray-500 mt-1">
              Números separados por comas
            </p>
          </div>

          <button
            @click="calcularSiesta"
            :disabled="siesta.loading || !siesta.input"
            class="w-full bg-purple-500 hover:bg-purple-600 disabled:bg-gray-300 text-white font-medium py-2 px-4 rounded-lg transition-colors"
          >
            {{ siesta.loading ? '😴 Calculando...' : '🔍 Calcular Siesta' }}
          </button>

          <!-- Ejemplo -->
          <button
            @click="usarEjemploSiesta"
            class="w-full text-purple-600 hover:text-purple-700 text-sm underline"
          >
            �� Usar ejemplo: "100,4,200,1,3,2"
          </button>

          <!-- Resultados -->
          <div v-if="siesta.result" class="mt-4 p-4 bg-purple-50 rounded-lg">
            <h3 class="font-semibold text-purple-800 mb-2 flex items-center">
              <span class="mr-2">{{ siesta.result.cat_reaction }}</span>
              Longitud máxima: {{ siesta.result.longitud_maxima }}
            </h3>
            <p class="text-sm text-purple-700">
              De {{ siesta.result.total_gatos }} gatos en total
            </p>
          </div>

          <!-- Error -->
          <div v-if="siesta.error" class="mt-4 p-4 bg-red-50 rounded-lg">
            <p class="text-red-800 text-sm">
              😿 {{ siesta.error }}
            </p>
          </div>
        </div>
      </div>

      <!-- 3. Descifrando el Maullido Secreto -->
      <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-blue-100 hover:border-blue-200 transition-all">
        <div class="text-center mb-6">
          <div class="text-4xl mb-2">🔍</div>
          <h2 class="text-2xl font-bold text-blue-800 mb-2">
            Maullido Secreto
          </h2>
          <p class="text-gray-600 text-sm">
            Segmenta mensajes usando un diccionario
          </p>
        </div>

        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Mensaje secreto 📝
            </label>
            <input
              v-model="maullido.mensaje"
              type="text"
              placeholder="Ej: catsanddogs"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              :disabled="maullido.loading"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Diccionario felino 📚
            </label>
            <input
              v-model="maullido.diccionario"
              type="text"
              placeholder="Ej: cat,cats,and,sand,dog,dogs"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
              :disabled="maullido.loading"
            />
            <p class="text-xs text-gray-500 mt-1">
              Palabras separadas por comas
            </p>
          </div>

          <button
            @click="descifrarMaullido"
            :disabled="maullido.loading || !maullido.mensaje || !maullido.diccionario"
            class="w-full bg-blue-500 hover:bg-blue-600 disabled:bg-gray-300 text-white font-medium py-2 px-4 rounded-lg transition-colors"
          >
            {{ maullido.loading ? '🔍 Descifrando...' : '🕵️ Descifrar Maullido' }}
          </button>

          <!-- Ejemplo -->
          <button
            @click="usarEjemploMaullido"
            class="w-full text-blue-600 hover:text-blue-700 text-sm underline"
          >
            📝 Usar ejemplo predefinido
          </button>

          <!-- Resultados -->
          <div v-if="maullido.result" class="mt-4 p-4 bg-blue-50 rounded-lg">
            <h3 class="font-semibold text-blue-800 mb-2 flex items-center">
              <span class="mr-2">{{ maullido.result.cat_reaction }}</span>
              {{ maullido.result.total_formas }} formas encontradas
            </h3>
            <div class="space-y-1 max-h-32 overflow-y-auto">
              <div
                v-for="(segmentacion, index) in maullido.result.segmentaciones"
                :key="index"
                class="text-sm bg-white px-2 py-1 rounded border"
              >
                {{ segmentacion.join(' • ') }}
              </div>
            </div>
          </div>

          <!-- Error -->
          <div v-if="maullido.error" class="mt-4 p-4 bg-red-50 rounded-lg">
            <p class="text-red-800 text-sm">
              😿 {{ maullido.error }}
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="text-center mt-12 text-gray-500">
      <p class="text-sm">
        Hecho con ❤️ para gatos programadores 🐱‍💻
      </p>
      <p class="text-xs mt-1">
        Laravel + Vue.js + Algoritmos Felinos
      </p>
    </footer>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'CatAlgorithms',
  data() {
    return {
      // Estado de la API
      apiStatus: 'disconnected',
      
      // API Base URL
      apiUrl: this.getApiUrl(),
      
      // Estado de Casitas
      casitas: {
        input: '',
        loading: false,
        result: null,
        error: null
      },
      
      // Estado de Siesta
      siesta: {
        input: '',
        loading: false,
        result: null,
        error: null
      },
      
      // Estado de Maullido
      maullido: {
        mensaje: '',
        diccionario: '',
        loading: false,
        result: null,
        error: null
      }
    }
  },
  
  mounted() {
    this.checkApiConnection()
    this.configurarAxios()
  },
  
  methods: {
    getApiUrl() {
      // Detectar si estamos en GitHub Codespaces
      if (window.location.hostname.includes('app.github.dev')) {
        const hostname = window.location.hostname
        const codespace = hostname.split('-')[0]
        return `https://${codespace}-8000.app.github.dev`
      }
      return 'http://localhost:8000'
    },
    
    configurarAxios() {
      axios.defaults.baseURL = this.apiUrl + '/api'
      axios.defaults.headers.common['Accept'] = 'application/json'
      axios.defaults.headers.common['Content-Type'] = 'application/json'
      axios.defaults.timeout = 10000
    },
    
    async checkApiConnection() {
      try {
        const response = await axios.get('/test')
        if (response.data.status === 'success') {
          this.apiStatus = 'connected'
        }
      } catch (error) {
        this.apiStatus = 'disconnected'
        console.error('Error conectando con la API:', error)
      }
    },
    
    // Métodos para Casitas
    async construirCasitas() {
      this.casitas.loading = true
      this.casitas.error = null
      this.casitas.result = null
      
      try {
        const response = await axios.post('/construir-casitas', {
          digitos: this.casitas.input.trim()
        })
        this.casitas.result = response.data
      } catch (error) {
        this.casitas.error = error.response?.data?.message || 'Error al construir casitas'
      } finally {
        this.casitas.loading = false
      }
    },
    
    usarEjemploCasitas() {
      this.casitas.input = '25525511135'
      this.casitas.result = null
      this.casitas.error = null
    },
    
    // Métodos para Siesta
    async calcularSiesta() {
      this.siesta.loading = true
      this.siesta.error = null
      this.siesta.result = null
      
      try {
        const collares = this.siesta.input
          .split(',')
          .map(num => parseInt(num.trim()))
          .filter(num => !isNaN(num))
        
        if (collares.length === 0) {
          throw new Error('Por favor ingresa números válidos')
        }
        
        const response = await axios.post('/longitud-siesta', {
          collares: collares
        })
        this.siesta.result = response.data
      } catch (error) {
        this.siesta.error = error.response?.data?.message || error.message || 'Error al calcular siesta'
      } finally {
        this.siesta.loading = false
      }
    },
    
    usarEjemploSiesta() {
      this.siesta.input = '100,4,200,1,3,2'
      this.siesta.result = null
      this.siesta.error = null
    },
    
    // Métodos para Maullido
    async descifrarMaullido() {
      this.maullido.loading = true
      this.maullido.error = null
      this.maullido.result = null
      
      try {
        const diccionario = this.maullido.diccionario
          .split(',')
          .map(word => word.trim())
          .filter(word => word.length > 0)
        
        if (diccionario.length === 0) {
          throw new Error('Por favor ingresa palabras válidas en el diccionario')
        }
        
        const response = await axios.post('/descifrar-maullido', {
          mensaje: this.maullido.mensaje.trim(),
          diccionario: diccionario
        })
        this.maullido.result = response.data
      } catch (error) {
        this.maullido.error = error.response?.data?.message || error.message || 'Error al descifrar maullido'
      } finally {
        this.maullido.loading = false
      }
    },
    
    usarEjemploMaullido() {
      this.maullido.mensaje = 'catsanddogs'
      this.maullido.diccionario = 'cat,cats,and,sand,dog,dogs'
      this.maullido.result = null
      this.maullido.error = null
    }
  }
}
</script>

<style scoped>
::-webkit-scrollbar {
  width: 6px;
}

::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 3px;
}

::-webkit-scrollbar-thumb {
  background: #c1c1c1;
  border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
  background: #a1a1a1;
}
</style>
