import './bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import AOS from 'aos';
import 'aos/dist/aos.css';
window.addEventListener('load', () => {
    setTimeout(() => {
        AOS.init({
            duration: 2000,
            once: true
        });
    }, 100);
});
