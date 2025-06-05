<template>
  <div class="cat-algorithms">
    <!-- Header -->
    <header class="header">
      <h1>🐱 Cat Algorithms - Iyata SAS</h1>
      <p>Prueba técnica: Algoritmos con temática felina</p>
      <div class="status" :class="{ connected: apiConnected }">
        API: {{ apiConnected ? 'Conectado ✅' : 'Desconectado ❌' }}
      </div>
    </header>

    <!-- Navegación -->
    <nav class="nav-tabs">
      <button 
        v-for="tab in tabs" 
        :key="tab.id"
        @click="activeTab = tab.id"
        :class="{ active: activeTab === tab.id }"
        class="tab-button"
      >
        {{ tab.icon }} {{ tab.name }}
      </button>
    </nav>

    <!-- Contenido -->
    <main class="content">
      
      <!-- Algoritmo 1: Casitas IP -->
      <div v-if="activeTab === 'casitas'" class="algorithm-section">
        <h2>🏠 Las Casitas de los Gatos Numéricos</h2>
        <p>Convierte una cadena de números en direcciones IP válidas</p>
        
        <div class="input-group">
          <label>Cadena de juguetes (solo números):</label>
          <input 
            v-model="casitasInput" 
            type="text" 
            placeholder="25525511135"
            maxlength="20"
          />
          <button @click="resolverCasitas" :disabled="loading" class="btn-primary">
            {{ loading ? 'Procesando...' : '🔍 Encontrar Casitas' }}
          </button>
        </div>

        <div v-if="resultadoCasitas.length > 0" class="results">
          <h3>Direcciones IP encontradas ({{ resultadoCasitas.length }}):</h3>
          <div class="ip-list">
            <div v-for="ip in resultadoCasitas" :key="ip" class="ip-item">
              {{ ip }}
            </div>
          </div>
        </div>
      </div>

      <!-- Algoritmo 2: Siesta Felina -->
      <div v-if="activeTab === 'siesta'" class="algorithm-section">
        <h2>😴 Secuencia de Siesta Felina</h2>
        <p>Encuentra la secuencia consecutiva más larga de collares</p>
        
        <div class="input-group">
          <label>Números de collares (separados por comas):</label>
          <input 
            v-model="siestaInput" 
            type="text" 
            placeholder="100,4,200,1,3,2"
          />
          <button @click="resolverSiesta" :disabled="loading" class="btn-primary">
            {{ loading ? 'Calculando...' : '📏 Calcular Secuencia' }}
          </button>
        </div>

        <div v-if="resultadoSiesta !== null" class="results">
          <h3>Longitud de la secuencia más larga:</h3>
          <div class="sequence-result">{{ resultadoSiesta }}</div>
        </div>
      </div>

      <!-- Algoritmo 3: Maullido Secreto -->
      <div v-if="activeTab === 'maullido'" class="algorithm-section">
        <h2>🗣️ Descifrar Maullido Secreto</h2>
        <p>Descifra un maullido usando el diccionario felino</p>
        
        <div class="input-group">
          <label>Maullido a descifrar:</label>
          <input 
            v-model="maullidoInput" 
            type="text" 
            placeholder="catsanddogs"
          />
          
          <label>Diccionario felino (palabras separadas por comas):</label>
          <textarea 
            v-model="diccionarioInput" 
            placeholder="cat,cats,and,sand,dog,dogs"
            rows="3"
          ></textarea>
          
          <button @click="resolverMaullido" :disabled="loading" class="btn-primary">
            {{ loading ? 'Descifrando...' : '🔮 Descifrar Maullido' }}
          </button>
        </div>

        <div v-if="resultadoMaullido.length > 0" class="results">
          <h3>Posibles interpretaciones ({{ resultadoMaullido.length }}):</h3>
          <div class="interpretations">
            <div v-for="interpretation in resultadoMaullido" :key="interpretation" class="interpretation-item">
              "{{ interpretation }}"
            </div>
          </div>
        </div>
      </div>

      <!-- Info API -->
      <div v-if="activeTab === 'info'" class="algorithm-section">
        <h2>📊 Información de la API</h2>
        <div v-if="apiInfo" class="api-info">
          <div class="info-card">
            <h3>{{ apiInfo.app }}</h3>
            <p><strong>Versión:</strong> {{ apiInfo.version }}</p>
            <p><strong>Descripción:</strong> {{ apiInfo.description }}</p>
            <p><strong>Desarrollador:</strong> {{ apiInfo.developer }}</p>
            <p><strong>Estado:</strong> {{ apiInfo.status }}</p>
          </div>
        </div>
        <div v-else class="loading-info">
          <p>Cargando información de la API...</p>
        </div>
      </div>

    </main>

    <!-- Errores -->
    <div v-if="error" class="error-message">
      ❌ {{ error }}
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'CatAlgorithms',
  data() {
    return {
      activeTab: 'casitas',
      apiConnected: false,
      apiInfo: null,
      error: null,
      loading: false,
      
      // Inputs
      casitasInput: '',
      siestaInput: '',
      maullidoInput: '',
      diccionarioInput: '',
      
      // Results
      resultadoCasitas: [],
      resultadoSiesta: null,
      resultadoMaullido: [],
      
      // Tabs
      tabs: [
        { id: 'casitas', name: 'Casitas IP', icon: '🏠' },
        { id: 'siesta', name: 'Siesta Felina', icon: '😴' },
        { id: 'maullido', name: 'Maullido Secreto', icon: '🗣️' },
        { id: 'info', name: 'Info API', icon: '📊' }
      ]
    }
  },
  
  computed: {
    apiBaseUrl() {
      return import.meta.env.VITE_API_BASE_URL || `https://${window.location.hostname.replace('-5173', '-8000')}/api`
    }
  },
  
  mounted() {
    this.checkApiConnection()
    this.loadApiInfo()
  },
  
  methods: {
    async checkApiConnection() {
      try {
        const response = await axios.get(`${this.apiBaseUrl}/test`)
        this.apiConnected = true
        this.error = null
      } catch (error) {
        this.apiConnected = false
        this.error = 'No se puede conectar con la API del backend'
      }
    },
    
    async loadApiInfo() {
      try {
        const response = await axios.get(`${this.apiBaseUrl}/info`)
        this.apiInfo = response.data
      } catch (error) {
        console.error('Error loading API info:', error)
      }
    },
    
    async resolverCasitas() {
      if (!this.casitasInput.trim()) {
        this.error = 'Por favor ingresa una cadena de números'
        return
      }
      
      this.loading = true
      this.error = null
      
      try {
        const response = await axios.post(`${this.apiBaseUrl}/construir-casitas`, {
          cadenaJuguetes: this.casitasInput.trim()
        })
        this.resultadoCasitas = response.data.data || []
      } catch (error) {
        this.error = error.response?.data?.message || 'Error al procesar las casitas'
      } finally {
        this.loading = false
      }
    },
    
    async resolverSiesta() {
      if (!this.siestaInput.trim()) {
        this.error = 'Por favor ingresa números separados por comas'
        return
      }
      
      this.loading = true
      this.error = null
      
      try {
        const collares = this.siestaInput.split(',').map(n => parseInt(n.trim())).filter(n => !isNaN(n))
        if (collares.length === 0) {
          throw new Error('No se encontraron números válidos')
        }
        
        const response = await axios.post(`${this.apiBaseUrl}/longitud-siesta`, {
          collares: collares
        })
        this.resultadoSiesta = response.data.data
      } catch (error) {
        this.error = error.response?.data?.message || error.message || 'Error al calcular la siesta'
      } finally {
        this.loading = false
      }
    },
    
    async resolverMaullido() {
      if (!this.maullidoInput.trim() || !this.diccionarioInput.trim()) {
        this.error = 'Por favor completa tanto el maullido como el diccionario'
        return
      }
      
      this.loading = true
      this.error = null
      
      try {
        const diccionario = this.diccionarioInput.split(',').map(word => word.trim().toLowerCase()).filter(word => word.length > 0)
        if (diccionario.length === 0) {
          throw new Error('El diccionario no puede estar vacío')
        }
        
        const response = await axios.post(`${this.apiBaseUrl}/descifrar-maullido`, {
          maullido: this.maullidoInput.trim().toLowerCase(),
          diccionarioFelino: diccionario
        })
        this.resultadoMaullido = response.data.data || []
      } catch (error) {
        this.error = error.response?.data?.message || error.message || 'Error al descifrar el maullido'
      } finally {
        this.loading = false
      }
    }
  }
}
</script>

