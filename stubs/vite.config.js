import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";
import { viteStaticCopy } from "vite-plugin-static-copy";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "./resources/js/Components/AppServer.jsx",
                "./resources/js/Components/AppClient.jsx",
            ],
            refresh: true,
        }),
        react(),
        viteStaticCopy({
            targets: [
                {
                    src: "./resources/js/Language",
                    dest: "./",
                },
            ],
        }),
    ],
    test: {
        globals: true,
        environment: "jsdom",
        setupFiles: "./resources/js/tests/setup.js",
        exclude: [
            "**/node_modules/**",
            "./vendor/laravel/**",
        ],
    },
    resolve: {
        alias: {
            "@": "/resources/js",
        },
    },
});
