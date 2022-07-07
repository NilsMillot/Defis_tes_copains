import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
import {resolve} from 'path'

const twigRefreshPlugin = {
  name: 'twigRefresh',
  configureServer ({watcher, ws}){
    watcher.add(resolve('templates/**/*.twig'))
    watcher.on('change', function (path) {
      if(path.endsWith('.twig')) {
        ws.send({
          type: 'full-reload'
        })
      }
    })
  }
}

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [react(), twigRefreshPlugin],
  root: './assets',
  base: '/assets/',
  server: {
    watch: {
      // permit to understand stars for templates/**/*.twig
      disableGlobbing: false
    }
  },
  build: {
    // give manifest.son (permit to have build's information like main.jsx{{hash}}.js etc.)
    manifest: true,
    // disallow node of 2 directory assets
    assetsDir: '',
    outDir: '../public/assets/',
    rollupOptions: {
      // don't generate vendor.js in public/assets (only one entrypoint needed actually)
      output: {
        manualChunks: undefined
      },
      input: {
        'main.jsx': './main.jsx'
      }
    }
  },
})