<style scoped>
.cat-algorithms {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.header {
  text-align: center;
  margin-bottom: 30px;
  padding: 20px;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border-radius: 10px;
}

.header h1 {
  margin: 0 0 10px 0;
  font-size: 2.5em;
}

.header p {
  margin: 0 0 15px 0;
  opacity: 0.9;
}

.status {
  display: inline-block;
  padding: 8px 16px;
  border-radius: 20px;
  font-weight: bold;
  background: rgba(255,255,255,0.2);
}

.status.connected {
  background: rgba(76, 175, 80, 0.3);
}

.nav-tabs {
  display: flex;
  justify-content: center;
  margin-bottom: 30px;
  gap: 10px;
  flex-wrap: wrap;
}

.tab-button {
  padding: 12px 24px;
  border: none;
  background: #f5f5f5;
  border-radius: 25px;
  cursor: pointer;
  transition: all 0.3s ease;
  font-size: 16px;
}

.tab-button:hover {
  background: #e0e0e0;
}

.tab-button.active {
  background: #667eea;
  color: white;
}

.algorithm-section {
  background: white;
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
  margin-bottom: 20px;
}

.algorithm-section h2 {
  margin-top: 0;
  color: #333;
  border-bottom: 2px solid #667eea;
  padding-bottom: 10px;
}

.input-group {
  margin-bottom: 20px;
}

.input-group label {
  display: block;
  margin-bottom: 8px;
  font-weight: bold;
  color: #555;
}

.input-group input,
.input-group textarea {
  width: 100%;
  padding: 12px;
  border: 2px solid #ddd;
  border-radius: 5px;
  font-size: 16px;
  margin-bottom: 15px;
  box-sizing: border-box;
}

.input-group input:focus,
.input-group textarea:focus {
  outline: none;
  border-color: #667eea;
}

.btn-primary {
  background: #667eea;
  color: white;
  border: none;
  padding: 12px 24px;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
  transition: background 0.3s ease;
}

.btn-primary:hover:not(:disabled) {
  background: #5a6fd8;
}

.btn-primary:disabled {
  background: #ccc;
  cursor: not-allowed;
}

.results {
  margin-top: 20px;
  padding: 20px;
  background: #f9f9f9;
  border-radius: 5px;
  border-left: 4px solid #667eea;
}

.results h3 {
  margin-top: 0;
  color: #333;
}

.ip-list {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
  gap: 10px;
  margin-bottom: 15px;
}

.ip-item {
  background: white;
  padding: 10px;
  border-radius: 5px;
  text-align: center;
  font-family: 'Courier New', monospace;
  border: 1px solid #ddd;
}

.sequence-result {
  font-size: 3em;
  font-weight: bold;
  text-align: center;
  color: #667eea;
  margin: 20px 0;
}

.interpretations {
  margin-bottom: 15px;
}

.interpretation-item {
  background: white;
  padding: 10px;
  margin: 5px 0;
  border-radius: 5px;
  border-left: 3px solid #667eea;
  font-style: italic;
}

.api-info {
  display: grid;
  gap: 20px;
}

.info-card {
  background: #f9f9f9;
  padding: 20px;
  border-radius: 5px;
  border-left: 4px solid #667eea;
}

.loading-info {
  text-align: center;
  color: #666;
  font-style: italic;
}

.error-message {
  background: #ffebee;
  color: #c62828;
  padding: 15px;
  border-radius: 5px;
  margin-top: 20px;
  border-left: 4px solid #c62828;
}

@media (max-width: 768px) {
  .cat-algorithms {
    padding: 10px;
  }
  
  .header h1 {
    font-size: 2em;
  }
  
  .nav-tabs {
    flex-direction: column;
  }
  
  .algorithm-section {
    padding: 20px;
  }
}
</style>