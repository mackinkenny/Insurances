require('./bootstrap');

// Import modules...
import { createApp, h } from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import VCalendar from 'v-calendar';
import { Lang } from 'laravel-vue-lang';
import Maska from "maska";

const el = document.getElementById('app');

createApp({
    render: () =>
        h(InertiaApp, {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: (name) => require(`./Pages/${name}`).default,
        }),
})
    .mixin({ methods: { route } })
    .use(InertiaPlugin)
    .use(Maska)
    .use(VCalendar, {})
    .use(Lang, {fallback: 'en',})
    .mount(el);

el.removeAttribute('data-page');
InertiaProgress.init({ color: '#4B5563' });
