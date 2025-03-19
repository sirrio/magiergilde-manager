import '../css/app.css'
import './bootstrap'

import { library } from '@fortawesome/fontawesome-svg-core'
import { fab } from '@fortawesome/free-brands-svg-icons'
import { far } from '@fortawesome/free-regular-svg-icons'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { createApp, DefineComponent, h } from 'vue'
import { ZiggyVue } from 'ziggy-js'

library.add(fas, far, fab)

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob<DefineComponent>('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    const VueApp = createApp({ render: () => h(App, props) })
    VueApp.component('FontAwesomeIcon', FontAwesomeIcon)
    VueApp.use(plugin).use(ZiggyVue).mount(el)
  },
  progress: {
    color: '#4B5563',
  },
}).then(() => {
  console.log('App started')
})
