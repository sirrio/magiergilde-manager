import { defineConfig } from "vite"
import laravel from "laravel-vite-plugin"
import vue from "@vitejs/plugin-vue"
import tailwindcss from "@tailwindcss/vite"
import path from "path"
import { resolve } from "node:path"

export default defineConfig({
  plugins: [
    laravel({
      input: ["resources/js/app.ts"],
      refresh: true,
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
    tailwindcss(),
  ],
  resolve: {
    alias: {
      "@": path.resolve(__dirname, "./resources/js"),
      "ziggy-js": resolve(__dirname, "vendor/tightenco/ziggy"),
    },
  },
  css: {
    postcss: {
      plugins: [tailwindcss],
    },
  },
})
