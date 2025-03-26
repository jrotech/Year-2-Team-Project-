// vite.config.js
import { defineConfig } from "file:///C:/Users/jacob/OneDrive%20-%20Aston%20University/School%20Work/CS2TP/Year-2-Team-Project-/node_modules/vite/dist/node/index.js";
import laravel from "file:///C:/Users/jacob/OneDrive%20-%20Aston%20University/School%20Work/CS2TP/Year-2-Team-Project-/node_modules/laravel-vite-plugin/dist/index.js";
import reactRefresh from "file:///C:/Users/jacob/OneDrive%20-%20Aston%20University/School%20Work/CS2TP/Year-2-Team-Project-/node_modules/@vitejs/plugin-react-refresh/index.js";
var vite_config_default = defineConfig({
  plugins: [
    laravel({
      input: [
        "resources/sass/app.scss",
        "resources/css/app.css",
        "resources/js/app.js",
        "resources/js/about/page.js",
        "resources/js/basket/page.js",
        "resources/js/checkout/page.js",
        "resources/js/dashboard/page.js",
        "resources/js/contact/page.js",
        "resources/js/home/page.js",
        "resources/js/order/page.js",
        "resources/js/product/page.js",
        "resources/js/orders/page.js",
        "resources/js/shop/page.js",
        "resources/js/constants.js",
        "resources/js/mantine.jsx"
      ],
      refresh: true
    }),
    reactRefresh()
  ]
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJDOlxcXFxVc2Vyc1xcXFxqYWNvYlxcXFxPbmVEcml2ZSAtIEFzdG9uIFVuaXZlcnNpdHlcXFxcU2Nob29sIFdvcmtcXFxcQ1MyVFBcXFxcWWVhci0yLVRlYW0tUHJvamVjdC1cIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfZmlsZW5hbWUgPSBcIkM6XFxcXFVzZXJzXFxcXGphY29iXFxcXE9uZURyaXZlIC0gQXN0b24gVW5pdmVyc2l0eVxcXFxTY2hvb2wgV29ya1xcXFxDUzJUUFxcXFxZZWFyLTItVGVhbS1Qcm9qZWN0LVxcXFx2aXRlLmNvbmZpZy5qc1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9pbXBvcnRfbWV0YV91cmwgPSBcImZpbGU6Ly8vQzovVXNlcnMvamFjb2IvT25lRHJpdmUlMjAtJTIwQXN0b24lMjBVbml2ZXJzaXR5L1NjaG9vbCUyMFdvcmsvQ1MyVFAvWWVhci0yLVRlYW0tUHJvamVjdC0vdml0ZS5jb25maWcuanNcIjtpbXBvcnQgeyBkZWZpbmVDb25maWcgfSBmcm9tICd2aXRlJztcbmltcG9ydCBsYXJhdmVsIGZyb20gJ2xhcmF2ZWwtdml0ZS1wbHVnaW4nO1xuaW1wb3J0IHJlYWN0UmVmcmVzaCBmcm9tICdAdml0ZWpzL3BsdWdpbi1yZWFjdC1yZWZyZXNoJztcblxuZXhwb3J0IGRlZmF1bHQgZGVmaW5lQ29uZmlnKHtcbiAgICBwbHVnaW5zOiBbXG4gICAgICAgIGxhcmF2ZWwoe1xuICAgICAgICAgICAgaW5wdXQ6IFtcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL3Nhc3MvYXBwLnNjc3MnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvY3NzL2FwcC5jc3MnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvanMvYXBwLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2pzL2Fib3V0L3BhZ2UuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvanMvYmFza2V0L3BhZ2UuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvanMvY2hlY2tvdXQvcGFnZS5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9qcy9kYXNoYm9hcmQvcGFnZS5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9qcy9jb250YWN0L3BhZ2UuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvanMvaG9tZS9wYWdlLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2pzL29yZGVyL3BhZ2UuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvanMvcHJvZHVjdC9wYWdlLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2pzL29yZGVycy9wYWdlLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2pzL3Nob3AvcGFnZS5qcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9qcy9jb25zdGFudHMuanMnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvanMvbWFudGluZS5qc3gnLFxuICAgICAgICAgICAgXSxcbiAgICAgICAgICAgIHJlZnJlc2g6IHRydWUsXG4gICAgICAgIH0pLFxuICAgICAgICByZWFjdFJlZnJlc2goKSxcbiAgICBdLFxufSk7XG4iXSwKICAibWFwcGluZ3MiOiAiO0FBQTJiLFNBQVMsb0JBQW9CO0FBQ3hkLE9BQU8sYUFBYTtBQUNwQixPQUFPLGtCQUFrQjtBQUV6QixJQUFPLHNCQUFRLGFBQWE7QUFBQSxFQUN4QixTQUFTO0FBQUEsSUFDTCxRQUFRO0FBQUEsTUFDSixPQUFPO0FBQUEsUUFDSDtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsTUFDSjtBQUFBLE1BQ0EsU0FBUztBQUFBLElBQ2IsQ0FBQztBQUFBLElBQ0QsYUFBYTtBQUFBLEVBQ2pCO0FBQ0osQ0FBQzsiLAogICJuYW1lcyI6IFtdCn0K
