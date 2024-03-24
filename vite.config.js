import { defineConfig } from "vite";
import laravel, { refreshPaths } from "laravel-vite-plugin";
import purge from "@erbelion/vite-plugin-laravel-purgecss";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: [
                "app/Livewire/**",
                "resources/routes/**",
                "routes/**",
                "resources/views/**",
                "resources/views/**/*.blade.php",
            ],
        }),
        // purge({
        //     templates: ["blade"],
        // }),
    ],
    build: {
        // css: {
        //     minify: "cssnano",
        //     extract: true,
        //     // Enable CSS purging
        //     terserOptions: {
        //         format: {
        //             comments: false,
        //         },
        //     },
        //     // codeSplit: true,
        // },
        css: {
            codeSplit: true,
        },
    },
});
